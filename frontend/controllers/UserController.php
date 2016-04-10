<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\UserDetails;
use frontend\models\NotificationList;
use frontend\models\UserNotificationRel;
use frontend\models\InviteFriends;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\Url;
use yii\web\Response;
use yii\helpers\ArrayHelper;


use frontend\models\Rest;
use frontend\models\Package;
use frontend\models\PurchaseHistroy;
use frontend\models\TransactionHistroy;
use frontend\models\Userexamrel;
use frontend\models\Membershiprequest;
use frontend\models\Discounts;




/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    public function beforeAction($action){
        
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['backend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['backend.theme'],
        ]);

        return parent::beforeAction($action);
    }

    public function actionDiscountsverification(){
       
       $discounts_model = new Discounts();

        if ($discounts_model->load(Yii::$app->request->post()) ) {

            $discounts_code = $discounts_model->discounts_code;

            $total_amount = $_POST['total_amount'];
            $vat_amount = $_POST['vat_amount'];

            $current_date = Date('Y-m-d');
            $validate_data = Discounts::find()
                            ->where(['discounts_code' => $discounts_code])
                            ->andWhere(['<=', 'start_date', $current_date])
                            ->andWhere(['>=', 'end_date', $current_date])
                            ->andWhere(['status' => 1])
                            ->one();

            if($validate_data){

                $calculate_data = $this->renderPartial('_discount_calculate_data',[
                        'validate_data' => $validate_data,
                        'total_amount' => $total_amount,
                        'vat_amount' => $vat_amount
                ]);
                
                $response['status'] = '1';
                $response['discounts_value'] = $validate_data->discounts_amount;
                $response['discounts_code'] = $validate_data->discounts_code;
                $response['calculate_data'] = $calculate_data;
                $response['message'] = "Discounts code successfully applied";

            }else{
                $response['message'] = "Invalid discounts code";

            }

            return json_encode($response);
        }
    }

    public function actionPaymentsuccess(){

        if(isset($_POST)){

           $payment_method = $_POST['payment_method'];
           $invoice_no = $_POST['invoice_no'];
           $package_id = $_POST['package_id'];
           $discount_value = $_POST['discount_value'];
           $discount_code = $_POST['discount_code'];
           $vat = $_POST['vat'];


           if(empty($discount_value)){
                $discount_value = 0;
                $discounts_data = '';
           }else{
                $discounts_data = Discounts::find()->where(['discounts_code' => $discount_code])->one();
           }

           if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_type == 'student'){

               
                $package = Package::find()->where(['id'=>$package_id])->one();

                $model = Yii::$app->user->identity;

                $membership_model = new Membershiprequest();

                $membership_model->user_id = $model->id;
                $membership_model->invoice_id = $invoice_no;
                $membership_model->payment_type = $payment_method;
                $membership_model->package_id = $package_id;
                $membership_model->vat = $vat;
                $membership_model->discount = $discount_value;
                $membership_model->discounts_code = $discount_code;
                $membership_model->status = 0;

                // $membership_model->validate();
                //      var_dump($membership_model->getErrors());
                //      exit();
                if($membership_model->save()){

                    $message = Yii::$app->mailer->compose();

                    $mail_data = $this->renderPartial('_membership_mail_template',[
                            'invoice_no' => $invoice_no,
                            'package' => $package,
                            'model' => $model,
                            'membership_model' => $membership_model,
                            'discounts_data' => $discounts_data
                        ]);
                   

                    //$message->setFrom('modeltest.abedon@gmail.com=>'Admin');
                    $message->SetFrom(["modeltest.abedon@gmail.com"=>"support@model-test.com"]);
                    $message->setTo($model->email);
                    // $message->setCc(array(Yii::$app->params['contact_email']));
                    $message->setSubject("Membership package | Model Test");
                    $message->setHtmlBody($mail_data);
                    $message->send();

                    return $this->render('success',[
                            'invoice_no' => $invoice_no,
                            'package' => $package,
                            'model' => $model,
                            'membership_model' => $membership_model,
                            'discounts_data' => $discounts_data
                        ]);


                }

               

           }else{
                return $this->goHome();
           }
        }else{

            throw new NotFoundHttpException('The requested package does not exist.');
        }

    }


    public function actionSuccess($id){

        if(!isset(Yii::$app->user->identity->id)){
            $session = Yii::$app->session;
            $session->set('redirect_url','user/success/'.$id);
            $this->redirect(\Yii::$app->urlManager->createUrl("site/login"));  
        }
        $user_id = Yii::$app->user->identity->id;
        $package = Package::find()->where(['id'=>$id])->one();
        if(empty($package)){
            throw new NotFoundHttpException('The requested package does not exist.');
        }
        $payment_id = 'p_'.time();
        $points = (int) explode(' pts', $package->package_type)[0];
        $expire_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. $package->duration.' days'));
        
        $PurchaseHistroy_model = new PurchaseHistroy();
        $PurchaseHistroy_model->package_name = $package->package_type;
        $PurchaseHistroy_model->points = $points;
        $PurchaseHistroy_model->price = $package->price_bd;
        $PurchaseHistroy_model->payment_id = $payment_id;
        $PurchaseHistroy_model->payment_type = 'card';
        $PurchaseHistroy_model->duration = $package->duration;
        $PurchaseHistroy_model->start_date = date('Y-m-d');
        $PurchaseHistroy_model->end_date = $expire_date;
        $PurchaseHistroy_model->user_id = $user_id;



        if($PurchaseHistroy_model->save()){

            $package = Package::find()->where(['id'=>$id])->one();
            if(empty($package)){
                throw new NotFoundHttpException('The requested package does not exist.');
            }

            $id = Yii::$app->user->identity->id;
            $model = $this->findModel($id);

            $message = Yii::$app->mailer->compose();

            $mail_data = $this->renderPartial('_membership_mail_template',[
                    'package' => $package,
                    'model' => $model
                ]);
            $message->SetFrom(["modeltest.abedon@gmail.com"=>"support@model-test.com"]);
            $message->setTo($model->email);
            $message->setSubject("Invite friend | Model Test");
            $message->setHtmlBody($mail_data);
            $message->send();



            $user_data = User::find()->where(['id'=>$user_id])->one();

            $purchased_package_id = Rest::save_purchased_package($user_id, $package->package_type, $points, $expire_date);
            Rest::save_transaction_history( $user_id, $points, '+', 'purchase', '', $purchased_package_id);

            $user_data->save();

            return $this->render('success',['history'=>$PurchaseHistroy_model]);
        }else{

        }

    }

    
    public function actionConfirm_purchase($id){

        if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_type =='student'){

            $package = Package::find()->where(['id'=>$id])->one();
            if(empty($package)){
                throw new NotFoundHttpException('The requested package does not exist.');
            }

            $id = Yii::$app->user->identity->id;
            $model = $this->findModel($id);

            $discounts_model = new Discounts();

            return $this->render('confirm_purchase',[
                    'package' => $package,
                    'model' => $model,
                    'discounts_model' => $discounts_model
                ]);

        }else{

            return $this->goHome();

        }
        



       
        
    }

   
    public function actionEdit(){
        if(isset(Yii::$app->user->identity->user_type)){

            $id = Yii::$app->user->identity->id;
            $model = $this->findModel($id);

            $details_model = UserDetails::find()->where(['user_id' => $id])->one();


            $model->scenario = 'change_password';

            if ($model->load(Yii::$app->request->post()) && $details_model->load(Yii::$app->request->post())) {

                

                if($model->save() && $details_model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                
            }


            $notification_list = NotificationList::find()->all();

            $current_date = Date('Y-m-d');

            $command = Yii::$app->db->createCommand("SELECT sum(points) FROM purchased_package where expired_date >= $current_date && user_id = $model->id ");
            $sum_of_points = $command->queryScalar();

            $command_max_date = Yii::$app->db->createCommand("SELECT max(expired_date) FROM purchased_package where expired_date >= $current_date && user_id = $model->id ");
            $generate_expired_date = $command_max_date->queryScalar();

            $get_all_invite_friends_r = InviteFriends::find()
                                        ->where(['user_id' => $model->id])
                                        ->all();

            $transaction_history = TransactionHistroy::find()->where(['user_id'=>$id])
                                                             ->andWhere(['action'=> '-'])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset(0)
                                                             ->all();

            $transaction_history_added = TransactionHistroy::find()->where(['user_id'=>$id])
                                                             ->andWhere(['action'=> '+'])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset(0)
                                                             ->all();

            $PurchaseHistroy = PurchaseHistroy::find()->where(['user_id'=>$id])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset(0)
                                                             ->all();

            return $this->render('update', [
                'model' => $model,
                'details_model' => $details_model,
                'notification_list' => $notification_list,
                'sum_of_points' => $sum_of_points,
                'generate_expired_date' => $generate_expired_date,
                'get_all_invite_friends_r' => $get_all_invite_friends_r,
                'transaction_history' => $transaction_history,
                'transaction_history_added' => $transaction_history_added,
                'PurchaseHistroy' => $PurchaseHistroy
            ]);

        }else{
            return $this->goHome();
        }
   }

   public function actionView(){

        if(isset(Yii::$app->user->identity->user_type)){


            $id = Yii::$app->user->identity->id;
            $model = $this->findModel($id);
            $details_model = UserDetails::find()->where(['user_id' => $id])->one();

            $get_all_notification_r = UserNotificationRel::find()
                                        ->where(['user_id'=>$model->id])
                                        ->all();

            $my_invite_friends_r = InviteFriends::find()
                                    ->where(['user_id'=>$model->id])
                                    ->all();

            $current_date = Date('Y-m-d');

            $command = Yii::$app->db->createCommand("SELECT sum(points) FROM purchased_package where expired_date >= $current_date && user_id = $model->id ");
            $sum_of_points = $command->queryScalar();

            $command_max_date = Yii::$app->db->createCommand("SELECT max(expired_date) FROM purchased_package where expired_date >= $current_date && user_id = $model->id ");
            $generate_expired_date = $command_max_date->queryScalar();

            $transaction_history = TransactionHistroy::find()->where(['user_id'=>$id])
                                                             ->andWhere(['action' => '-'])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset(0)
                                                             ->all();

             $transaction_history_added = TransactionHistroy::find()->where(['user_id'=>$id])
                                                             ->andWhere(['action'=> '+'])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset(0)
                                                             ->all();

            $PurchaseHistroy = PurchaseHistroy::find()->where(['user_id'=>$id])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset(0)
                                                             ->all();


            $get_all_invite_friends_r = InviteFriends::find()
                                        ->where(['user_id' => $model->id])
                                        ->all();

            return $this->render('view', [
                'model' => $model,
                'details_model' => $details_model,
                'get_all_notification_r' => $get_all_notification_r,
                'my_invite_friends_r' => $my_invite_friends_r,
                'sum_of_points' => $sum_of_points,
                'generate_expired_date' => $generate_expired_date,
                'transaction_history' => $transaction_history,
                'transaction_history_added' => $transaction_history_added,
                'PurchaseHistroy' => $PurchaseHistroy,
                'get_all_invite_friends_r' => $get_all_invite_friends_r
            ]);

        }else{
            return $this->goHome();
        }    
   }


   public function actionChangepassword(){

        $post_model = new User();

        $post_model->scenario = 'change_password';

        
        if($post_model->load(Yii::$app->request->post())){


            if($post_model->validate()){

                $id = Yii::$app->user->identity->id;
                $model = $this->findModel($id); 
                
                $model->password = Yii::$app->security->generatePasswordHash($post_model->new_password);
                
                if($model->save()){
                    $response['base_url'] = Url::base();
                    $response['success'] = 1;
                    $response['message'] = "<div class='btn btn-success'>Successfully save</div>";
                }
                
            }else{
                $response['message'] = "<div class='btn btn-warning'>Password not match</div>";
            }
            
        }
        
        return json_encode($response);
   }

   public function actionInfo_edit(){

        if(isset(Yii::$app->user->identity->user_type)){

            $id = Yii::$app->user->identity->id;
            $model = $this->findModel($id);

            $presentinstitution = $model->institution_id;
            
            $profile_image = $model->image;
            $details_model = UserDetails::find()->where(['user_id' => $id])->one();

            $valid = $details_model->validate();

            
            if ($model->load(Yii::$app->request->post()) && $details_model->load(Yii::$app->request->post())) {

                if($details_model->profile_complete == 0){
                    
                    if(!empty($model->name) && !empty($details_model->date_of_birth) && !empty($model->phone) && !empty($details_model->gender) && !empty($model->address) && !empty($profile_image) ){
                        $details_model->profile_complete = 1;

                        $point = Rest::get_point_from_point_table('signup');

                        $model->free_point = $model->free_point + $point;

                        Rest::save_transaction_history($model->id,$point,'+','signup','');
                    }else{
                       
                    }

                }
                
                $model->image = $profile_image;

                if($presentinstitution != $model->institution_id){
                    $model->approved_by_institution = 0;
                }
                
                if($model->save() && $details_model->save()){
                    $response['base_url'] = Url::base();
                    $response['success'] = 1;
                    $response['message'] = "<div class='btn btn-success'>Successfully save</div>";
                }else{
                    $response['message'] = "<div class='btn btn-warning'>Successfully not save</div>";
                }
                
            }

            

            return json_encode($response);
        }else{

            return $this->goHome();
        }
   }

   public function actionSet_shareing(){

        if(isset(Yii::$app->user->identity->user_type)){

            $id = Yii::$app->user->identity->id;
            $model = $this->findModel($id);
           
            if(isset($_POST)){      

                
                                                ;
                UserNotificationRel::deleteAll('user_id = :user_id', [':user_id' => $model->id]);

                $usernotification_value = $_POST['NotificationList']['name'];

                
                   for($i=0;$i<count($usernotification_value); $i++){
                        
                        $usernotification_model = new UserNotificationRel();
                        $usernotification_model->user_id = $model->id;
                        $usernotification_model->notification_id = $usernotification_value[$i];

                        $usernotification_model->save();
                        
                   }

                   $response['message'] = "<div class='btn btn-success'>Successfully save</div>";
                   return json_encode($response);
                
            }
        }else{
            return $this->goHome();
        }
   }

   public function actionInvite_friends(){

        if(isset(Yii::$app->user->identity->user_type)){

            $id = Yii::$app->user->identity->id;
            $model = $this->findModel($id);

            if(isset($_POST) ){
               

                $invite_frinds_value = $_POST['InviteFriends']['invite_friends'];

                $invite_friend_model = new InviteFriends();
                $invite_friend_model->user_id = $model->id;
                $invite_friend_model->invite_friends_email = $invite_frinds_value;

                $text = 'Hello Someone invite to attend model test site. Please check view. ';
                $text .= '<a href="'.Yii::$app->urlManager->createAbsoluteUrl(['/site/index']).'">Click Here</a>';

                $find_already_invite = InviteFriends::find()
                                        ->where(['invite_friends_email' => $invite_friend_model->invite_friends_email])
                                        ->one();

                $find_already_register = User::find()
                                        ->where(['email' => $invite_friend_model->invite_friends_email])
                                        ->one();

                if(empty($find_already_register) && empty($find_already_invite)){

                    $assign_to_data = User::find()->where(['email' => $invite_frinds_value])->one();
                    $message = Yii::$app->mailer->compose();

                    $mail_data = $this->renderPartial('_invite_a_mail_template',[
                            'assign_to_data' => $invite_friend_model->invite_friends_email
                        ]);

                   
                    $message->SetFrom(["modeltest.abedon@gmail.com"=>"admin@model-test.com"]);
                    $message->setTo($invite_friend_model->invite_friends_email);
                    $message->setSubject("Invite friend | Model Test");
                    $message->setHtmlBody($mail_data);
                    $message->send();

                        if($invite_friend_model->save()){

                            $response['successmsg'] = "<tr><td>".$invite_friend_model->invite_friends_email."</td><td>Not Accepted</td></tr>";
                            $response['message'] = "<div class='btn btn-success'>Invitation successfully sent</div>";
                            return json_encode($response);

                        }else{

                            $response['message'] = "<div class='btn btn-warning'>Please provide valid email</div>";
                            return json_encode($response);
                        }

                        

                }else{
                    
                    $response['message'] = "<div class='btn btn-warning'>Already assign</div>";
                    return json_encode($response);

                }
                


            }

        }else{

            return $this->goHome();
        }
   }

   public function actionMyexam(){


        if(isset(Yii::$app->user->identity->user_type)){

            $id = Yii::$app->user->identity->id;
            $model = $this->findModel($id);

            return $this->render('myexam', [
                'model' => $model
            ]);

        }else{
           
            $session = Yii::$app->session;
            $session->set('redirect_url','user/myexam');
            $this->redirect(\Yii::$app->urlManager->createUrl("site/login"));
        }

   }
    

    public function actionHistory(){


        if(isset(Yii::$app->user->identity->user_type)){

            $id = Yii::$app->user->identity->id;

            $get_activity_log_r = Userexamrel::find()->select('DATE(created_at) as created_at')
                                                    ->where(['user_id'=>$id])
                                                    ->distinct()
                                                    ->orderBy('id desc')
                                                    ->asArray()
                                                    ->all();
            $get_activity_log_r = ArrayHelper::getColumn($get_activity_log_r, 'created_at');

            $exams = Userexamrel::find()->where(['user_id'=> $id])
                                        ->andWhere(['DATE(created_at)' => $get_activity_log_r])
                                        ->orderBy('id desc')
                                        ->limit(10)
                                        ->all();

            return $this->render('history', [
                'exams' => $exams,
                'user_id' => $id
            ]);

        }else{
            $session = Yii::$app->session;
            $session->set('redirect_url','user/history');
            $this->redirect(\Yii::$app->urlManager->createUrl("site/login"));
        }

   }

   public function actionLoad_more_activity(){
        if( Yii::$app->request->isAjax ){
            Yii::$app->response->format = Response::FORMAT_JSON;

            $id = Yii::$app->user->identity->id;
            $type = $_POST['type'];
            $offset = $_POST['offset'];
            $response = [];
            $response['item_count'] = '';

            if($type == 'activity'){
                $get_activity_log_r = Userexamrel::find()->select('DATE(created_at) as created_at')
                                                    ->where(['user_id'=>$id])
                                                    ->distinct()
                                                    ->orderBy('id desc')
                                                    ->asArray()
                                                    ->all();
                $get_activity_log_r = ArrayHelper::getColumn($get_activity_log_r, 'created_at');

                $exams = Userexamrel::find()->where(['user_id'=> $id])
                                            ->andWhere(['DATE(created_at)' => $get_activity_log_r])
                                            ->orderBy('id desc')
                                            ->limit(10)
                                            ->offset($offset)
                                            ->all();

                if(empty($exams)){
                    $new_data = '<tr><td colspan="8">Sorry no more data found.</td></tr>';
                    $response['item_count'] = 0;
                }else{
                    $new_data = $this->renderAjax('_more_activity',['exams'=>$exams,'user_id'=>$id]);
                }
                
                $response['result'] = 'success';
                $response['msg'] = $new_data;
            }
            else{

            }

            return $response;
        }
   }

   public function actionAccount(){


        if(isset(Yii::$app->user->identity->user_type)){

            $id = Yii::$app->user->identity->id;
            $transaction_history = TransactionHistroy::find()->where(['user_id'=>$id])
                                                             ->andWhere(['action'=> '-'])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset(0)
                                                             ->all();

            $transaction_history_added = TransactionHistroy::find()->where(['user_id'=>$id])
                                                             ->andWhere(['action'=> '+'])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset(0)
                                                             ->all();

            $PurchaseHistroy = PurchaseHistroy::find()->where(['user_id'=>$id])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset(0)
                                                             ->all();

            $current_date = Date('Y-m-d');
            $command = Yii::$app->db->createCommand("SELECT sum(points) FROM purchased_package where expired_date >= $current_date && user_id = $id ");
            $sum_of_points = $command->queryScalar();

            return $this->render('account', [
                'transaction_history' => $transaction_history,
                'transaction_history_added' => $transaction_history_added,
                'PurchaseHistroy' => $PurchaseHistroy,
                'sum_of_points' => $sum_of_points
            ]);

        }else{
            $session = Yii::$app->session;
            $session->set('redirect_url','user/account');
            $this->redirect(\Yii::$app->urlManager->createUrl("site/login"));
        }

   }


   public function actionLoad_more_data(){
        if( Yii::$app->request->isAjax ){
            Yii::$app->response->format = Response::FORMAT_JSON;

            $id = Yii::$app->user->identity->id;
            $type = $_POST['type'];
            $offset = $_POST['offset'];
            $response = [];
            $response['item_count'] = '';
            $data_action = $_POST['data_action'];

            if($type == 'transaction'){
                $transaction_history = TransactionHistroy::find()->where(['user_id'=>$id])
                                                             ->andWhere(['action' => $data_action])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset($offset)
                                                             ->all();

                if(empty($transaction_history)){
                    $new_data = '<tr><td colspan="8">Sorry no more data found.</td></tr>';
                    $response['item_count'] = 0;
                }else{
                    $new_data = $this->renderAjax('_more_transaction_history',['transaction_history'=>$transaction_history]);
                }
                
                $response['result'] = 'success';
                $response['msg'] = $new_data;
            }
            elseif($type == 'purchase_history'){
                $PurchaseHistroy = PurchaseHistroy::find()->where(['user_id'=>$id])
                                                             ->orderBy('id desc')
                                                             ->limit(10)
                                                             ->offset($offset)
                                                             ->all();
                if(empty($PurchaseHistroy)){
                    $new_data = '<tr><td colspan="8">Sorry no more data found.</td></tr>';
                    $response['item_count'] = 0;
                }else{
                    $new_data = $this->renderAjax('_more_purchase_history',['PurchaseHistroy'=>$PurchaseHistroy]);
                }
                
                $response['result'] = 'success';
                $response['msg'] = $new_data;
            }

            return $response;
        }
   }

   public function actionChange_profile_photo(){
        if( Yii::$app->request->isAjax ){
            $id = Yii::$app->user->identity->id;
            $instance = $_POST['instance'];


            $model = User::find()->where(['id' => $id])->one();
            $details_model = UserDetails::find()->where(['user_id' => $model->id])->one();

            $prev_img = $model->image;

            $uploaded_image = UploadedFile::getInstance($model, 'image');
            $time=time();
            $img_name = $id.$time.$uploaded_image->baseName . '.' . $uploaded_image->extension;
            $uploaded_image->saveAs('user_img/' . $img_name);
            $model->image = $img_name;

            $image = Image::getImagine();

             if($details_model->profile_complete == 0){
                    
                if(!empty($model->name) && !empty($details_model->date_of_birth) && !empty($model->phone) && !empty($details_model->gender) && !empty($model->address) && !empty($model->image) ){
                    $details_model->profile_complete = 1;

                    $point = Rest::get_point_from_point_table('signup');

                    $model->free_point = $model->free_point + $point;

                    Rest::save_transaction_history($model->id,$point,'+','signup','');
                }else{
                   
                }

            }

            if($model->save() && $details_model->save() ){

                if($prev_img!=''){
                    if(file_exists(Yii::getAlias('@webroot').'/user_img/'.$prev_img)){
                        unlink(Yii::getAlias('@webroot').'/user_img/'.$prev_img);
                    }
                }
                Image::thumbnail('@webroot/user_img/'.$img_name, 140, 175)
                        ->save(Yii::getAlias('@webroot').'/user_img/'.$img_name, ['quality' => 100]);


                $response['files'] = [
                    'name' => $img_name,
                    'type' => $uploaded_image->type,
                    'size' => $uploaded_image->size,
                    'url' => Url::base().'/user_img/'.$img_name,
                    
                ];
                $response['base'] = 'user_img/'.$img_name;

                return $this->redirect(['user/edit?type=personal-detail']);

                return json_encode($response);
            }else{
                $response['base'] = $model->getErrors();

                return json_encode($response);
            }

        }
   }

    

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
