<?php

namespace backend\controllers;

use Yii;
use backend\models\Questionset;
use backend\models\QuestionsetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;

use backend\models\Question;
use backend\models\Subject;
use backend\models\QuestionSearch;
use backend\models\questionsetitems;
use app\models\User;
use backend\models\AssignExam;
/**
 * QuestionsetController implements the CRUD actions for Questionset model.
 */
class QuestionsetController extends Controller
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
            
            $model->question_set_id = 'qs_'.time();

            $subject_id_array = array();
            $subject_with_q_no = array();

            $total_number_of_question = 0;

            foreach ($model->subject as $key => $value) {
                if($model->no_of_question[$key] !=0){
                    array_push($subject_id_array, $value);
                    array_push($subject_with_q_no, array('subject_id'=>$value, 'no_of_question' => $model->no_of_question[$key]));
                    
                    $total_number_of_question += $model->no_of_question[$key];
                }
            }


            if($total_number_of_question > 180){

                $model = new Questionset();

                return $this->render('create', [
                    'model' => $model,
                ]);

            }
            

            $model->subject_id = \yii\helpers\Json::encode($subject_id_array);
            $model->subject_with_q_no = \yii\helpers\Json::encode($subject_with_q_no);

            $valid = $model->validate();
            if($valid){
                $model->save();


                if(!empty($subject_with_q_no) && $model->type == 'Automated'){
                    foreach ($subject_with_q_no as $value) {
                        $data = Question::find()->where(['subject_id'=>$value['subject_id']])
                                            ->orderBy('rand()')
                                            ->limit($value['no_of_question'])
                                            ->all();
                        if(!empty($data)){
                            foreach ($data as $q) {
                                $questionsetitems_model = new questionsetitems();
                                $questionsetitems_model->question_id = $q->id;
                                $questionsetitems_model->question_set_id = $model->question_set_id;
                                $questionsetitems_model->subject_id = $q->subject_id;

                                $valid = $questionsetitems_model->validate();
                                if($valid){
                                    $questionsetitems_model->save();
                                }
                            }
                        }
                    }
                }
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

                    $mail_data = $this->renderPartial('_assign_exam_mail_template',[
                            'assign_to_data' => $assign_to_data
                        ]);
                   
                    $message->SetFrom(["modeltest.abedon@gmail.com"=>"admin@model-test.com"]);
                    $message->setTo($email);
                    $message->setSubject("Assign Exam | Model Test". " | " .$exam_id);
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
        $model->subject_id = \yii\helpers\Json::decode($model->subject_id);
        $model->subject = \yii\helpers\Json::decode($model->subject_with_q_no);

        $prev_subjects = $model->subject_id;

        //getting already added questions
        $data = questionsetitems::find()->where(['question_set_id'=>$model->question_set_id])->asArray()->all();
        if(!empty($data)){
            $data = ArrayHelper::getColumn($data,'question_id');
        }else{
            $data = array('999999999');
        }
        //getting already added questions

        //getting question list for selection
        $searchModel = new QuestionSearch();
        $searchModel->sub_category_id = $model->sub_category_id;
        $searchModel->subject_id = $model->subject_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $data ,'added_list');
        //getting question list for selection

        //gettings selected question list
        $searchModel1 = new QuestionSearch();
        $searchModel1->id = $data;
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
        //gettings selected question list

        if ($model->load(Yii::$app->request->post())) {

            $subject_id_array = array();
            $subject_with_q_no = array();

            foreach ($model->subject as $key => $value) {
                if($model->no_of_question[$key] !=0){
                    array_push($subject_id_array, $value);
                    array_push($subject_with_q_no, array('subject_id'=>$value, 'no_of_question' => $model->no_of_question[$key]));
                
                }
            }

            $model->subject_id = \yii\helpers\Json::encode($subject_id_array);
            $model->subject_with_q_no = \yii\helpers\Json::encode($subject_with_q_no);

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            return $this->render('update', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'searchModel1' => $searchModel1,
                'dataProvider1' => $dataProvider1
            ]);
        }
    }

    public function actionGet_subjects(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $response = [];
            $sub_category_id = $_POST['sub_cat_id'];

            $subjects = Subject::find()->where(['sub_category_id'=>$sub_category_id])->all();

            if(!empty($subjects)){
                $data = $this->renderAjax('_subject_list',['model'=>$subjects]);

                $response['result'] = 'success';
                $response['message'] = $data;
            }else{
                $response['result'] = 'success';
                $response['message'] = 'No subject found.';
            }

            return $response;
        }
    }

    public function actionAdd_item($id,$sub_id){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $response = [];

            $question_model = Question::find()->where(['id'=>$id,'subject_id'=>$sub_id])->one();
            if(!empty($question_model)){
                $questionsetitems_model = new questionsetitems();
                $questionsetitems_model->question_id = $id;
                $questionsetitems_model->question_set_id = $_POST['set'];
                $questionsetitems_model->subject_id = $sub_id;

                $valid = $questionsetitems_model->validate();
                if($valid){
                    $questionsetitems_model->save();
                    
                    $response['result'] = 'success';
                    $response['message'] = $id; 
                }
                else{
                    $response['result'] = 'error';
                    $response['message'] = 'Invalid request';
                }

                
            }else{
                $response['result'] = 'error';
                    $response['message'] = 'Invalid request';
            }
            return $response;
        }
    }


    public function actionRemove_item($id,$sub_id){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $response = [];

            $questionsetitems_model = questionsetitems::find()
                        ->where([
                                'question_id'=>$id,
                                'subject_id'=>$sub_id,
                                'question_set_id'=>$_POST['set']
                                ])
                        ->one();
            if(!empty($questionsetitems_model)){
                $questionsetitems_model->delete();

                $response['result'] = 'success';
                $response['message'] = $id; 

            }else{
                $response['result'] = 'error';
                    $response['message'] = 'Invalid request';
            }
            return $response;
        }
    }



    /**
     * Deletes an existing Questionset model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
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
