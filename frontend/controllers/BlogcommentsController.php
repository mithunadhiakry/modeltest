<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use frontend\models\BlogComments;
use frontend\models\BlogCommentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogCommentsController implements the CRUD actions for BlogComments model.
 */
class BlogcommentsController extends Controller
{
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
     * Lists all BlogComments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogCommentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BlogComments model.
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
     * Creates a new BlogComments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogComments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BlogComments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BlogComments model.
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
     * Finds the BlogComments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogComments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogComments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAdd_comments(){

        if( Yii::$app->request->isAjax ){

            Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];

            $user_id = $_POST['BlogComments']['user_id'];
            $blog_id = $_POST['BlogComments']['blog_id'];
            $comments = $_POST['BlogComments']['comments'];

            $blog_comment_modal = new BlogComments();

            $blog_comment_modal->user_id = $user_id;
            $blog_comment_modal->blog_id = $blog_id;
            $blog_comment_modal->comments = $comments;

            
            if($blog_comment_modal->save()){
                
                $blog_comments = BlogComments::find()
                                ->where(['id' => $blog_comment_modal->id])                                
                                ->one();

                $blog_new_data = $this->renderAjax('newcomments',[
                                'blog_comments' => $blog_comments
                    ]);

                $response['comments'] = $blog_new_data;

            }

            return json_encode($response);

        }
    }
}
