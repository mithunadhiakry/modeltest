<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;

use backend\models\Membershiprequest;
use backend\models\MembershiprequestSearch;
use backend\models\UserSearch;
use backend\models\PurchaseHistroy;
use backend\models\PurchasedPackage;
use backend\models\Rest;
use backend\models\Package;
use backend\models\Discounts;
use backend\models\UserDetails;
use app\models\User;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MembershiprequestController implements the CRUD actions for Membershiprequest model.
 */
class MembershiprequestController extends Controller
{

    public function beforeAction($action){
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['backend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['backend.theme'],
        ]);

        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Membershiprequest models.
     * @return mixed
     */


    public function actionIndex()
    {
        $searchModel = new MembershiprequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAll_user(){

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'','admin');

        return $this->render('all_user',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionNew_member(){

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'','admin','new');

        return $this->render('new_member',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionInvoice($id){


        $membership_data = Membershiprequest::find()->where(['invoice_id' => $id])->one();
        $user_data = User::find()->where(['id' => $membership_data->user_id])->one();
        $package = Package::find()->where(['id' => $membership_data->package_id ])->one();

        return $this->render('invoice_print',[
                'invoice_no' => $id,
                'membership_model' => $membership_data,
                'model' => $user_data,
                'package' => $package
            ]);
    }

    public function actionUser_sendagain($id){
        
        $user_data = User::find()->where(['id' => $id])->one();

        $message = Yii::$app->mailer->compose();

        $mail_data = $this->renderPartial('_signup_mail_template',[
                'signup_model' => $user_data
        ]);

      
        $message->setFrom(Yii::$app->params['admin_email']);
        $message->setTo($user_data->email);
        $message->setSubject("Sign up Confirmation");
        $message->setHtmlBody($mail_data);
        
        if($message->send()){
            return $this->redirect(['new_member']);
        }


        
    }

    public function actionDeleteuser($id){

        $user_data = User::find()->where(['id' => $id])->one();

        if($user_data){

            $user_details = UserDetails::find()->where(['user_id' => $user_data->id])->one();

            
            if($user_data->delete()){

                $user_details->delete();

                return $this->redirect(['all_user']);
            }
        }
    }

    public function actionDeletemembership($id){

        $membership_data = Membershiprequest::find()
                            ->where(['id' => $id])
                            ->one();

        if($membership_data->delete()){
            return $this->redirect(['pending_payment']);
        }
    }

    public function actionPending_payment(){

        $payment_status_modal = new Membershiprequest();


        $searchModel = new MembershiprequestSearch();
        
        if($payment_status_modal->load(Yii::$app->request->get())){

            $status= $payment_status_modal->status;
            $searchModel->status = $status;
        }

        
        
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('user_panel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'payment_status_modal' => $payment_status_modal
        ]);
    }

    public function actionAllpaid(){

        $searchModel = new MembershiprequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single Membershiprequest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Membershiprequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Membershiprequest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Membershiprequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($model->status == 1){



                    $user_id = Yii::$app->user->identity->id;

                    $package = Package::find()->where(['id'=>$model->package_id])->one();
                    if(empty($package)){
                        throw new NotFoundHttpException('The requested package does not exist.');
                    }

                    Rest::save_transaction_history($model->user_id,$model->discount,'+','free_points','');

                    $payment_id = 'p_'.time();
                    $points = (int) explode(' pts', $package->package_type)[0];
                    $expire_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. $package->duration.' days'));
                    
                    $PurchaseHistroy_model = new PurchaseHistroy();
                    $PurchaseHistroy_model->package_name = $package->package_type;
                    $PurchaseHistroy_model->points = $points;
                    $PurchaseHistroy_model->price = $package->price_bd;
                    $PurchaseHistroy_model->payment_id = $payment_id;
                    $PurchaseHistroy_model->payment_type = $model->payment_type;
                    $PurchaseHistroy_model->duration = $package->duration;
                    $PurchaseHistroy_model->start_date = date('Y-m-d');
                    $PurchaseHistroy_model->end_date = $expire_date;
                    $PurchaseHistroy_model->user_id = $model->user_id;


                    if($PurchaseHistroy_model->save()){

                    $package = Package::find()->where(['id'=>$model->package_id])->one();
                    if(empty($package)){
                        throw new NotFoundHttpException('The requested package does not exist.');
                    }



                    $user_data = User::find()->where(['id'=>$model->user_id])->one();

                    $message = Yii::$app->mailer->compose();

                   $user_data->email. '<br/><br/>'. Yii::$app->params['admin_email'] .'<br/><br/>' . Yii::$app->params['contact_email'] . '<br/><br>';
                   $mail_data = $this->renderPartial('_membership_mail_template',[
                            'invoice_no' => $model->invoice_id,
                            'package' => $package,
                            'model' => $user_data
                        ]);
                   
                    $message->setFrom(Yii::$app->params['admin_email']);
                    $message->setTo($user_data->email);
                    $message->setCc(array(Yii::$app->params['contact_email']));
                    $message->setSubject("Get a membership package | Model Test");
                    $message->setHtmlBody($mail_data);
                   

                    if($message->send()){

                        $purchased_package_id = Rest::save_purchased_package($user_id, $package->package_type, $points, $expire_date);
                        Rest::save_transaction_history( $user_id, $points, '+', 'purchase', '', $purchased_package_id);

                        $user_data->save();

                        return $this->redirect(['view', 'id' => $model->id]); 
                    }


                   
                   


                }

            }else{

                return $this->redirect(['view', 'id' => $model->id]);

            }

            



            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    

    public function actionConfirm_payment($id){

            $model = Membershiprequest::find()
                                        ->where(['id' => $id])
                                        ->one();

            $model->status = 1;

            if($model->save()){

                $user_id = Yii::$app->user->identity->id;

                    $package = Package::find()->where(['id'=>$model->package_id])->one();
                    if(empty($package)){
                        throw new NotFoundHttpException('The requested package does not exist.');
                    }

                    Rest::save_transaction_history($model->user_id,$model->discount,'+','free_points','');

                    $payment_id = 'p_'.time();
                    $points = (int) explode(' pts', $package->package_type)[0];
                    $expire_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +'. $package->duration.' days'));
                    
                    $PurchaseHistroy_model = new PurchaseHistroy();
                    $PurchaseHistroy_model->package_name = $package->package_type;
                    $PurchaseHistroy_model->points = $points;
                    $PurchaseHistroy_model->price = $package->price_bd;
                    $PurchaseHistroy_model->payment_id = $payment_id;
                    $PurchaseHistroy_model->payment_type = $model->payment_type;
                    $PurchaseHistroy_model->duration = $package->duration;
                    $PurchaseHistroy_model->start_date = date('Y-m-d');
                    $PurchaseHistroy_model->end_date = $expire_date;
                    $PurchaseHistroy_model->user_id = $model->user_id;


                    if($PurchaseHistroy_model->save()){

                    $package = Package::find()->where(['id'=>$model->package_id])->one();
                    if(empty($package)){
                        throw new NotFoundHttpException('The requested package does not exist.');
                    }


                    // add point into the main table

                    $PurchasedPackage_model = new PurchasedPackage();

                    $PurchasedPackage_model->user_id = $model->user_id;
                    $PurchasedPackage_model->package_name = $package->package_type;
                    $PurchasedPackage_model->points = $points;
                    $PurchasedPackage_model->expired_date = $expire_date;

                    $PurchasedPackage_model->save();

                    $user_data = User::find()->where(['id'=>$model->user_id])->one();

                    $message = Yii::$app->mailer->compose();

                    $discounts_data = Discounts::find()->where(['discounts_code' => $model->discounts_code])->one();

                   $user_data->email. '<br/><br/>'. Yii::$app->params['admin_email'] .'<br/><br/>' . Yii::$app->params['contact_email'] . '<br/><br>';
                   $mail_data = $this->renderPartial('_membership_mail_template',[
                            'invoice_no' => $model->invoice_id,
                            'package' => $package,
                            'model' => $user_data,
                            'membership_model' => $model,
                            'discounts_data' => $discounts_data
                        ]);
                   
                    $message->setFrom(Yii::$app->params['admin_email']);
                    $message->setTo($user_data->email);
                    $message->setCc(array(Yii::$app->params['contact_email']));
                    $message->setSubject("Get a membership package | Model Test");
                    $message->setHtmlBody($mail_data);
                   

                    if($message->send()){

                        $purchased_package_id = Rest::save_purchased_package($user_id, $package->package_type, $points, $expire_date);
                        Rest::save_transaction_history( $user_id, $points, '+', 'purchase', '', $purchased_package_id);

                        $user_data->save();

                        return $this->redirect(Url::to(['membershiprequest/pending_payment']));            
                    }


                   
                   


                }
                
            }
    }

    /**
     * Deletes an existing Membershiprequest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Membershiprequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Membershiprequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Membershiprequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
