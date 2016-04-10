<?php
namespace institution\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use institution\models\LoginForm;
use institution\models\PasswordResetRequestForm;
use institution\models\ResetPasswordForm;
use institution\models\SignupForm;
use institution\models\ContactForm;
use institution\models\UserDetails;
use institution\models\User;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\UploadedFile;
use yii\imagine\Image;


/**
 * Site controller
 */
class SiteController extends Controller
{

    public function beforeAction($action){
        
        if(!isset(Yii::$app->user->identity->username)){
            $url = explode('/institution', \Yii::$app->request->BaseUrl)[0];
            return $this->redirect($url);
        }
        
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
        if(isset(Yii::$app->user->identity->user_type) == 'institution'){

            $user_data = Yii::$app->user->identity;
            $details_model = UserDetails::find()->where(['user_id' => $user_data->id])->one();

            return $this->render('index',[
                    'user_data' => $user_data
                ]);
        }else{

        }
        
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionAccount(){

        if(isset(Yii::$app->user->identity->user_type)){

            $model = Yii::$app->user->identity;

            $details_model = UserDetails::find()->where(['user_id' => $model->id])->one();

            return $this->render('account',[
                    'model' => $model,
                    'details_model' => $details_model
                ]);


        }else{
            return $this->goHome();
        }
        
    }

    public function actionEdit(){

        if(isset(Yii::$app->user->identity->user_type) == 'institution'){

            $model = User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
            $model->scenario = 'change_password';

            $details_model = UserDetails::find()->where(['user_id' => $model->id])->one();

            return $this->render('update',[
                    'model' => $model,
                    'details_model' => $details_model
                ]);
        }
    }

    public function actionChangepassword(){

        $post_model = new User;

        $post_model->scenario = 'change_password';

        
        if($post_model->load(Yii::$app->request->post())){


            if($post_model->validate()){

                $id = Yii::$app->user->identity->id;
                $model = User::find()->where(['id'=>$id])->one();
                $model->password = Yii::$app->security->generatePasswordHash($post_model->new_password);
                
                if($model->save()){
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
            $model = User::find()->where(['id'=>$id])->one();

            $details_model = UserDetails::find()->where(['user_id' => $id])->one();

            $valid = $details_model->validate();

            
            if ($model->load(Yii::$app->request->post()) && $details_model->load(Yii::$app->request->post())) {

               
                if($model->save() && $details_model->save()){
                   
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

    public function actionChange_profile_photo(){
        if( Yii::$app->request->isAjax ){
            $id = Yii::$app->user->identity->id;
            $instance = $_POST['instance'];


            $model = User::find()->where(['id' => $id])->one();

            $prev_img = $model->image;

            $uploaded_image = UploadedFile::getInstance($model, 'image');
            $time=time();
            $img_name = $id.$time.$uploaded_image->baseName . '.' . $uploaded_image->extension;
            $uploaded_image->saveAs('user_img/' . $img_name);
            $model->image = $img_name;

            $image = Image::getImagine();

            if($model->save()){

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


                return json_encode($response);
            }else{
                $response['base'] = $model->getErrors();

                return json_encode($response);
            }

        }
   }

   
    
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }



    
}
