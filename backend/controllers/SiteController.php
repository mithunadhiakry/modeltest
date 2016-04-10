<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

use backend\models\ActivityLog;
use backend\models\Resetpassword;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function beforeAction($action){
        
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['backend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['backend.theme'],
        ]);

        return parent::beforeAction($action);
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actionTimeline(){
        $model = (new \yii\db\Query())
                ->select(['*'])
                ->from('activity_log')
                ->orderBy('id desc')
                ->all(); 
        
        return $this->render('timeline',['model'=>$model]);

    }

    public function actionAccesscontrol(){
        return $this->render('accesscontrol');
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        
        if(!isset(Yii::$app->user->identity->username)){
            $this->redirect(['site/login']);
        }

        return $this->redirect(['membershiprequest/all_user']);
        // return $this->render('index');
    }




    public function actionLock_screen($previous){
        $this->layout='login_layout';

        if(isset(Yii::$app->user->identity->username)){
            // save current username    
            $username = Yii::$app->user->identity->username;
            $image = \Yii::$app->session->get('user.image');
            // force logout     
            Yii::$app->user->logout();
            // render form lockscreen
            $model = new LoginForm(); 
            $model->username = $username;    //set default value 
            return $this->render('lockScreen', [
                'model' => $model,
                'previous' => $previous,
                'image' => $image
            ]);  
        }
        else{
            return $this->redirect(['login']);
        }
    }



    public function actionForgotpassword(){
        $this->layout='login_layout';
        $model = new User();

        if($model->load(Yii::$app->request->post())){
            $model = User::find()->where(['email'=>$model->email])->one();

            if(!empty($model)){
                $email_id = $model->email;
                
                $model->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();

                if($model->save()){
                    $text = 'Please follow the link to complete your password reset process. ';
                    $text .= '<a href="'.Yii::$app->urlManager->createAbsoluteUrl(['/site/reset_password','token'=>$model->password_reset_token]).'">Click Here</a>';

                    $message = Yii::$app->mailer->compose();

                    $message->setFrom('mithun.cse521@gmail.com');
                    $message->setTo($email_id);
                    $message->setSubject("Verification");
                    $message->setHtmlBody($text);

                    if($message->send()){
                        //return $this->redirect(['login']);
                       \Yii::$app->getSession()->setFlash('success', 'Please check your email for further instruction.');
                    } 
                }else{
                    /*$response['result'] = html::errorSummary($model);
                        return json_encode($response);*/
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

        $this->layout='login_layout';

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
                    $this->redirect(['site/login']);
                }

            }
        }

        return $this->render('reset_pass', [
                'model' => $model,
            ]);
    }



    public function actionLogin($previous="")
    {
        $this->layout='login_layout';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $timestamp = date("Y-m-d h:i:s");

            $user = User::find()->where(['id' => $model->User->id])->one();
            $user->last_access = $timestamp;
            $user->save();

            if(!empty($previous)){
                return $this->redirect($previous);
            }
            else{
                return $this->goBack();
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        $this->redirect(['site/login']);
    }


    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
