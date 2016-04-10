<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use frontend\models\Category;
use frontend\models\Chapter;
use frontend\models\Tempquestionlist;
use frontend\models\Question;
use frontend\models\Rest;
use frontend\models\Userexamrel;
use frontend\models\Questionset;
use frontend\models\questionsetitems;
use frontend\models\AssignExam;
use frontend\models\User;
use frontend\models\AdManagement;


class RestController extends Controller
{

    public function beforeAction($action){
        
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['frontend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['frontend.theme'],
        ]);

        return parent::beforeAction($action);
    }

    public function actionSave_answer(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            $response = [];

            $update_session = Rest::updateSession();

            if(!isset(\Yii::$app->user->identity->id)){
                $response['result'] = 'error';
                $response['message'] = 'Please Login and try again.';
                return $response;
            }

            if(!isset($_POST['type']) || !isset($_POST['val']) || ($_POST['type'] !='mark_review' && $_POST['type'] !='skip' && $_POST['type'] !='prev' && $_POST['type'] !='save_and_next')){
                $response['result'] = 'error';
                $response['message'] = 'Invalid Request.';
                return $response;
            }

            $exam_id = $session->get('current_exam_id');
            $question_id = $session->get('current_question_id');

            $data = Tempquestionlist::find()->where(['exam_id'=>$exam_id,'question_id'=>$question_id])->one();
            
            if($_POST['type'] == 'mark_review'){
                $data->mark_for_review = 1;
                $data->is_correct = $_POST['val'];

                $selected_result['item_id'] = 'q_'.$data->serial.$data->question_id;
                $selected_result['item_class'] = 'marked';
            }
            elseif($_POST['type'] == 'skip' || $_POST['type'] == 'prev'){
                $selected_result['item_id'] = 'q_'.$data->serial.$data->question_id;
                $selected_result['item_class'] = '';
            }
            elseif($_POST['type'] == 'save_and_next'){
                $data->mark_for_review = 0;
                $data->is_correct = $_POST['val'];

                $selected_result['item_id'] = 'q_'.$data->serial.$data->question_id;
                $selected_result['item_class'] = 'answer';
            }
            

            if($data->save()){
                if($_POST['type'] == 'prev'){
                    $new_question = Rest::getPrevQuestion($exam_id, $data, $_POST['type']); 
                }else{
                    $new_question = Rest::getNextQuestion($exam_id, $data, $_POST['type']);
                }
                

                if(!empty($new_question)){
                    $new_question_data = $this->renderAjax('newQuestion',['model'=>$new_question]);

                    $Userexamrel_model = Userexamrel::find()->where(['exam_id'=>$exam_id])->one();
                    $Userexamrel_model->time_spent = $update_session;
                    $Userexamrel_model->save();


                    $session->set('current_question_id',$new_question->question_id);
                    $response['result'] = 'success';
                    $response['message'] = $new_question_data;
                    $response['chapter_id'] = $new_question->chapter_id;
                    $response['selected_result'] = $selected_result;
                    $response['status'] = 'Not Completed';
                    $response['is_review'] = ($new_question->mark_for_review == 1)?'yes':'no';
                    $response['is_skip'] = ($new_question->is_skip == 1)?'yes':'no';

                    $check_review_present = Tempquestionlist::find()->where(['exam_id'=>$exam_id,'mark_for_review'=>'1'])->one();
                    if(!empty($check_review_present)){
                        $response['is_review_exist'] = 'yes';    
                    }else{
                        $response['is_review_exist'] = 'no';
                    }
                    
                   

                    $response['h'] = $session->get('current_exam_time.hours');
                    $response['m'] = $session->get('current_exam_time.mins');
                    $response['s'] = $session->get('current_exam_time.secs');
                    return $response;
                }else{
                    $response['result'] = 'success';
                    $response['message'] = 'You have completed all questions in this exam. <br/><br/>Please <strong>"Submit"</strong> Now';
                    $response['selected_result'] = $selected_result;
                    $response['status'] = 'Completed'.$exam_id.','.$question_id;
                    return $response;
                }

            }else{
                $response['result'] = 'error';
                $response['message'] = 'Invalid Request.';
                return $response; 
            }

        }
    }


    public function actionGet_specific_question(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            $response = [];

            $update_session = Rest::updateSession();

            if(!isset(\Yii::$app->user->identity->id)){
                $response['result'] = 'error';
                $response['message'] = 'Please Login and try again.';
                return $response;
            }

            if(!isset($_POST['val'])){
                $response['result'] = 'error';
                $response['message'] = 'Invalid Request.';
                return $response;
            }

            $exam_id = $session->get('current_exam_id');
            $question_serial = $_POST['val'];
            
            $new_question = Tempquestionlist::find()
                            ->where(['exam_id'=>$exam_id])
                            ->andWhere(['serial'=>$_POST['val']])
                            ->one();
            

                if(!empty($new_question)){
                    $new_question_data = $this->renderAjax('newQuestion',['model'=>$new_question]);

                    $Userexamrel_model = Userexamrel::find()->where(['exam_id'=>$exam_id])->one();
                    $Userexamrel_model->time_spent = $update_session;
                    $Userexamrel_model->save();


                    $session->set('current_question_id',$new_question->question_id);
                    $response['result'] = 'success';
                    $response['message'] = $new_question_data;
                    $response['chapter_id'] = $new_question->chapter_id;
                    $response['status'] = 'Not Completed';

                    $response['h'] = $session->get('current_exam_time.hours');
                    $response['m'] = $session->get('current_exam_time.mins');
                    $response['s'] = $session->get('current_exam_time.secs');
                    return $response;
                }else{
                    $response['result'] = 'error';
                    $response['message'] = 'Invalid Request.';
                    return $response;
                }

        }
    }


    public function actionStart_exam_check(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            $response = [];
            $response['message'] = '';
            $flag = 0;
            $exam_id = \Yii::$app->user->identity->id.'_'.time();

            if(\Yii::$app->user->isGuest){
                $response['result'] = 'login_error';
                $response['redirect_url'] = Url::toRoute(['site/login']);
                return $response;
            }

            if( !isset($_POST['number_of_question']) || !isset($_POST['time_limit']) || !isset($_POST['share_facebook_report'])){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }
            $number_of_question = (int)$_POST['number_of_question'];
            $time_limit = (int)$_POST['time_limit'];

            if($session->has('chapter_list')){
                $chapter_list_session = $session->get('chapter_list');
            }else{
                $chapter_list_session = array();
            }

            $point_to_be_deducted = Rest::get_number_of_point_to_be_deducted($chapter_list_session);
            $check_point = Rest::check_available_point($point_to_be_deducted);

            if(!$check_point){
                $response['result'] = 'error';
                $response['message'] = 'You don\'t have sufficient points.';
                return $response;
            }
                
            

            $number_of_category = count($chapter_list_session);
            if($number_of_category > $number_of_question){
                $flag = 1;
                $response['message'] = $response['message'].'<p>Number of question must be greater than number of chapters.</p>';
            }

            if($number_of_question > 100){
                $flag = 1;
                $response['message'] = $response['message'].'<p>You are not allowed to take more than 100 questions.</p>';
            }
            if($number_of_question < 1){
                $flag = 1;
                $response['message'] = $response['message'].'<p>You are not allowed to take less than 20 questions.</p>';
            }
            if($time_limit > 120){
                $flag = 1;
                $response['message'] = $response['message'].'<p>You are not allowed to take more than 2 hour exam time.</p>';
            }
            if($time_limit < 1){
                $flag = 1;
                $response['message'] = $response['message'].'<p>You are not allowed to take less than 1 minutes exam time.</p>';
            }

            if($flag == 1){
                $response['result'] = 'error';
                return $response;
            }else{
                
                $remainder = $number_of_question % $number_of_category;
                $number_of_item_in_each_chapter = (int)($number_of_question / $number_of_category);

                $question_in_chapter_hiarchy = array();
                for($i=0;$i<$number_of_category;$i++){
                    if($i==0 && $remainder > 0){
                        array_push($question_in_chapter_hiarchy, array(
                                'chapter_id'=>$chapter_list_session[$i],
                                'item'=> ($number_of_item_in_each_chapter+$remainder),
                                ));
                    }else{
                        array_push($question_in_chapter_hiarchy, array(
                                'chapter_id'=>$chapter_list_session[$i],
                                'item'=> $number_of_item_in_each_chapter,
                                ));
                    }
                }

                $final_question_list = array();
                $item_num = 1;
                
                foreach ($question_in_chapter_hiarchy as $key) {
                    $data = Question::find()->where(['chapter_id'=>$key['chapter_id']])->orderBy('rand()')->limit($key['item'])->all();
                    
                    foreach ($data as $question) {
                        $tempQuestionModel = new Tempquestionlist();
                        $tempQuestionModel->chapter_id = $key['chapter_id'];
                        $tempQuestionModel->user_id = \Yii::$app->user->identity->id;
                        $tempQuestionModel->question_id = $question->id;
                        $tempQuestionModel->answer_id = $question->correct_answer->id;
                        $tempQuestionModel->is_correct = 0;
                        $tempQuestionModel->mark_for_review = 0;
                        $tempQuestionModel->serial = $item_num;
                        $tempQuestionModel->exam_id = $exam_id;

                        $tempQuestionModel->save();
                        $item_num++;
                    }
                    
                }

                $Userexamrel_model = new Userexamrel();
                $Userexamrel_model->user_id = \Yii::$app->user->identity->id;
                $Userexamrel_model->exam_id = $exam_id;
                $Userexamrel_model->question_set_id = '0';
                $Userexamrel_model->number_of_question = $number_of_question;
                $Userexamrel_model->exam_time = (string)$time_limit;
                $Userexamrel_model->created_at = date('Y-m-d H:i:s');
                $Userexamrel_model->time_spent = 0;
                $Userexamrel_model->assign_by = \Yii::$app->user->identity->id;


                if($Userexamrel_model->save()){

                    $deduct = Rest::deduct_point($point_to_be_deducted, $exam_id);

                }

                $session->set('current_exam_id',$exam_id);
                $hours = intval($time_limit / 60);  // integer division
                $mins = $time_limit % 60;

                $session->set('current_exam_time.hours',$hours);
                $session->set('current_exam_time.mins',$mins);
                $session->set('current_exam_time.secs','00');

                $total_time = $hours.':'.$mins.':00';
                $total_time_timestamp = strtotime($total_time);
                $session->set('total_time_timestamp',$total_time_timestamp);

                $session->set('current_exam_start_time',time());
                $session->set('share_facebook_report', $_POST['share_facebook_report']);

                $session->remove('chapter_list');
                $session->remove('current_question_id');

                $response['result'] = 'success';
                $response['redirect_url'] = Url::toRoute(['exam/view','exam_id'=>$exam_id]);
                return $response;

            }
        }
    }

    public function actionStart_exam_check_model_test(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            $response = [];
            $response['message'] = '';
            $flag = 0;

            if(\Yii::$app->user->isGuest){
                $response['result'] = 'login_error';
                $response['redirect_url'] = Url::toRoute(['site/login']);
                return $response;
            }

            if(!isset($_POST['question_set']) && !isset($_POST['share_facebook_report'])){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }

            if($flag == 1){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }else{
                
                $final_question_list = array();
                $item_num = 1;
                $exam_set = Questionset::find()->where(['question_set_id'=>$_POST['question_set']])->one();
                $exam_id = \Yii::$app->user->identity->id.'_'.time();

                $point_to_be_deducted = Rest::get_number_of_point_to_be_deducted_model_test($exam_set->sub_category_id);
                $check_point = Rest::check_available_point($point_to_be_deducted);

                if(!$check_point){
                    $response['result'] = 'error';
                    $response['message'] = 'You don\'t have sufficient points.';
                    return $response;
                }

                $questions = $exam_set->questions;
             

                foreach ($questions as $question) {
                    $tempQuestionModel = new Tempquestionlist();
                    $tempQuestionModel->chapter_id = 0;
                    $tempQuestionModel->user_id = \Yii::$app->user->identity->id;
                    $tempQuestionModel->question_id = $question->question_id;
                    $tempQuestionModel->answer_id = $question->correct_answer->id;
                    $tempQuestionModel->is_correct = 0;
                    $tempQuestionModel->mark_for_review = 0;
                    $tempQuestionModel->serial = $item_num;
                    $tempQuestionModel->exam_id = $exam_id;

                    $tempQuestionModel->save();
                    $item_num++;
                }
                    
                $time_limit = $exam_set->exam_time;

                $Userexamrel_model = new Userexamrel();
                $Userexamrel_model->user_id = \Yii::$app->user->identity->id;
                $Userexamrel_model->exam_id = $exam_id;
                $Userexamrel_model->question_set_id = $exam_set->question_set_id;
                $Userexamrel_model->number_of_question = count($questions);
                $Userexamrel_model->exam_time = (string)$time_limit;
                $Userexamrel_model->created_at = date('Y-m-d H:i:s');
                $Userexamrel_model->time_spent = 0;
                $Userexamrel_model->assign_by = \Yii::$app->user->identity->id;

                if($Userexamrel_model->save()){
                    $deduct = Rest::deduct_point($point_to_be_deducted, $exam_id);
                }

                $session->set('current_exam_id',$exam_id);
                $hours = intval($time_limit / 60);  // integer division
                $mins = $time_limit % 60;

                $session->set('current_exam_time.hours',$hours);
                $session->set('current_exam_time.mins',$mins);
                $session->set('current_exam_time.secs','00');

                $total_time = $hours.':'.$mins.':00';
                $total_time_timestamp = strtotime($total_time);
                $session->set('total_time_timestamp',$total_time_timestamp);

                $session->set('current_exam_start_time',time());
                $session->set('share_facebook_report', $_POST['share_facebook_report']);

                $session->remove('chapter_list');
                $session->remove('current_question_id');

                $response['result'] = 'success';
                $response['redirect_url'] = Url::toRoute(['exam/view','exam_id'=>$exam_id]);
                return $response;

            }
        }
    }

    public function actionStart_exam_check_previous_year_test(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            $response = [];
            $response['message'] = '';
            $flag = 0;

            if(\Yii::$app->user->isGuest){
                $response['result'] = 'login_error';
                $response['redirect_url'] = Url::toRoute(['site/login']);
                return $response;
            }

            if(!isset($_POST['chapter']) && !isset($_POST['share_facebook_report'])){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }

            if($flag == 1){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }else{
                
                $final_question_list = array();
                $item_num = 1;
                $exam_set = Question::find()->where(['chapter_id'=>$_POST['chapter']])->all();
                $exam_id = \Yii::$app->user->identity->id.'_'.time();

                if(empty($exam_set)){
                    $response['result'] = 'error';
                    $response['message'] = 'Sorry no quetions in this exam.';
                    return $response;
                }

                $point_to_be_deducted = Rest::get_number_of_point_to_be_deducted_model_test($exam_set[0]->sub_category_id);
                $check_point = Rest::check_available_point($point_to_be_deducted);

                if(!$check_point){
                    $response['result'] = 'error';
                    $response['message'] = 'You don\'t have sufficient points.';
                    return $response;
                }

                $questions = $exam_set;

                foreach ($questions as $question) {
                    $tempQuestionModel = new Tempquestionlist();
                    $tempQuestionModel->chapter_id = $question->chapter_id;
                    $tempQuestionModel->user_id = \Yii::$app->user->identity->id;
                    $tempQuestionModel->question_id = $question->id;
                    $tempQuestionModel->answer_id = $question->correct_answer->id;
                    $tempQuestionModel->is_correct = 0;
                    $tempQuestionModel->mark_for_review = 0;
                    $tempQuestionModel->serial = $item_num;
                    $tempQuestionModel->exam_id = $exam_id;

                    $tempQuestionModel->save();
                    $item_num++;
                }
                
                $chapter_data = Chapter::find()->where(['id'=>$_POST['chapter']])->one();
                $time_limit = $chapter_data->subject->exam_time;

            
                $Userexamrel_model = new Userexamrel();
                $Userexamrel_model->user_id = \Yii::$app->user->identity->id;
                $Userexamrel_model->exam_id = $exam_id;
                $Userexamrel_model->question_set_id = '1';
                $Userexamrel_model->number_of_question = count($questions);
                $Userexamrel_model->exam_time = (string)$time_limit;
                $Userexamrel_model->created_at = date('Y-m-d H:i:s');
                $Userexamrel_model->time_spent = 0;
                $Userexamrel_model->assign_by = \Yii::$app->user->identity->id;
                $Userexamrel_model->subject_course = $chapter_data->sub_category_id;

                if($Userexamrel_model->save()){
                    $deduct = Rest::deduct_point($point_to_be_deducted, $exam_id);
                }else{
                    var_dump($Userexamrel_model->getErrors());
                    exit();
                }

                $session->set('current_exam_id',$exam_id);
                $hours = intval($time_limit / 60);  // integer division
                $mins = $time_limit % 60;

                $session->set('current_exam_time.hours',$hours);
                $session->set('current_exam_time.mins',$mins);
                $session->set('current_exam_time.secs','00');

                $total_time = $hours.':'.$mins.':00';
                $total_time_timestamp = strtotime($total_time);
                $session->set('total_time_timestamp',$total_time_timestamp);

                $session->set('current_exam_start_time',time());
                $session->set('share_facebook_report', $_POST['share_facebook_report']);

                $session->remove('chapter_list');
                $session->remove('current_question_id');

                $response['result'] = 'success';
                $response['redirect_url'] = Url::toRoute(['exam/view','exam_id'=>$exam_id]);
                return $response;

            }
        }
    }


    public function actionStart_exam_check_re_exam(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            $response = [];
            $response['message'] = '';
            $flag = 0;



            if(\Yii::$app->user->isGuest){
                $response['result'] = 'login_error';
                $response['redirect_url'] = Url::toRoute(['site/login']);
                return $response;
            }

            if($_POST['exam_id'] == '' && $_POST['share_facebook_report'] == ''){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }
            
            if($flag == 1){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }else{
                Rest::get_number_of_point_to_be_deducted_re_exam($_POST['exam_id']);
                
                $final_question_list = array();
                $item_num = 1;
                $exam_data = Userexamrel::find()->where(['exam_id'=>$_POST['exam_id']])->one();
                
                if(empty($exam_data) || ($exam_data->user_id != \Yii::$app->user->identity->id)){
                    $response['result'] = 'error';
                    $response['message'] = 'Invalid request';
                    return $response;
                }

                $point_to_be_deducted = Rest::get_number_of_point_to_be_deducted_re_exam($_POST['exam_id']);
                $check_point = Rest::check_available_point($point_to_be_deducted);
                if(!$check_point){
                    $response['result'] = 'error';
                    $response['message'] = 'You don\'t have sufficient points.';
                    return $response;
                }

                $exam_id = \Yii::$app->user->identity->id.'_'.time();

                $questions = \yii\helpers\Json::decode($exam_data->exam_questions);

                foreach ($questions as $question) {
                    $tempQuestionModel = new Tempquestionlist();
                    $tempQuestionModel->chapter_id = $question['chapter_id'];
                    $tempQuestionModel->user_id = \Yii::$app->user->identity->id;
                    $tempQuestionModel->question_id = $question['question_id'];
                    $tempQuestionModel->answer_id = $question['answer_id'];
                    $tempQuestionModel->is_correct = 0;
                    $tempQuestionModel->mark_for_review = 0;
                    $tempQuestionModel->serial = $item_num;
                    $tempQuestionModel->exam_id = $exam_id;

                    $tempQuestionModel->save();
                    $item_num++;
                }
                    
                $time_limit = $exam_data->exam_time;

                $Userexamrel_model = new Userexamrel();
                $Userexamrel_model->user_id = \Yii::$app->user->identity->id;
                $Userexamrel_model->exam_id = $exam_id;
                $Userexamrel_model->question_set_id = $exam_data->question_set_id;
                $Userexamrel_model->number_of_question = $exam_data->number_of_question;
                $Userexamrel_model->exam_time = (string)$time_limit;
                $Userexamrel_model->created_at = date('Y-m-d H:i:s');
                $Userexamrel_model->time_spent = 0;
                $Userexamrel_model->assign_by = \Yii::$app->user->identity->id;
                $Userexamrel_model->no_of_time = $exam_data->no_of_time+1;
                if($exam_data->parent == ''){
                    $Userexamrel_model->parent = $exam_data->exam_id;
                }else{
                    $Userexamrel_model->parent = $exam_data->parent;
                }

                if($Userexamrel_model->save()){

                    $deduct = Rest::deduct_point($point_to_be_deducted, $exam_id);

                }

                $session->set('current_exam_id',$exam_id);
                $hours = intval($time_limit / 60);  // integer division
                $mins = $time_limit % 60;

                $session->set('current_exam_time.hours',$hours);
                $session->set('current_exam_time.mins',$mins);
                $session->set('current_exam_time.secs','00');

                $total_time = $hours.':'.$mins.':00';
                $total_time_timestamp = strtotime($total_time);
                $session->set('total_time_timestamp',$total_time_timestamp);

                $session->set('current_exam_start_time',time());
                $session->remove('chapter_list');
                $session->remove('current_question_id');
                $session->set('share_facebook_report', $_POST['share_facebook_report']);

                $response['result'] = 'success';
                $response['redirect_url'] = Url::toRoute(['exam/view','exam_id'=>$exam_id]);
                return $response;

            }
        }
    }


    public function actionStart_exam_check_assigned_exam(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            $response = [];
            $response['message'] = '';
            $flag = 0;

            if(\Yii::$app->user->isGuest){
                $response['result'] = 'login_error';
                $response['redirect_url'] = Url::toRoute(['site/login']);
                return $response;
            }

            if(!isset($_POST['exam_id']) || !isset($POST['share_facebook_report'])){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }
            
            if($flag == 1){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }else{
                
                $final_question_list = array();
                $item_num = 1;
                $exam_data = Userexamrel::find()->where(['exam_id'=>$_POST['exam_id']])->one();
                $exam_id = \Yii::$app->user->identity->id.'_'.time();

                $point_to_be_deducted = Rest::get_number_of_point_to_be_deducted_re_exam($_POST['exam_id']);
                $check_point = Rest::check_available_point($point_to_be_deducted);
                if(!$check_point){
                    $response['result'] = 'error';
                    $response['message'] = 'You don\'t have sufficient points.';
                    return $response;
                }

                $questions = \yii\helpers\Json::decode($exam_data->exam_questions);

                foreach ($questions as $question) {
                    $tempQuestionModel = new Tempquestionlist();
                    $tempQuestionModel->chapter_id = $question['chapter_id'];
                    $tempQuestionModel->user_id = \Yii::$app->user->identity->id;
                    $tempQuestionModel->question_id = $question['question_id'];
                    $tempQuestionModel->answer_id = $question['answer_id'];
                    $tempQuestionModel->is_correct = 0;
                    $tempQuestionModel->mark_for_review = 0;
                    $tempQuestionModel->serial = $item_num;
                    $tempQuestionModel->exam_id = $exam_id;

                    $tempQuestionModel->save();
                    $item_num++;
                }
                    
                $time_limit = $exam_data->exam_time;

                $assignment_data = AssignExam::find()->where(['assign_to'=>\Yii::$app->user->identity->id, 'exam_id'=>$_POST['exam_id']])->one();

                $Userexamrel_model = new Userexamrel();
                $Userexamrel_model->user_id = \Yii::$app->user->identity->id;
                $Userexamrel_model->exam_id = $exam_id;
                $Userexamrel_model->question_set_id = $exam_data->question_set_id;
                $Userexamrel_model->number_of_question = $exam_data->number_of_question;
                $Userexamrel_model->exam_time = (string)$time_limit;
                $Userexamrel_model->created_at = date('Y-m-d H:i:s');
                $Userexamrel_model->time_spent = 0;
                $Userexamrel_model->assign_by = $assignment_data->assign_by;

                if($Userexamrel_model->save()){
                    
                    $assignment_data->exam_id_of_attend = $exam_id;
                    $assignment_data->save();

                    $deduct = Rest::deduct_point($point_to_be_deducted, $exam_id);

                }
                $session->set('current_exam_id',$exam_id);
                $hours = intval($time_limit / 60);  // integer division
                $mins = $time_limit % 60;

                $session->set('current_exam_time.hours',$hours);
                $session->set('current_exam_time.mins',$mins);
                $session->set('current_exam_time.secs','00');

                $total_time = $hours.':'.$mins.':00';
                $total_time_timestamp = strtotime($total_time);
                $session->set('total_time_timestamp',$total_time_timestamp);

                $session->set('current_exam_start_time',time());
                $session->remove('chapter_list');
                $session->remove('current_question_id');
                $session->set('share_facebook_report', $_POST['share_facebook_report']);

                $response['result'] = 'success';
                $response['redirect_url'] = Url::toRoute(['exam/view','exam_id'=>$exam_id]);
                return $response;

            }
        }
    }


    public function actionStart_exam_check_assigned_exam_admin(){
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            $response = [];
            $response['message'] = '';
            $flag = 0;

            if(\Yii::$app->user->isGuest){
                $response['result'] = 'login_error';
                $response['redirect_url'] = Url::toRoute(['site/login']);
                return $response;
            }

            if(!isset($_POST['exam_id'])){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }
            
            if($flag == 1){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }else{
                
                $final_question_list = array();
                $item_num = 1;
                $exam_set = Questionset::find()->where(['question_set_id'=>$_POST['exam_id']])->one();
                //$exam_data = Userexamrel::find()->where(['exam_id'=>$_POST['exam_id']])->one();
                $exam_id = \Yii::$app->user->identity->id.'_'.time();

                $point_to_be_deducted = Rest::get_number_of_point_to_be_deducted_model_test($exam_set->sub_category_id);
                $check_point = Rest::check_available_point($point_to_be_deducted);
                if(!$check_point){
                    $response['result'] = 'error';
                    $response['message'] = 'You don\'t have sufficient points.';
                    return $response;
                }

                $questions = $exam_set->questions;

                foreach ($questions as $question) {
                    $tempQuestionModel = new Tempquestionlist();
                    $tempQuestionModel->chapter_id = 0;
                    $tempQuestionModel->user_id = \Yii::$app->user->identity->id;
                    $tempQuestionModel->question_id = $question->question_id;
                    $tempQuestionModel->answer_id = $question->correct_answer->id;
                    $tempQuestionModel->is_correct = 0;
                    $tempQuestionModel->mark_for_review = 0;
                    $tempQuestionModel->serial = $item_num;
                    $tempQuestionModel->exam_id = $exam_id;

                    $tempQuestionModel->save();
                    $item_num++;
                }
                    
                $time_limit = $exam_set->exam_time;

                $assignment_data = AssignExam::find()->where(['assign_to'=>\Yii::$app->user->identity->id, 'question_set_id'=>$_POST['exam_id']])->one();

                $Userexamrel_model = new Userexamrel();
                $Userexamrel_model->user_id = \Yii::$app->user->identity->id;
                $Userexamrel_model->exam_id = $exam_id;
                $Userexamrel_model->question_set_id = $exam_set->question_set_id;
                $Userexamrel_model->number_of_question = count($questions);
                $Userexamrel_model->exam_time = (string)$time_limit;
                $Userexamrel_model->created_at = date('Y-m-d H:i:s');
                $Userexamrel_model->time_spent = 0;
                $Userexamrel_model->assign_by = $assignment_data->assign_by;

                if($Userexamrel_model->save()){
                    
                    $assignment_data->exam_id_of_attend = $exam_id;
                    $assignment_data->save();

                    $deduct = Rest::deduct_point($point_to_be_deducted, $exam_id);

                }
                $session->set('current_exam_id',$exam_id);
                $hours = intval($time_limit / 60);  // integer division
                $mins = $time_limit % 60;

                $session->set('current_exam_time.hours',$hours);
                $session->set('current_exam_time.mins',$mins);
                $session->set('current_exam_time.secs','00');

                $total_time = $hours.':'.$mins.':00';
                $total_time_timestamp = strtotime($total_time);
                $session->set('total_time_timestamp',$total_time_timestamp);

                $session->set('current_exam_start_time',time());
                $session->remove('chapter_list');
                $session->remove('current_question_id');

                $response['result'] = 'success';
                $response['redirect_url'] = Url::toRoute(['exam/view','exam_id'=>$exam_id]);
                return $response;

            }
        }
    }

    public function actionAdd_remove_item(){
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $session = Yii::$app->session;
            $response = [];
            
            if(!isset($_POST['flag']) || !isset($_POST['id']) || ($_POST['flag']!='checked' && $_POST['flag'] != 'unchecked')){
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }

            $chapter_id = $_POST['id'];
            $data = Chapter::find()->where(['id'=>$chapter_id])->one();

            if(!empty($data)){
                
                if($session->has('chapter_list')){
                    $chapter_list_session = $session->get('chapter_list');
                }else{
                    $chapter_list_session = array();
                }

                if($_POST['flag'] === 'checked'){
                    if(!in_array( $chapter_id , $chapter_list_session )){
                        array_push($chapter_list_session, $chapter_id);
                    }
                }else{
                    if(in_array($chapter_id,$chapter_list_session)){
                        $chapter_list_session = array_merge(array_diff($chapter_list_session,array($chapter_id)));
                    }
                }

                $session->set('chapter_list',$chapter_list_session);

                $response['result'] = 'success';
                $response['message'] = $chapter_list_session;
                $response['item_data'] = $this->renderAjax('selectedItem',['model'=>$data]);
                $response['total_item'] = count($chapter_list_session);
                return $response;
            }
            else{
                $response['result'] = 'error';
                $response['message'] = 'Invalid request';
                return $response;
            }

        }
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

            $exam_data = Userexamrel::find()->where(['exam_id'=>$exam_id,'user_id'=>\Yii::$app->user->identity->id])->one();
            

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



    public function actionAssign_exam(){
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];

            $email = $_POST['email_address'];
            $exam_id = $_POST['exam_id'];

            if($email == \Yii::$app->user->identity->email){
                $response['result'] = 'error';
                $response['msg'] = '<div class="btn btn-warning">You can\'t assign yourself.</div>';
                return $response;
            }

            $check_email = User::find()->where(['email'=>$email])
                                        ->andWhere(['user_type'=>'student'])
                                        ->one();
            if(empty($check_email)){
                $response['result'] = 'error';
                $response['msg'] = '<div class="btn btn-warning">Invalid email.</div>';
            }else{

                $check_exam = Userexamrel::find()->where(['exam_id'=>$exam_id])
                                                 ->andWhere(['user_id' => \Yii::$app->user->identity->id])
                                                 ->one();
                if(empty($check_exam)){
                    $response['result'] = 'error';
                    $response['msg'] = '<div class="btn btn-warning">Invalid exam.</div>';
                }else{
                    $check_exist = AssignExam::find()->where(['assign_to' => $check_email->id, 'exam_id' => $exam_id])
                                                     ->one();

                                       
                    if(empty($check_exist)){
                        $model = new AssignExam();
                        $model->assign_by = \Yii::$app->user->identity->id;
                        $model->assign_to = $check_email->id;
                        $model->assign_item = '';
                        $model->exam_type = '';
                        $model->exam_id = $exam_id;
                        $model->exam_id_of_attend = '';
                        $model->status = 0;

                        if($model->save()){

                            
                            $message = Yii::$app->mailer->compose();

                            $mail_data = $this->renderPartial('_assignment_mail_template',[
                                    'assign_to_data' => $check_email
                                ]);
                            
                            $message->SetFrom(["modeltest.abedon@gmail.com"=>"admin@model-test.com"]);
                            $message->setTo($email);
                            $message->setSubject("Exam assigned");
                            $message->setHtmlBody($mail_data);
                            $message->send();

                            $response['result'] = 'success';
                            $response['msg'] = '<div class="btn btn-success">Exam successfully assigned.</div>';
                            $response['assignment_data'] = $this->renderAjax('_assigned_item',['email'=>$email]);
                        }else{
                            $response['result'] = 'error';
                            $response['msg'] = '<div class="btn btn-warning">Sorry unable to assign this student.</div>';
                        }
                    }else{
                        $response['result'] = 'error';
                        $response['msg'] = '<div class="btn btn-warning">This user is already assigned to this exam.</div>';
                    }
                    
                }
            }

            return $response;
        }
    }



    public function actionSave_fb_share_point(){
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];

            $exam_id = $_POST['exam_id'];

            if(!isset(Yii::$app->user->identity->id)){
                $response['result'] = 'error';
                $response['msg'] = '<div class="btn btn-warning">Please login.</div>';
                return $response;
            }

            $add_point = Rest::add_point('shareexamreport');
            
            if($add_point){
                $response['result'] = 'success';
                $response['msg'] = '<div class="btn btn-success">Your bonus point successfully added.</div>';
            }else{
                $response['result'] = 'success';
                $response['msg'] = '<div class="btn btn-warning">Error in adding bonus point.</div>';
            }

            return $response;
        }
    }





    
}
