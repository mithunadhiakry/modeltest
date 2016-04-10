<?php

namespace backend\controllers;

use Yii;
use backend\models\Subject;
use backend\models\SubjectSearch;
use backend\models\Country;
use backend\models\Categorysubjectrel;
use backend\models\Category;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * SubjectController implements the CRUD actions for Subject model.
 */
class SubjectController extends Controller
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
     * Lists all Subject models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subject model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $category_subject_model_q = Categorysubjectrel::find()->where(['subject_id'=>$id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'category_subject_model_q' => $category_subject_model_q
        ]);
    }

    /**
     * Creates a new Subject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subject();
        $country_model = new Country();

        if ($model->load(Yii::$app->request->post())) {
           
            if($model->save()){              

                return $this->redirect(['view', 'id' => $model->id]);               

            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'country_model' => $country_model
            ]);
        }
    }

    /**
     * Updates an existing Subject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);;
        


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
     * Deletes an existing Subject model.
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
     * Finds the Subject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subject::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetchildparentdata(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Category::find()->andWhere(['country_id'=>$id,'parent_id'=> 0])->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account->id, 'name' => $account->category_name];
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

    public function actionGetchildsubcategorydata(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);

            $list = Category::find()->andWhere(['parent_id'=>$id])->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account->id, 'name' => $account->category_name];
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
