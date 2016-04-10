<?php

namespace backend\controllers;

use Yii;
use backend\models\Chapter;
use backend\models\ChapterSearch;
use backend\models\Subjectchapterrel;
use backend\models\Subject;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ChapterController implements the CRUD actions for Chapter model.
 */
class ChapterController extends Controller
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
     * Lists all Chapter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChapterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Chapter model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $subject_chapter_model_q = Subjectchapterrel::find()->where(['chapter_id'=>$id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'subject_chapter_model_q' => $subject_chapter_model_q
        ]);
    }

    /**
     * Creates a new Chapter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Chapter();

        if ($model->load(Yii::$app->request->post())) {
        //      $valid = $model->validate();
        //     if(!$valid){
        //     var_dump($model->getErrors());
        // }
        // exit();

             if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);;                
            }else{
                return $this->render('create', [
                    'model' => $model
                ]);
            }
            


        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Chapter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            
             if($model->save()){

                return $this->redirect(['view', 'id' => $model->id]);

            }


        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing Chapter model.
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
     * Finds the Chapter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chapter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chapter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetchildsubjectdata(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);

            $list = Subject::find()->andWhere(['sub_category_id'=>$id])->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account->id, 'name' => $account->subject_name];
                    if ($i == 0) {
                        $selected = $account->id;
                    }
                }
                // Shows how you can preselect a value
                echo json_encode(['output' => $out, 'selected'=>$selected,'id'=>$id]);
                return;
            }
        }
        echo json_encode(['output' => '', 'selected'=>'']);
    }
}
