<?php

namespace backend\controllers;

use Yii;
use backend\models\Discounts;
use backend\models\DiscountsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DiscountsController implements the CRUD actions for Discounts model.
 */
class DiscountsController extends Controller
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

    public function actionAll_type(){

        return $this->render('all_type');
    }

    
    /**
     * Lists all Discounts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiscountsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Discounts model.
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
     * Creates a new Discounts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Discounts();




        if ($model->load(Yii::$app->request->post()) ) {

            if($model->discounts_month == 'January'){
                $model->discounts_slot = 1;
            }

            if($model->discounts_month == 'February'){
                $model->discounts_slot = 2;
            }

            if($model->discounts_month == 'March'){
                $model->discounts_slot = 3;
            }

            if($model->discounts_month == 'April'){
                $model->discounts_slot = 4;
            }

            if($model->discounts_month == 'May'){
                $model->discounts_slot = 5;
            }

            if($model->discounts_month == 'June'){
                $model->discounts_slot = 6;
            }

            if($model->discounts_month == 'July'){
                $model->discounts_slot = 7;
            }

            if($model->discounts_month == 'August'){
                $model->discounts_slot = 8;
            }

            if($model->discounts_month == 'September'){
                $model->discounts_slot = 9;
            }

            if($model->discounts_month == 'October'){
                $model->discounts_slot = 10;
            }

            if($model->discounts_month == 'November'){
                $model->discounts_slot = 11;
            }

            if($model->discounts_month == 'December'){
                $model->discounts_slot = 12;
            }

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        } else {

            $model->discounts_code = strtoupper(uniqid());

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Discounts model.
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
     * Deletes an existing Discounts model.
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
     * Finds the Discounts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Discounts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Discounts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
