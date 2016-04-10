<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class Rest extends Model
{
    
    public static function getNextQuestion($exam_id, $data, $type){

        $new_question = Tempquestionlist::find()
                            ->where(['exam_id'=>$exam_id])
                            ->andWhere(['>','serial',$data->serial])
                            ->andWhere(['mark_for_review'=>'0'])
                            ->andWhere(['is_correct'=>'0'])
                            ->orderBy('serial asc')
                            ->one();
        
        
        if(empty($new_question)){
            $new_question = Tempquestionlist::find()
                            ->where(['exam_id'=>$exam_id])
                            ->andWhere(['mark_for_review'=>0])
                            ->andWhere(['is_correct'=>'0'])
                            ->orderBy('serial asc')
                            ->one();
            if(empty($new_question)){
                $new_question = Tempquestionlist::find()
                            ->where(['exam_id'=>$exam_id])
                            ->andWhere(['mark_for_review'=>'1'])
                            ->orderBy('serial asc')
                            ->one();
            }
        }

        return $new_question;
    }

    public static function getPrevQuestion($exam_id, $data, $type){

        $new_question = Tempquestionlist::find()
                            ->where(['exam_id'=>$exam_id])
                            ->andWhere(['<','serial',$data->serial])
                            ->andWhere(['mark_for_review'=>'0'])
                            ->andWhere(['is_correct'=>'0'])
                            ->orderBy('serial desc')
                            ->one();
        
        
        if(empty($new_question)){
            $new_question = Tempquestionlist::find()
                            ->where(['exam_id'=>$exam_id])
                            ->andWhere(['mark_for_review'=>0])
                            ->andWhere(['is_correct'=>'0'])
                            ->orderBy('serial desc')
                            ->one();
            if(empty($new_question)){
                $new_question = Tempquestionlist::find()
                            ->where(['exam_id'=>$exam_id])
                            ->andWhere(['mark_for_review'=>'1'])
                            ->orderBy('serial desc')
                            ->one();
            }
        }

        return $new_question;
    }


    public static function updateSession(){
        $session = Yii::$app->session;
        $start_time = $session->get('current_exam_start_time');

        $time_now = time();
        $elapsed_time = $time_now-$start_time;

        $total_time_timestamp = $session->get('total_time_timestamp');
        $new_time = $total_time_timestamp - $elapsed_time;

        $session->set('current_exam_time.hours',date('H',$new_time));
        $session->set('current_exam_time.mins',date('i',$new_time));
        $session->set('current_exam_time.secs',date('s',$new_time));

        return $new_time;
    }



    public static function get_number_of_seconds_from_time($time){
        $hour = date('H',$time);
        $min = date('i',$time);
        $sec = date('s',$time);
        $time_seconds = $hour * 3600 + $min * 60 + $sec;

        return $time_seconds;
    }


    public static function save_purchased_package($user_id, $package_name, $points, $expire_date){
        $model = new PurchasedPackage();
        $model->user_id = $user_id;
        $model->package_name = $package_name;
        $model->points = $points;
        $model->expired_date = $expire_date;

        $model->save();

        return $model->id;
    }

    public static function save_transaction_history($user_id,$point,$action,$type,$exam_id='', $purchased_package_id = 0){
        $prev_data = TransactionHistroy::find()->where(['user_id'=>$user_id])
                                                ->andWhere(['purchased_package_id' => $purchased_package_id])
                                                ->orderBy('id desc')
                                                ->limit(1)
                                                ->all();
        
        if(empty($prev_data)){
            $opening = 0;
        }else{
            $opening = $prev_data[0]->closing;
        }

        $model = new TransactionHistroy();
        $model->user_id = $user_id;
        $model->opening = $opening;
        $model->points = $point;
        $model->action = $action;
        $model->purchased_package_id = $purchased_package_id;

        if($action == '-'){
            $model->closing = $opening - $point;
        }else{
            $model->closing = $opening + $point;
        }

        $model->type = $type;
        $model->exam_id = $exam_id;

        if($model->save()){
            return true;
        }else{
            return false;
        }

    }


    public static function check_available_point($point){
        $user_id = Yii::$app->user->identity->id;

        $user_data = User::find()->where(['id'=>$user_id])->one();
        $packages_point = PurchasedPackage::find()->select('sum(points) as points')
                                                    ->where(['user_id'=>$user_id])
                                                    ->one(); 
        $total_point = $user_data->free_point+$packages_point->points;

        if($total_point >= $point){
            return true;
        }
        else{
            return false;
        }
    }


    public static function get_number_of_point_to_be_deducted($chapterlist){
        $point = 0;

        if(!empty($chapterlist)){
            foreach ($chapterlist as $key => $value) {
                $chapter = Chapter::find()->where(['id'=>$value])->one();

                $sub_cat = $chapter->subcategory->category_name;
                if($sub_cat == 'Class IX - X' || $sub_cat == 'Class XI - XII' || $sub_cat == 'Class VIII'){
                    $point = Yii::$app->params['Class_VIII_XII_Practice'];
                }else{
                    $point = Yii::$app->params['others_Practice'];
                }
            }
        }

        return $point;
    }

    public static function get_number_of_point_to_be_deducted_model_test($sub_cat){
        $point = 0;

        if(!empty($sub_cat)){
            
                $sub_cat = Category::find()->where(['id'=>$sub_cat])->one();

                if($sub_cat->category_name == 'Class IX - X' || $sub_cat->category_name == 'Class XI - XII' || $sub_cat->category_name == 'Class VIII'){
                    $point = Yii::$app->params['Class_VIII_XII_ModelTest'];
                }else{
                    $point = Yii::$app->params['others_ModelTest'];
                }
        }

        return $point;
    }


    public static function get_chapter_list_from_exam_data($data){
        $questions = \yii\helpers\Json::decode($data->exam_questions);

        $chapterlist = array();

        foreach ($questions as $key) {
            if (!in_array($key['chapter_id'], $chapterlist)) {
                array_push($chapterlist, $key['chapter_id']);
            }
        }

        return $chapterlist;

    }

    public static function getExamType($data){
        $type = '';
        if($data->question_set_id == '0'){
            $type = 'Test';
        }elseif($data->question_set_id == '1'){
            $type = 'Previous_year';
        }else{
            $type = 'Model_test';
        }

        return $type;
    }


    public static function get_number_of_point_to_be_deducted_re_exam($exam_id){
        $point = 0;

        $exam_data = Userexamrel::find()->where(['exam_id'=>$exam_id])->one();
        $exam_type = Rest::getExamType($exam_data);
        if($exam_type == 'Model_test'){
            $question_set = Questionset::find()->where(['question_set_id'=>$exam_data->question_set_id])->one();
            $point = Rest::get_number_of_point_to_be_deducted_model_test($question_set->sub_category_id);
        }
        elseif($exam_type == 'Previous_year'){
            $chapterlist = Rest::get_chapter_list_from_exam_data($exam_data);
            $sub_cat = Chapter::find()->where(['id'=>$chapterlist[0]])->one();

            $point = Rest::get_number_of_point_to_be_deducted_model_test($sub_cat->sub_category_id);
        }
        else{
            $chapterlist = Rest::get_chapter_list_from_exam_data($exam_data);
            $point = Rest::get_number_of_point_to_be_deducted($chapterlist);
        }

        return $point;
    }


    public static function deduct_point($point, $exam_id){
        $user_id = Yii::$app->user->identity->id;
        $user_data = User::find()->where(['id'=>$user_id])->one();

        $packages = PurchasedPackage::find()->where(['user_id'=>$user_id])
                                            ->andWhere(['>=', 'expired_date', date('Y-m-d')])
                                            ->andWhere(['!=', 'points', 0])
                                            ->orderBy('expired_date asc')
                                            ->all();
        $updated_array = array();
        $temp_point = 0;
        if(!empty($packages)){

            foreach ($packages as $key => $value) {

                if($value->points >= $point){

                    $value->points = $value->points - $point;
                    $temp_point = $point;
                    $point = 0;
                }
                else{
                    $temp_point = $value->points;
                    $point = $point - $value->points;
                    $value->points = 0;
                }

                $value->save();
                Rest::save_transaction_history($user_id, $temp_point, '-', 'exam', $exam_id, $value->id);

                if($point == 0){
                    break;
                }
            }

            if($point != 0){
                $user_data->free_point = $user_data->free_point - $point;
                $temp_point = $point;
                $point = 0;

                $user_data->save();
                Rest::save_transaction_history($user_id, $temp_point, '-', 'exam', $exam_id);
            }

        }else{
            $user_data->free_point = $user_data->free_point - $point;
            $temp_point = $point;
            $point = 0;

            $user_data->save();
            Rest::save_transaction_history($user_id, $temp_point, '-', 'exam', $exam_id);
        }

        
        Rest::add_point('takepartofexam');

        return true;
    }


    public static function add_point($type){
        $point = Rest::get_point_from_point_table($type);

        $user_id = Yii::$app->user->identity->id;
        $user_data = User::find()->where(['id'=>$user_id])->one();
        $user_data->free_point = $user_data->free_point + $point;
        $user_data->save();

        Rest::save_transaction_history($user_id, $point, '+', $type, '');

        return true;
    }



    public static function get_point_from_point_table($type){
        $data = PointTable::find()->where(['identifier'=>$type])->one();

        if(!empty($data)){
            return $data->points;
        }else{
            return 0;
        }
    }




    public static function get_mark($exam_id){
        $exam_data = Userexamrel::find()
            ->where(['exam_id'=> $exam_id])
            ->one();

        $Percentage = 0;

        if(empty($exam_data)){
            $question_list = '';            
        }else{
            $question_list = \yii\helpers\Json::decode($exam_data->exam_questions);
        }

        if(count($question_list) > 0 && !empty($question_list)){
            $total_question = count($question_list);

            $correct = 0;                                           
            $Percentage = 0;
            $answered = 0;

            foreach ($question_list as $question) {
                if($question['is_correct'] != 0 && $question['mark_for_review'] == 0){
                    $answered++;

                    if($question['is_correct'] == $question['answer_id']){
                        $correct++;
                        $Percentage = round(($correct*100)/$total_question,2);
            
                    }else{
                        $incorrect = 0;
                    }
                }
                
            }
        }

        return $Percentage;

    }

    public static function get_mark_without_percentage($exam_id){
        $exam_data = Userexamrel::find()
            ->where(['exam_id'=> $exam_id])
            ->one();

        $Percentage = 0;

        if(empty($exam_data)){
            $question_list = '';            
        }else{
            $question_list = \yii\helpers\Json::decode($exam_data->exam_questions);
        }

        $answered = 0;
        $correct = 0;
        $incorrect = 0;
        $score = 0;
        if(count($question_list) > 0 && !empty($question_list)){
            

            foreach ($question_list as $question) {
                if($question['is_correct'] != 0 && $question['mark_for_review'] == 0){
                    $answered++;

                    if($question['is_correct'] == $question['answer_id']){
                        $correct++;
                        $score = $score+2;
                        //echo $question['is_correct'].'.....'.$question['answer_id'].'<br/>';
                    }else{
                        $incorrect++;
                        $score = $score-1;
                    }
                }
                
            }


        }

        return $score;

    }


    public static function get_previous_score($exam_id){
        $score = 0;
        $prev_data = '';
        $exam_data = Userexamrel::find()
            ->where(['exam_id'=> $exam_id])
            ->one();

        if($exam_data->no_of_time > 2){
            $prev_data = Userexamrel::find()
                                ->where(['parent'=> $exam_data->parent])
                                ->andWhere(['!=','exam_id',$exam_id])
                                ->orderBy('no_of_time desc')
                                ->one();

        }elseif($exam_data->no_of_time == 2){
            $prev_data = Userexamrel::find()
                                ->andWhere(['exam_id' => $exam_data->parent])
                                ->orderBy('no_of_time desc')
                                ->one();
        }

        if(!empty($prev_data)){
            $score = Rest::get_mark_without_percentage($prev_data->exam_id);
        }

        return $score;

    }





}
