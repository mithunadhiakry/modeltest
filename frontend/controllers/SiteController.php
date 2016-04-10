<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Html;
use frontend\models\LoginForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\User;
use frontend\models\UserDetails;
use frontend\models\Page;
use frontend\models\Questionset;
use frontend\models\Resetpassword;
use frontend\models\Rest;
use frontend\models\InviteFriends;
use frontend\models\AdManagement;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\NotFoundHttpException;


/**
 * Site controller
 */
class SiteController extends Controller
{

    public function beforeAction($action){
        
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['frontend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['frontend.theme'],
        ]);

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


     public function actions()
        {
            return [
                'error' => [
                    'class' => 'yii\web\ErrorAction',
                ],
                'captcha' => [
                    'class' => 'yii\captcha\CaptchaAction',
                    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                ],
            ];
    }


    public function actionIndex()
    {   
       // $this->layout = 'layout_institution';
        $this->layout = 'layout_landing';
        $model = new LoginForm();

        $signup_model = new User(['scenario' => 'signup']);
        $user_details_model = new UserDetails();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            if(Yii::$app->user->identity->user_type == 'institution'){
                return $this->redirect(['/institution']);
            }

            if(Yii::$app->user->identity->user_type == 'student'){
                return $this->redirect(['/dashboard']);
            }
        }

        if ($signup_model->load(Yii::$app->request->post())) {
        
           $signup_model->status = 0;
           $signup_model->created_by = 0;
           $signup_model->updated_by = 0;

           $point = Rest::get_point_from_point_table('signup');

           if($signup_model->user_type == 'student'){
                //$signup_model->free_point = $point;
                $signup_model->free_point = 0;
            }else{
                $signup_model->free_point = 0;
            }

           $valid = $signup_model->validate();
           $valid = $user_details_model->validate() && $valid;
           
           if($valid){

                 $invite_friends_q = InviteFriends::find()
                                        ->where(['invite_friends_email' => $signup_model->email])
                                        ->where(['status' => '0'])
                                        ->one();

                if(!empty($invite_friends_q)){

                   

                    $invite_friends_q->status = 1;
                    

                    $invite_model = new User();
                    $invite_point = Rest::get_point_from_point_table('invitefriend');


                  
                    $user_data = User::find()->where(['id'=>$invite_friends_q->user_id])->one();
                    
                    if(!empty($user_data)){
                        $user_data->free_point = $invite_point;
                        $user_data->save();
                    }
                    
                   
                    Rest::save_transaction_history($invite_friends_q->user_id,$invite_model->free_point,'+','invitefriend','');

                    $invite_friends_q->save();

                }

                $signup_model->password = Yii::$app->security->generatePasswordHash($signup_model->password);
                $signup_model->auth_key = Yii::$app->security->generateRandomString();
                $signup_model->password_repeat = $signup_model->password;

                $signup_model->save();
                //Rest::save_transaction_history($signup_model->id,$signup_model->free_point,'+','signup','');
            
                $user_details_model->institution_name = $signup_model->institution;
                $user_details_model->user_id = $signup_model->id;
                $user_details_model->save();

                $message = Yii::$app->mailer->compose();

                $mail_data = $this->renderPartial('_signup_mail_template',[
                    'signup_model' => $signup_model
                ]);

              
                $message->SetFrom(["modeltest.abedon@gmail.com"=>"support@model-test.com"]);
                $message->setTo($signup_model->email);
                $message->setSubject("Sign up Confirmation");
                $message->setHtmlBody($mail_data);
                $message->send();

                \Yii::$app->getSession()->setFlash('success', 'Thanks for registering. Please login to get started.');
           }
        }

        $page_slug = 'home';
        $get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

        $testimonial_slug = 'testimonial';
        $get_testimonial_data = Page::find()->where(['page_slug'=>$testimonial_slug])->one();
        
        $latest_exam_list_r = Questionset::find()
                            ->limit(4)
                            ->orderBy([
                                'id' => SORT_DESC,
                            ])->where(['status' => '1'])
                            ->all();

        $banner_slug = 'home-banner';

        $home_banner_r = Page::findPage_by_slug($banner_slug);

        $advertisement_r = AdManagement::find()
                            ->where(['ad_identifier' => '2'])
                            ->all();

        $instruction_slug = 'instruction';
        $instruction_data = Page::find()->where(['page_slug'=>$instruction_slug])->one();

        return $this->render('index',[
                'model'=>$model,
                'signup_model' => $signup_model,
                'user_details_model' => $user_details_model,
                'get_page_data' => $get_page_data,
                'get_testimonial_data' => $get_testimonial_data,
                'latest_exam_list_r' => $latest_exam_list_r,
                'home_banner_r' => $home_banner_r,
                'advertisement_r' => $advertisement_r,
                'instruction_data' => $instruction_data
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $session = Yii::$app->session;

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->redirect($session->get('redirect_url'));
            if($session->has('redirect_url')){
                $this->redirect(\Yii::$app->urlManager->createUrl($session->get('redirect_url')));
            }else{
                $this->redirect(\Yii::$app->urlManager->createUrl('dashboard'));
            }
            
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    public function actionActive_member(){
        if(isset($_GET['auth_key'])){

            $auth_key = $_GET['auth_key'];

            $valid_auth_key = User::find()
                                ->where(['auth_key' => $auth_key])
                                ->andWhere(['status' => 0])
                                ->one();

            if($valid_auth_key){

                $valid_auth_key->status = 1;
                $valid_auth_key->save();

               
                return $this->render('active_member',[
                        'model' => $valid_auth_key
                    ]);

            }else{

               throw new NotFoundHttpException('The requested page does not exist.');

            }

        }
    }



    public function actionLogin_with_fb(){
        if( Yii::$app->request->isAjax ){
            $data = Yii::$app->request->post('data');

            $model = User::find()->where(['email'=>$data['email']])->one();

            if(!empty($model)){
                if (\Yii::$app->user->login($model, 3600 * 24 * 30) ) {

                    if(Yii::$app->user->identity->user_type == 'institution'){
                        $url = \Yii::$app->urlManager->createUrl('/institution');
                    }

                    if(Yii::$app->user->identity->user_type == 'student'){

                        $point = Rest::get_point_from_point_table('facebook_login');

                        $model->free_point = $model->free_point + $point;

                        Rest::save_transaction_history($model->id,$point,'+','signup','');

                        $model->save();

                        $url = \Yii::$app->urlManager->createUrl('/dashboard');
                    }

                    return json_encode(array('result'=>'success','url'=>$url));
                }
            }else{
                return json_encode(array('result'=>'error','msg'=>'You are not authorised to this site.'));
            }
        }
    }

    // public function actionLogin(){
    //     return 'ok';
    // }

    public function actionSignup(){

    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionForgotpassword(){

        $model = new User();

        if($model->load(Yii::$app->request->post())){

            $model = User::find()->where(['email'=>$model->email])->one();

            if(!empty($model)){

                $email_id = $model->email;
                
                $model->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();

                if($model->save()){
                    
                    $message = Yii::$app->mailer->compose();

                    $mail_data = $this->renderPartial('_reset_password_mail_template',
                                        ['model' => $model]);


                   
                    $message->SetFrom(["modeltest.abedon@gmail.com"=>"support@model-test.com"]);
                    $message->setTo($email_id);
                    $message->setSubject("Re-set Password | Model Test");
                    $message->setHtmlBody($mail_data);
                   

                    if($message->send()){
                       \Yii::$app->getSession()->setFlash('success', 'Please check your email for further instruction.');
                    } 
                }else{
                    
                    \Yii::$app->getSession()->setFlash('error', 'Wrong email address');
                }
            }else{
                \Yii::$app->getSession()->setFlash('error', 'Wrong email address');
            }    
        }

        $model = new User();
        return $this->render('forgotpassword', [
                'model' => $model,
            ]);
    }


    public function actionReset_password($token){


         if(empty($token)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new Resetpassword();
        $model->scenario = 'reset_pass';



        $data = User::find()->where(['password_reset_token'=>$token])->one();
        if(empty($data)){
            return $this->goBack();
        }


        if($model->load(Yii::$app->request->post())){
            $valid = $model->validate();

            if($valid){
                $data->password = Yii::$app->security->generatePasswordHash($model->password);
                $data->password_reset_token = '';

                if($data->save()){
                    $this->redirect(['site/index']);
                }

            }
        }

        return $this->render('reset_pass',[
                'model' => $model
            ]);

    


    }

    
}
