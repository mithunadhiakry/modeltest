<?php

namespace backend\controllers;

use Yii;
use app\models\User;
use backend\models\UserSearch;
use backend\models\UserDetails;
use backend\models\Question;
use backend\models\QuestionSearch;
use backend\models\MembershiprequestSearch;
use backend\models\Membershiprequest;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

use frontend\models\Rest;
use frontend\models\PurchasedPackage;


use yii\web\UploadedFile;

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
    
    public function behaviors()
    {
        return [
            /*'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [''],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    public function actionTest(){

        $searchModel = new MembershiprequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'0');

        return $this->render('test_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionQuestion_list_by_user(){
        
        $model = new Question();
        $user_id = 0;

        if($model->load(Yii::$app->request->get())){
            $user_id = $model->created_by;
        }

        $searchModel = new QuestionSearch();
        $queryParams= Yii::$app->request->getQueryParams();
        $queryParams['QuestionSearch']['created_by'] = $user_id;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('question_list_by_user',[
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model
                    ]);
    }


    public function actionUnapprove($id)
    {
        $model = User::find()->where(['id'=>$id])->one();

        if(!empty($model)){
            $model->status = 0;
            if($model->save()){
                return $this->redirect(['user/index']);
            }else{
                var_dump($model->getErrors());
            }

            
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionApprove($id)
    {
        $model = User::find()->where(['id'=>$id])->one();

        if(!empty($model)){
            $model->status = 1;
            if($model->save()){
                return $this->redirect(['user/unapproved']);
            }else{
                var_dump($model->getErrors());
            }

            
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'1');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUnapproved()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'0');

        return $this->render('unapproved', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new User();
        $details_model = new UserDetails();

        if ($model->load(Yii::$app->request->post()) && $details_model->load(Yii::$app->request->post())) {

            $model_image = UploadedFile::getInstance($model, 'image');
            $time=time();

            if(isset($model_image->baseName)){
                $model->image = $time.$model_image->baseName . '.' . $model_image->extension;
            }
            

            $valid = $model->validate();
            $valid = $details_model->validate() && $valid;

            if($valid){
                $model->password = Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();

                $point = Rest::get_point_from_point_table('signup');

                if($model->user_type == 'student'){
                    $model->free_point = $point;
                }else{
                    $model->free_point = 0;
                }

                if($model->save()){

                    if(isset($model_image->baseName)){

                        $model_image->saveAs('user_img/' . $time.$model_image->baseName . '.' . $model_image->extension);
                    }
                    
                    
                    Rest::save_transaction_history($model->id,$model->free_point,'+','signup','');
                    
                    $details_model->user_id = $model->id;
                

                    if($details_model->save()){
                        return $this->redirect(['view', 'id' => $model->id]);
                    }else{
                        var_dump($details_model->getErrors());
                        exit();
                    }
                     
                    
                }
            }else{
                
            }
            
        }

        return $this->render('create', [
                'model' => $model, 'details_model' => $details_model
            ]);

    }


    public function actionUpdate($id)
    {


        
        $model = $this->findModel($id);
        $details_model = UserDetails::find()->where(['user_id' => $id])->one();

        if ($model->load(Yii::$app->request->post()) && $details_model->load(Yii::$app->request->post())) {

            if($model->save() && $details_model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        return $this->render('update', [
            'model' => $model,
            'details_model' => $details_model
        ]);

    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionGive_points(){
        $model = new User();

        if($model->load(Yii::$app->request->post())){
            $user_id = $_POST['User']['id'];
            $response = [];

            $model = User::find()->where(['id'=>$user_id])->one();
            $packages_info = PurchasedPackage::find()->where(['user_id'=>$user_id])
                                                ->andWhere(['!=','points','0'])
                                                ->orderBy('expired_date asc')
                                                ->all();
            $response['result'] = 'success';
            $response['msg'] = $this->renderAjax('_points_list',[
                        'packages_info' => $packages_info,
                        'model' => $model
                    ]);

            return json_encode($response);

        }else{
            return $this->render('give_points',[
                        'model' => $model
                    ]);
        }
        
    }

    public function actionGive_points_req(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];

            $user_id = $_POST['user_id'];
            $point = $_POST['point'];

            $user_data = User::find()->where(['id'=>$user_id])->one();

            $user_data->free_point = $user_data->free_point + $point;
            $user_data->save();

            Rest::save_transaction_history($user_id, $point, '+', 'Admin Rewarded', '');

            $packages_info = PurchasedPackage::find()->where(['user_id'=>$user_id])
                                                ->andWhere(['!=','points','0'])
                                                ->orderBy('expired_date asc')
                                                ->all();

            $response['result'] = 'success';
            $response['msg'] = 'Points successfully rewarded.';
            $response['view'] = $this->renderAjax('_points_list',[
                        'packages_info' => $packages_info,
                        'model' => $user_data
                    ]);

            return $response;
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
