<?php

namespace backend\controllers;

use Yii;
use  yii\web\Session;

use backend\models\Question;
use backend\models\QuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use backend\models\Model;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use backend\models\AnswerList;
use backend\models\Category;
use backend\models\Subject;
use backend\models\Chapter;
use backend\models\Countrycategoryrel;
use backend\models\Categorysubjectrel;
use backend\models\Subjectchapterrel;
use backend\models\QuestionCountryRels;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller
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
     * Lists all Question models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $answer_list = AnswerList::find()->where(['question_id'=>$id])->all();
        $model = $this->findModel($id);

        if(($model->created_by == Yii::$app->user->identity->id) || Yii::$app->user->identity->id == 9  ){

            return $this->render('view', [
                'model' => $model,
                'answer_list'=> $answer_list
            ]);


        }else{

            echo 'You have no permission';
        }
       
    }

    public function actionCreate()
    {
        $model = new Question;
        $ans_model[0] = new AnswerList;
        $ans_model[1] = new AnswerList;
        $ans_model[2] = new AnswerList;
        $ans_model[3] = new AnswerList;
        

        if ($model->load(Yii::$app->request->post())) {

           

            $ans_model = Model::createMultiple(AnswerList::classname());
            Model::loadMultiple($ans_model, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($ans_model),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($ans_model) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($ans_model as $ans_modelsss) {
                            $ans_modelsss->question_id = $model->id;
                            $ans_modelsss->sort_order = 1;
                            if (! ($flag = $ans_modelsss->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();

                        if(isset($_POST['submit']) && $_POST['submit'] == 'save_next'){

                            $ans_model[0] = new AnswerList;
                            $ans_model[1] = new AnswerList;
                            $ans_model[2] = new AnswerList;
                            $ans_model[3] = new AnswerList;

                            $model->details = '';

                            return $this->render('create', [
                                'model' => $model,'ans_model'=>$ans_model
                            ]);

                        }else{

                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                        
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
                'model' => $model,'ans_model'=>$ans_model
            ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(($model->created_by == Yii::$app->user->identity->id) || Yii::$app->user->identity->id == 9  ){



                $ans_model = AnswerList::find()->where(['question_id'=>$id])->all();

                if ($model->load(Yii::$app->request->post())) {

                    $ans_model = Model::createMultiple(AnswerList::classname());
                    Model::loadMultiple($ans_model, Yii::$app->request->post());

                    // ajax validation
                    if (Yii::$app->request->isAjax) {
                        Yii::$app->response->format = Response::FORMAT_JSON;
                        return ArrayHelper::merge(
                            ActiveForm::validateMultiple($ans_model),
                            ActiveForm::validate($model)
                        );
                    }

                    // validate all models
                    $valid = $model->validate();
                    $valid = Model::validateMultiple($ans_model) && $valid;

                    if ($valid) {
                        $transaction = \Yii::$app->db->beginTransaction();
                        try {
                            if ($flag = $model->save(false)) {
                                $old_ans_model = AnswerList::find()->where(['question_id'=>$id])->all();
                                foreach ($old_ans_model as $key) {
                                    $key->delete();
                                }
                            
                                foreach ($ans_model as $ans_modelsss) {
                                    $ans_modelsss->question_id = $model->id;
                                    $ans_modelsss->sort_order = 1;
                                    if (! ($flag = $ans_modelsss->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
                                }
                            }
                            if ($flag) {
                                $transaction->commit();

                                if(isset($_POST['submit']) && $_POST['submit'] == 'update_edit_another'){

                                    $subject_id = $model->subject_id;

                                    $next = Question::find()->where(['subject_id' => $subject_id])->andWhere(['>', 'id', $model->id])->one();

                                    if(!empty($next)){
                                       $next_question_id = $next->id;
                                    }else{
                                        $prev = Question::find()->where(['subject_id' => $subject_id])->orderBy('id asc')->one();
                                        $next_question_id = $prev->id;
                                    }
                                    
                                    return $this->redirect(['update', 'id' => $next_question_id]);

                                }else{
                                    return $this->redirect(['view', 'id' => $model->id]);
                                }
                                
                            }
                        } catch (Exception $e) {
                            $transaction->rollBack();
                        }
                    }
                }

                return $this->render('update', [
                        'model' => $model,'ans_model'=>$ans_model
                    ]);

        }else{

            echo 'You have no permission';
        }
    }


    public function actionDelete($id)
    {

        $model = AnswerList::find()->where(['id'=>$id])->all();
        if(!empty($model)){
            foreach ($model as $key) {
               $key->delete();
            }
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }








    public function actionGetchildcategories(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Category::find()->andWhere(['country_id'=>$id,'parent_id'=>0,'category_status'=>1])->all();
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

    public function actionGetsubcategories(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Category::find()->andWhere(['parent_id'=>$id,'category_status'=>1])->all();
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



    public function actionGetchildsubjects(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Subject::find()->Where(['sub_category_id'=>$id,'subject_status' => '1'])->all();
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
                echo json_encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo json_encode(['output' => 'dd', 'selected'=>'']);
    }

    public function actionGetchildchapters(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = Chapter::find()->andWhere(['subject_id'=>$id,'chapter_status' => '1'])->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account->id, 'name' => $account->chaper_name];
                    if ($i == 0) {
                        $selected = $account->id;
                    }
                }
                // Shows how you can preselect a value
                echo json_encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo json_encode(['output' => '', 'selected'=>'']);
    }
}
