<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use backend\models\AdManagement;
use backend\models\AdManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile; 
use yii\helpers\Url;

/**
 * AdManagementController implements the CRUD actions for AdManagement model.
 */
class AdmanagementController extends Controller
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
     * Lists all AdManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdManagement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $response['view'] = $this->renderAjax('view', [
                                                'model' => $this->findModel($id),
                                            ]);
            
            return json_encode($response);
        }
    }

    /**
     * Creates a new AdManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdManagement();

        if (Yii::$app->request->isAjax) {
            $model->attributes = $_POST['AdManagement'];

            if($model->save()){

                $response['files'] = ['ok'];
                $response['result'] = 'success';
                $response['post_list'] = $this->renderAjax('list_of_post', [
                                                'page_id' => $model->ad_identifier
                                            ]);
                return json_encode($response);
            }else{
                $response['result'] = 'error';
                $response['files'] =  Html::errorSummary($model);
                return json_encode($response);
            }
            
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AdManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    

    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) {

            if(isset($_POST['id'])){
                $id = $_POST['id'];
                $model = $this->findModel($id);  
            }else{
                $model = new AdManagement();
            }
          

            if (isset($_POST['AdManagement'])) {
                $model = $this->findModel($_POST['AdManagement']['id']);
                $model->attributes = $_POST['AdManagement'];

                if($model->save()){

                    $response['files'] = ['ok'];
                    $response['result'] = 'success';
                    $response['post_list'] = $this->renderAjax('list_of_post', [
                                                'page_id' => $model->ad_identifier
                                            ]);
                    return json_encode($response);
                }else{
                    $response['result'] = 'error';
                    $response['files'] =  Html::errorSummary($model);
                    return json_encode($response);
                }
            } else {
                
                $response['id'] = $model->id;
                $response['ad_name'] = $model->ad_name;
                $response['ad_description'] = $model->ad_description;
                $response['url'] = $model->url;
                $response['upload_view'] = $this->renderAjax('file_upload_view',[
                                                'post_id' => $model->id
                                            ]);

                $response['images_list'] = $this->renderAjax('uploaded_image_list', [
                                                'image' => $model
                                            ]);

                return json_encode($response);
            }
        }
    }

     public function actionUpload_file(){
        if( Yii::$app->request->isAjax ){
            $rel_model = $this->findModel($_POST['id']);

            $rel_model_image = UploadedFile::getInstance($rel_model, 'image');
            $time=time();

            $rel_model_image->saveAs('advertisement/' . $time.$rel_model_image->baseName . '.' . $rel_model_image->extension);

            $rel_model->image = $time.$rel_model_image->baseName . '.' . $rel_model_image->extension;

            if($rel_model->save()){
                $response = [];

                $view = $this->renderAjax('_image_upload', [
                                'url' => Url::base().'/advertisement/' . $time.$rel_model_image->baseName . '.' . $rel_model_image->extension,
                                'basename' => $time.$rel_model_image->baseName,
                                'id' => $rel_model->id
                            ]);

                $response['files'][] = [
                    'name' => $time.$rel_model_image->name,
                    'type' => $rel_model_image->type,
                    'size' => $rel_model_image->size,
                    'url' => Url::base().'/advertisement/' . $time.$rel_model_image->baseName . '.' . $rel_model_image->extension,
                    'deleteUrl' => Url::to(['delete_uploaded_file', 'file' => $rel_model_image->baseName . '.' . $rel_model_image->extension]),
                    'deleteType' => 'DELETE'
                ];

                /*$response['view'] = $view;*/
                $response['view'] = $view;
                $response['base'] = $time.$rel_model_image->baseName;

                return json_encode($response);
            }else{
                $response['error'] = $rel_model->getErrors();
                $response['id'] = $_POST['id'];
                return json_encode($response);
            }

        }
    }

    /**
     * Deletes an existing AdManagement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            if($this->findModel($id)->delete()){

                $response['files'] = ['ok'];
                $response['result'] = 'success';
                return json_encode($response);
            }else{
                $response['result'] = 'error';
                $response['files'] =  Html::errorSummary($model);
                return json_encode($response);
            }
            
        }
    }

    /**
     * Finds the AdManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
