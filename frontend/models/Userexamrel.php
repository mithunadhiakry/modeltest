<?php

namespace frontend\models;

use Yii;
use frontend\models\Tempquestionlist;
use frontend\models\User;

/**
 * This is the model class for table "userexamrel".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $exam_id
 * @property integer $assign_by
 * @property string $subject_course
 * @property integer $number_of_course
 * @property string $exam_time
 * @property string $createed_at
 */
class Userexamrel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userexamrel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'exam_id', 'number_of_question', 'exam_time', 'created_at', 'question_set_id'], 'required'],
            [['user_id', 'assign_by', 'number_of_question', 'no_of_time'], 'integer'],
            [['exam_id', 'exam_questions'], 'string'],
            [['subject_course','created_at','no_of_time','parent'], 'safe'],
            [['exam_time', 'question_set_id', 'parent'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'exam_id' => 'Exam ID',
            'assign_by' => 'Assign By',
            'subject_course' => 'Subject Course',
            'number_of_question' => 'Number Of Course',
            'exam_time' => 'Exam Time',
            'created_at' => 'Createed At',
            'time_spent' => 'Time Spent',
            'question_set_id' => 'Question set',
            'no_of_time' => 'No of Time',
            'parent' => 'Parent'
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getQuestionset(){
        return $this->hasOne(Questionset::className(), ['question_set_id' => 'question_set_id']);
    }

    public function getAssignbyUser(){
        return $this->hasOne(User::className(), ['id' => 'assign_by']);
    }

    public static function getrecent_testtaker(){

        $get_all_data = Userexamrel::find()
                                ->limit(3)
                                 ->orderBy([
                                    'id' => SORT_DESC,
                                ])
                                ->all();


        return $get_all_data;
    }

    public static function getmy_model_test($user_id,$limit){
            
        $get_all_data = Userexamrel::find()
                        ->where(['user_id' => $user_id])
                        ->andWhere(['!=','question_set_id','0'])
                        ->andWhere(['!=','question_set_id','1'])
                        ->andWhere(['!=','exam_questions',''])
                        ->limit($limit)
                        ->orderBy('id desc')
                        ->all();
        return $get_all_data;
    }

    public static function getall_model_test($limit){
        $get_all_data = Userexamrel::find()
                        ->where(['!=','question_set_id','0'])
                        ->limit($limit)
                        ->orderBy('id desc')
                        ->all();
        return $get_all_data;
    }
}
