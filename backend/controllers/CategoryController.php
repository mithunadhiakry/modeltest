<?php

namespace backend\controllers;

use Yii;
use backend\models\Country;
use backend\models\Category;
use backend\models\CategorySearch;
use backend\models\Countrycategoryrel;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
       
        $model = new Category();

               
        $searchModel = new CategorySearch();
        $queryParams= Yii::$app->request->getQueryParams();
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

      $country_category_model_q = Countrycategoryrel::find()->where(['category_id'=>$id])->all();

      return $this->render('view', [
          'model' => $this->findModel($id),
          'country_category_model_q' => $country_category_model_q
      ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        $country_category_rel_model = new Countrycategoryrel();

        if ($model->load(Yii::$app->request->post())) {
            

            // $post = Yii::$app->request->post();
            
            // if(empty($model->parent_id)){
            //     echo 'yes';
            // }else{
            //     echo 'no';
            // }
            
           
            if($model->save()){
              
              // $country_category_rel_model = new Countrycategoryrel();

              // $country_category_rel_model->country_id = $post['Countrycategoryrel']['country_id'];
              // $country_category_rel_model->category_id = $model->id;

              // $country_category_rel_model->save();

              return $this->redirect(['view', 'id' => $model->id]);;
            
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'country_category_rel_model' => $country_category_rel_model
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
           
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        

        $country_category_rel_list = Countrycategoryrel::find()->where("category_id = $id")->all();
        
        foreach($country_category_rel_list as $country_category_rel){
            $country_category_rel->delete();
        }
        

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetparentofcountry(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Category::find()->andWhere(['country_id'=>$id,'parent_id' => 0])->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                 $out[] = ['id' => '0', 'name' => 'Select Parent'];
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
