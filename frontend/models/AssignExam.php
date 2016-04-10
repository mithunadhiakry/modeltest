<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "assign_exam".
 *
 * @property integer $id
 * @property integer $assign_by
 * @property integer $assign_to
 * @property string $assign_item
 * @property string $exam_type
 * @property string $exam_id
 * @property string $exam_id_of_attend
 * @property integer $status
 * @property string $time
 */
class AssignExam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assign_exam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assign_by', 'assign_to', 'status'], 'required'],
            [['assign_by', 'assign_to', 'status'], 'integer'],
            [['time','question_set_id'], 'safe'],
            [['assign_item', 'exam_type', 'exam_id', 'exam_id_of_attend'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'assign_by' => 'Assign By',
            'assign_to' => 'Assign To',
            'assign_item' => 'Assign Item',
            'exam_type' => 'Exam Type',
            'exam_id' => 'Exam ID',
            'exam_id_of_attend' => 'Exam Id Of Attend',
            'status' => 'Status',
            'time' => 'Time',
        ];
    }

    public function getAssigntoUser(){
        return $this->hasOne(User::className(), ['id' => 'assign_to']);
    }

    public function getAssignbyUser(){
        return $this->hasOne(User::className(), ['id' => 'assign_by']);
    }

    public function getGet_exam(){
        return $this->hasOne(Userexamrel::className(), ['exam_id' => 'exam_id']);
    }
    public function getQuestionset(){
        return $this->hasOne(Questionset::className(), ['question_set_id' => 'question_set_id']);
    }
}
