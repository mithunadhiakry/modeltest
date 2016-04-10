<?php

namespace institution\controllers;

use Yii;
use institution\models\Students;
use institution\models\StudentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

use institution\models\Batch;
use institution\models\Questionset;
use institution\models\AssignExam;
use institution\models\User;
use institution\models\UserSearch;

/**
 * StudentsController implements the CRUD actions for Students model.
 */
class StudentsController extends Controller
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
     * Lists all Students models.
     * @return mixed
     */

    public function actionNewstudent(){
        
        $session = Yii::$app->session;
        $searchModel = new UserSearch();

        $queryParams= Yii::$app->request->getQueryParams();
        if($session->has('course_id')){
            $searchModel->course_id = $session->get('course_id');
            $session->remove('course_id');
        }
        if($session->has('batch_id')){
            $searchModel->id = $session->get('batch_id');
            $session->remove('batch_id');
        }
        
        $queryParams['UserSearch']['institution_id'] = \Yii::$app->user->identity->id;
        $queryParams['UserSearch']['approved_by_institution'] = '0';

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('newrequestedstudents', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }


    public function actionIndex()
    {
        $session = Yii::$app->session;
        $searchModel = new StudentsSearch();

        $queryParams= Yii::$app->request->getQueryParams();
        if($session->has('course_id')){
            $searchModel->course_id = $session->get('course_id');
            $session->remove('course_id');
        }
        if($session->has('batch_id')){
            $searchModel->id = $session->get('batch_id');
            $session->remove('batch_id');
        }
        $queryParams['StudentsSearch']['created_by'] = \Yii::$app->user->identity->id;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStudentconfirm($id){
      
        $user_data = User::find()->where(['id' => $id])->one();

        if(!empty($user_data)){

            $user_data->approved_by_institution = 1;

            if($user_data->save()){
                 return $this->redirect(['newstudent']);
            }
        }
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

    /**
     * Displays a single Students model.
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
     * Creates a new Students model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Students();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Students model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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


    public function actionAssign_exam(){

        $batch_id = $_POST['batch_id'];
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];

        $response = '';

        $model = new Questionset();

        $get_all_assigned_exam = AssignExam::find()
                                ->where(['assign_to' => $student_id])
                                ->andWhere(['batch_id' => $batch_id])
                                ->andWhere(['course_id' => $course_id])                               
                                ->all();

        $data = $this->renderAjax('assignexam_view',[
                'batch_id' => $batch_id,
                'model' => $model,
                'batch_id' => $batch_id,
                'student_id' => $student_id,
                'course_id' => $course_id,
                'get_all_assigned_exam_r' => $get_all_assigned_exam
            ]);
        $response['message'] = $data;

        return json_encode($response);
    }

    /**
     * Deletes an existing Students model.
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
     * Finds the Students model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Students the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Students::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetbatchdata(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $course_id = end($_POST['depdrop_parents']);
            $list = Batch::find()->Where(['course_id'=>$course_id])->all();
            $selected  = null;
            if ($course_id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account->id, 'name' => $account->batch_no];
                    if ($i == 0) {
                        $selected = $account->id;
                    }
                }
                // Shows how you can preselect a value
                echo json_encode(['output' => $out, 'selected'=>$selected,'id'=>$course_id]);
                return;
            }
        }
        echo json_encode(['output' => '', 'selected'=>'']);
    }


    public function actionSetassignexam(){
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];

            
            if(!empty($_POST['Questionset']['question_set_name'])){

                $exam_id = $_POST['Questionset']['question_set_name'];
                $batch_id = $_POST['batch_id'];
                $assign_to = $_POST['student_id'];
                $course_id = $_POST['course_id'];
                $assign_by = \Yii::$app->user->identity->id;

                $already_assing_this_exam = AssignExam::find()
                                            ->where(['assign_by' => $assign_by])
                                            ->andWhere(['assign_to' => $assign_to])
                                            ->andWhere(['question_set_id' => $exam_id])
                                            ->andWhere(['batch_id' => $batch_id])
                                            ->andWhere(['course_id' => $course_id])
                                            ->one();

                if(!empty($already_assing_this_exam)){

                    $response['result'] = 'error';
                    $response['msg'] = '<div class="btn btn-warning">Already Assigned.</div>';
                    return $response;

                }else{

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

                    $response['result'] = 'success';
                    $response['successmsg'] = "<tr><td>".$get_questionset_name->question_set_name."</td><td>0%</td><td>Not Attend</td></tr>";
                    $response['msg'] = '<div class="btn btn-success">Successfully Assigned.</div>';
                    return $response;

                }


            }else{

                $response['result'] = 'error';
                $response['msg'] = '<div class="btn btn-warning">Please select a model test</div>';
                return $response;
            }
            
        }
    }




}


