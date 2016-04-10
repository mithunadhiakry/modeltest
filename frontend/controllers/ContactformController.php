<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Contactform;
use frontend\models\ContactformSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ContactformController implements the CRUD actions for Contactform model.
 */
class ContactformController extends Controller
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
     * Lists all Contactform models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactformSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contactform model.
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
     * Creates a new Contactform model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contactform();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionContactsubmit(){

        $model = new Contactform();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            $message = Yii::$app->mailer->compose();

            $mail_data = $this->renderPartial('_contactsubmit_mail_template',[
                        'model' => $model
                ]);
            $message->setFrom(Yii::$app->params['admin_email']);
            $message->setTo(Yii::$app->params['contact_email']);
            $message->setSubject($model->subject . " | Model Test");
            $message->setHtmlBody($mail_data);
            $message->send();

            $response['message'] = "<div class='btn btn-success'>Your message has been successfully send</div>";
        }else{
            $response['message'] = "<div class='btn btn-warning'>Something wrong</div>";
        }

        return json_encode($response);

        

    }

    /**
     * Updates an existing Contactform model.
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
     * Deletes an existing Contactform model.
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
     * Finds the Contactform model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contactform the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contactform::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
