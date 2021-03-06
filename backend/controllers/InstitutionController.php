<?php

namespace backend\controllers;

use Yii;
use backend\models\Institution;
use backend\models\InstitutionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InstitutionController implements the CRUD actions for Institution model.
 */
class InstitutionController extends Controller
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


    public function actionUnapprove($id)
    {
        $model = Institution::find()->where(['id'=>$id])->one();

        if(!empty($model)){
            $model->status = 0;
            if($model->save()){
                return $this->redirect(['institution/index']);
            }else{
                var_dump($model->getErrors());
            }

            
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionApprove($id)
    {
        $model = Institution::find()->where(['id'=>$id])->one();

        if(!empty($model)){
            $model->status = 1;
            if($model->save()){
                return $this->redirect(['institution/unapproved']);
            }else{
                var_dump($model->getErrors());
            }

            
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all Institution models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstitutionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'1');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUnapproved()
    {
        $searchModel = new InstitutionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'0');

        return $this->render('unapproved', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Institution model.
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
     * Creates a new Institution model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Institution();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Institution model.
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
     * Deletes an existing Institution model.
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
     * Finds the Institution model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Institution the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Institution::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
