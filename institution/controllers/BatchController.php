<?php

namespace institution\controllers;

use Yii;
use institution\models\Batch;
use institution\models\Students;
use institution\models\BatchSearch;
use institution\models\Questionset;
use institution\models\AssignExam;
use institution\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

use frontend\models\Userexamrel;
use frontend\models\Question;


class BatchController extends Controller
{
    public function beforeAction($action){
        
        if(!isset(Yii::$app->user->identity->username)){
            $url = explode('/institution', \Yii::$app->request->BaseUrl)[0];
            return $this->redirect($url);
        }
        
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['frontend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['frontend.theme'],
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
     * Lists all Batch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        $searchModel = new BatchSearch();
        
        $queryParams= Yii::$app->request->getQueryParams();
        if($session->has('course_id')){
            $searchModel->course_id = $session->get('course_id');
            $session->remove('course_id');
        }
        if($session->has('batch_id')){
            $searchModel->id = $session->get('batch_id');
            $session->remove('batch_id');
        }
        $queryParams['BatchSearch']['created_by'] = \Yii::$app->user->identity->id;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionSet_session(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            $response = [];

            $id = $_POST['id'];
            $type = $_POST['type'];

            if($type == 'course' && $id != 0){
                $session->set('course_id',$id);
            }
            elseif($type == 'batch' && $id != 0){
                $session->set('batch_id',$id);
            }

            $response['result'] = 'success';
            if($session->has('course_id')){
                $response['ccc'] = $session->get('course_id');
            }

            return $response;
        }
    }

     public function actionAssign_exam(){

        $batch_id = $_POST['batch_id'];
        $course_id = $_POST['course_id'];

        $response = '';

        $model = new Questionset();

        $assign_by = \Yii::$app->user->identity->id;

        $get_all_assigned_exam = AssignExam::find()                                
                                ->andWhere(['batch_id' => $batch_id])
                                ->andWhere(['course_id' => $course_id]) 
                                ->andWhere(['assign_by' => $assign_by])                              
                                ->all();

        $data = $this->renderAjax('assignexam_view',[
                'batch_id' => $batch_id,
                'model' => $model,
                'batch_id' => $batch_id,
                'course_id' => $course_id,
                'get_all_assigned_exam_r' => $get_all_assigned_exam
            ]);
        $response['message'] = $data;

        return json_encode($response);
    }

    public function actionGet_assigned_students(){
        $batch_id = $_POST['batch_id'];
        $course_id = $_POST['course_id'];
        $question_set = $_POST['Questionset']['question_set_name'];

        $response = '';

        $model = new Questionset();

        $assign_by = \Yii::$app->user->identity->id;

        $get_all_assigned_exam = AssignExam::find()                                
                                ->andWhere(['batch_id' => $batch_id])
                                ->andWhere(['course_id' => $course_id]) 
                                ->andWhere(['assign_by' => $assign_by])    
                                ->andWhere(['question_set_id' => $question_set])                              
                                ->all();

        $data = $this->renderAjax('get_assigned_students',[
                'batch_id' => $batch_id,
                'model' => $model,
                'batch_id' => $batch_id,
                'course_id' => $course_id,
                'get_all_assigned_exam_r' => $get_all_assigned_exam
            ]);
        $response['message'] = $data;

        return json_encode($response);
    }

    public function actionSetassignexam(){

        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];

            if(!empty($_POST['Questionset']['question_set_name'])){

                $exam_id = $_POST['Questionset']['question_set_name'];
                $batch_id = $_POST['batch_id'];
                $course_id = $_POST['course_id'];
                $assign_by = \Yii::$app->user->identity->id;

                $number_of_student_r = Students::find()
                    ->where(['batch_no' => $batch_id ])
                    ->all();

                $count = 0;

                foreach($number_of_student_r as $number_of_student){

                    $assign_to = $number_of_student->student_email;

                    $already_assing_this_exam = AssignExam::find()
                                            ->where(['assign_by' => $assign_by])
                                            ->andWhere(['assign_to' => $assign_to])
                                            ->andWhere(['question_set_id' => $exam_id])
                                            ->andWhere(['batch_id' => $batch_id])
                                            ->andWhere(['course_id' => $course_id])
                                            ->one();
                    
                    if(empty($already_assing_this_exam)){

                        $get_questionset_name = Questionset::find()
                                            ->where(['question_set_id' => $exam_id ])
                                            ->one();

                        $assign_model = new AssignExam();

                        $assign_model->assign_by = $assign_by;
                        $assign_model->assign_to = $assign_to;
                        $assign_model->question_set_id = $exam_id;
                        $assign_model->batch_id = $batch_id;
                        $assign_model->course_id = $course_id;
                        $assign_model->status = '0';

                        $get_student_data = User::find()
                                            ->where(['id' => $assign_to])
                                            ->one();


                        $message = Yii::$app->mailer->compose();

                        $mail_data = $this->renderPartial('_assign_exam_mail_template');
                        
                        $message->SetFrom(["modeltest.abedon@gmail.com"=>"admin@model-test.com"]);
                        $message->setTo($get_student_data->email);
                        $message->setSubject("Assign exam | Model Test");
                        $message->setHtmlBody($mail_data);
                        $message->send();

                        $assign_model->save();

                        $get_data_view = '';
                        
                        $get_data_view += $this->renderPartial('_view_template_data',[
                                    'student_email' => $get_student_data->email,
                                    'questionset_name' => $get_questionset_name->question_set_name
                            ]);
                        // $get_data_view = '';
                        // $get_data_view+="<tr><td>".$get_student_data->email."</td><td>".$get_questionset_name->question_set_name."</td><td>0%</td><td>Not Attend</td></tr>";

                        if(count($number_of_student_r) == $count++){
                            $response['result'] = 'success';
                            $response['successmsg'] = $get_data_view;
                            $response['msg'] = '<div class="btn btn-success">Successfully Assigned.</div>';
                            return $response; 
                        }

                        $count++;
                        
                    }


                    
                }

            }else{

                $response['result'] = 'error';
                $response['msg'] = '<div class="btn btn-warning">Please select a model test</div>';
                return $response;
            }

        }
    }


    public function actionReport($set_id){
        $session = Yii::$app->session;
        $exam_id = $set_id;

        $exam_data = Userexamrel::find()->where(['exam_id'=>$exam_id])->one();
        if(empty($exam_data)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $question_list = \yii\helpers\Json::decode($exam_data->exam_questions);

        $assign_exam_list_r = AssignExam::find()
                                ->where(['exam_id' => $exam_id])
                                ->all();


        return $this->render('report',[
                    'question_list' => $question_list,
                    'exam_data' => $exam_data,
                    'assign_exam_list_r' => $assign_exam_list_r
            ]);
    }

    public function actionGet_new_report_question(){
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];
            
            if(!isset($_POST['item']) || !isset($_POST['exam_id']) || !isset(\Yii::$app->user->identity->id)){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }

            $item = (int)$_POST['item'];
            $exam_id = $_POST['exam_id'];

            $exam_data = Userexamrel::find()->where(['exam_id'=>$exam_id])->one();
            

            $exam_questions = \yii\helpers\Json::decode($exam_data->exam_questions);
            if (array_key_exists($item, $exam_questions)) {
                $model = $exam_questions[$item];
            }else{
                $model = array();
            }
            
            
            if(!empty($model)){
                $question = Question::find()->where(['id'=>$model['question_id']])->one();
                
                $data = $this->renderAjax('reportQuestionItem',['model'=>$model,'question'=>$question]);

                $response['result'] = 'success';
                $response['message'] = $data;
                $response['item'] = $item;

                return $response;
            }
            else{
                $response['result'] = 'error';
                $response['message'] = 'No data found';
                return $response;
            }
            

        }
    }

    public function actionSummarize_report($set_id){
        $session = Yii::$app->session;
        $exam_id = $set_id;

        $exam_data = Userexamrel::find()->where(['exam_id'=>$exam_id])->one();
        if(empty($exam_data)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $question_list = \yii\helpers\Json::decode($exam_data->exam_questions);

        $assign_exam_list_r = AssignExam::find()
                                ->where(['exam_id' => $exam_id])
                                ->all();


        return $this->render('summarize_report',[
                    'question_list' => $question_list,
                    'exam_data' => $exam_data,
                    'exam_id' => $exam_id,
                    'assign_exam_list_r' => $assign_exam_list_r
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
        $model = new Batch();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Batch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
