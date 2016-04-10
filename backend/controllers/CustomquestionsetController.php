<?php

namespace backend\controllers;

use Yii;
use backend\models\Questionset;
use backend\models\QuestionsetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use backend\models\Question;
use backend\models\Subject;
use backend\models\QuestionSearch;
use backend\models\questionsetitems;
use app\models\User;
use backend\models\AssignExam;
use backend\models\AnswerList;
use backend\models\Model;
/**
 * QuestionsetController implements the CRUD actions for Questionset model.
 */
class CustomquestionsetController extends Controller
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


    public function actionIndex()
    {
        $searchModel = new QuestionsetSearch();
        $dataProvider = $searchModel->customsearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new Questionset();

        if ($model->load(Yii::$app->request->post())) {
            
            $model->question_set_id = 'cqs_'.time();
            $model->country_id = 0;
            $model->category_id = 0;
            $model->sub_category_id = 0;
            $model->subject_id = '0';
            $model->subject_with_q_no = '0';

            $valid = $model->validate();
            if($valid){
                $model->save();

                return $this->redirect(['update', 'id' => $model->id]);
            }else{
                echo '<pre>';
                var_dump($model->getErrors());
                exit();
            }
            
        } 

        return $this->render('create', [
                'model' => $model,
            ]);
    }

    public function actionAssign_questionset(){
        $searchModel = new QuestionsetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('assign_question', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAssign_user($id){

        $model = $this->findModel($id);
        $user_id = \Yii::$app->user->identity->id;

        $get_all_assigned_exam = AssignExam::find()
                                ->where(['assign_by' => $user_id])
                                ->andWhere(['question_set_id' => $model->question_set_id])
                                ->all();

        return $this->render('assign_view', [
            'model' => $this->findModel($id),
            'get_all_assigned_exam_r' => $get_all_assigned_exam
        ]);
    }


    public function actionAssign_exam(){
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];

            $email = $_POST['email_address'];
            $exam_id = $_POST['exam_id'];

            $assign_by = \Yii::$app->user->identity->id;

            $assign_to_data = User::find()->where(['email'=>$email])
                                        ->andWhere(['user_type'=>'student'])
                                        ->one();
            if(!empty($assign_to_data)){

                $already_assing_this_exam = AssignExam::find()
                                            ->where(['assign_by' => $assign_by])
                                            ->andWhere(['assign_to' => $assign_to_data->id])
                                            ->andWhere(['question_set_id' => $exam_id])
                                            ->one();

                if(!empty($already_assing_this_exam)){

                    $response['result'] = 'error';
                    $response['msg'] = '<div class="btn btn-warning">Already Assigned.</div>';
                    return $response;

                }else{

                    $assign_to = $assign_to_data->id;

                    $assign_model = new AssignExam();

                    $assign_model->assign_by = $assign_by;
                    $assign_model->assign_to = $assign_to;
                    $assign_model->question_set_id = $exam_id;
                    $assign_model->status = '0';

                    $message = Yii::$app->mailer->compose();

                    $mail_data = $this->renderPartial('_assign_exam_mail_template');
                    $message->SetFrom(["modeltest.abedon@gmail.com"=>"admin@model-test.com"]);
                    $message->setTo($email);
                    $message->setSubject("Invite friend | Model Test");
                    $message->setHtmlBody($mail_data);
                    $message->send();

                    $assign_model->save();

                    $response['result'] = 'success';
                    $response['successmsg'] = "<tr><td>".$email."</td><td>Not Attend</td></tr>";
                    $response['msg'] = '<div class="btn btn-success">Successfully Saved.</div>';
                    return $response;

                }
                


            }else{

                $response['result'] = 'error';
                $response['msg'] = '<div class="btn btn-warning">This email is not present in the database.</div>';
                return $response;
            }

            if($email == \Yii::$app->user->identity->email){
                $response['result'] = 'error';
                $response['msg'] = '<div class="btn btn-warning">You can\'t assign yourself.</div>';
                return $response;
            }


        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //getting already added questions
        $data = questionsetitems::find()->where(['question_set_id'=>$model->question_set_id])->asArray()->all();
        if(!empty($data)){
            $data = ArrayHelper::getColumn($data,'question_id');
        }else{
            $data = array('999999999');
        }
        //getting already added questions

        //gettings selected question list
        $searchModel1 = new QuestionSearch();
        $searchModel1->id = $data;
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
        //gettings selected question list

        if ($model->load(Yii::$app->request->post())) {

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            return $this->render('update', [
                'model' => $model,
                'searchModel1' => $searchModel1,
                'dataProvider1' => $dataProvider1
            ]);
        }
    }


    public function actionAddquestion($id){

        $model_set = $this->findModel($id);
        //getting already added questions
        $data = questionsetitems::find()->where(['question_set_id'=>$model_set->question_set_id])->asArray()->all();
        if(!empty($data)){
            $data = ArrayHelper::getColumn($data,'question_id');
        }else{
            $data = array('999999999');
        }
        //getting already added questions

        //gettings selected question list
        $searchModel1 = new QuestionSearch();
        $searchModel1->id = $data;
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
        //gettings selected question list


        $model = new Question;
        $ans_model[0] = new AnswerList;
        $ans_model[1] = new AnswerList;
        $ans_model[2] = new AnswerList;
        $ans_model[3] = new AnswerList;
        

        if ($model->load(Yii::$app->request->post())) {
            $model->country_id = 1;
            $model->chapter_id = 0;
            $model->category_id = 0;
            $model->sub_category_id = 0;
            $model->subject_id = 0;

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
                        $questionsetitems_model = new questionsetitems();
                        $questionsetitems_model->question_id = $model->id;
                        $questionsetitems_model->question_set_id = $model_set->question_set_id;
                        $questionsetitems_model->subject_id = 0;
                        if (! ($flag = $questionsetitems_model->save(false))) {
                            $transaction->rollBack();
                            break;
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
                        \Yii::$app->getSession()->setFlash('success', 'Question successfully created.');
                        return $this->redirect(['addquestion', 'id' => $id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('add_question', [
                'model_set' => $model_set,
                'searchModel1' => $searchModel1,
                'dataProvider1' => $dataProvider1,
                'model' => $model,
                'ans_model'=>$ans_model
            ]);
    }


    public function actionDelete_question($id){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];

            $question = Question::find()->where(['id'=>$id])->one();
            $question_id = $question->id;
            if(!empty($question)){
                $answers = AnswerList::find()->where(['question_id' => $question_id])->all();

                if(!empty($answers)){
                    foreach ($answers as $key => $value) {
                        $value->delete();
                    }
                }

                $questionsetitems = questionsetitems::find()->where(['question_id'=>$question_id])->one();
                if(!empty($questionsetitems)){
                    $questionsetitems->delete();
                }

                $question->delete();

                $response['result'] = 'success';
                $response['msg'] = 'Question successfully deleted.';
            }else{
                $response['result'] = 'error';
                $response['msg'] = 'Invalid question.';
            }
            
            return $response;
        }
    }



    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $question_set_id = $model->question_set_id;
        $model->delete();

        $questionsetitems_model = questionsetitems::deleteAll([
                                'question_set_id'=>$question_set_id,
                                ]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Questionset model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Questionset the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Questionset::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
