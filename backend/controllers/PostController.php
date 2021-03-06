<?php

namespace backend\controllers;

use Yii;
use backend\models\Post;
use backend\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use backend\models\PostImageRel;
use yii\web\UploadedFile; 
use yii\helpers\Url;
use yii\filters\AccessControl;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
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
                        'actions' => ['upload_file', 'delete_uploaded_file', 'index', 'view', 'create', 'update'],
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

    public function actionSave_post_sort_order(){
        if( Yii::$app->request->isAjax ){
            $data = $_POST['data'];
            $page = $_POST['page'];

            if(!empty($data)){
                $i=1;
                foreach ($data as $key) {
                    $Post = Post::find()->where(['page_id'=>$page,'id'=>$key])->one();

                    if(!empty($Post)){
                        $Post->sort_order = $i;
                        $Post->save();
                    }
                    $i++;
                }

                $response['result'] = 'success';
                $response['msg'] = 'Sort Order successfully saved.';
                $response['post_list'] = $this->renderAjax('list_of_post', [
                                                'page_id' => $page
                                            ]);
            }
            else{
                $response['result'] = 'error';
                $response['msg'] = 'Error saving sort order.';
            }

            return json_encode($response);
        }
    }

    public function actionUpload_file(){
        if( Yii::$app->request->isAjax ){
            $rel_model = new PostImageRel();

            $rel_model_image = UploadedFile::getInstance($rel_model, 'image');
            $time=time();

            $rel_model_image->saveAs('post_uploads/' . $time.$rel_model_image->baseName . '.' . $rel_model_image->extension);

            $rel_model->post_id = $_POST['id'];
            $rel_model->image = $time.$rel_model_image->baseName . '.' . $rel_model_image->extension;

            if($rel_model->save()){
                $response = [];

                $view = $this->renderAjax('_image_upload', [
                                'url' => Url::base().'/post_uploads/' . $time.$rel_model_image->baseName . '.' . $rel_model_image->extension,
                                'basename' => $time.$rel_model_image->baseName,
                                'id' => $rel_model->id
                            ]);

                $response['files'][] = [
                    'name' => $time.$rel_model_image->name,
                    'type' => $rel_model_image->type,
                    'size' => $rel_model_image->size,
                    'url' => Url::base().'/post_uploads/' . $time.$rel_model_image->baseName . '.' . $rel_model_image->extension,
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

    public function actionDelete_uploaded_file(){
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];

            $PostImageRel_model = PostImageRel::find()->where(['id'=>$id])->one();
            $name = $PostImageRel_model->image;

            $response = [];
            if(!empty($PostImageRel_model) && $PostImageRel_model->delete()){
                unlink(\Yii::getAlias('@webroot').'/post_uploads/'.$name);

                
                $response['files'] = ['msg'=> 'File deleted successfully'];

            }else{
                $response['files'] = ['msg'=> 'Image File not found in database'];
            }

            return json_encode($response);
            
        }
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
public function actionCreate()
    {
        $model = new Post();
        
        if (Yii::$app->request->isAjax) {
            $model->attributes = $_POST['Post'];

            if($model->save()){

                $response['files'] = ['ok'];
                $response['result'] = 'success';
                $response['post_list'] = $this->renderAjax('list_of_post', [
                                                'page_id' => $model->page_id
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
     * Updates an existing Post model.
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
            }
            

            if (isset($_POST['Post'])) {
                $model = $this->findModel($_POST['Post']['id']);
                $model->attributes = $_POST['Post'];
            
                if($model->save()){

                    $response['files'] = ['ok'];
                    $response['result'] = 'success';
                    $response['post_list'] = $this->renderAjax('list_of_post', [
                                                'page_id' => $model->page_id
                                            ]);
                    return json_encode($response);
                }else{
                    $response['result'] = 'error';
                    $response['files'] =  Html::errorSummary($model);
                    return json_encode($response);
                }
            } else {
                
                $response['id'] = $model->id;
                $response['post_title'] = $model->post_title;
                $response['desc'] = $model->desc;
                $response['upload_view'] = $this->renderAjax('file_upload_view',[
                                                'post_id' => $model->id
                                            ]);

                $images = PostImageRel::find()->where(['post_id'=>$model->id])->all();
                $response['images_list'] = $this->renderAjax('uploaded_image_list', [
                                                'images' => $images
                                            ]);

                return json_encode($response);
            }
        }
    }

    /**
     * Deletes an existing Post model.
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
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
