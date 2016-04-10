<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\models\Subject;
use frontend\models\questionsetitems;
use frontend\models\Category;

/**
 * This is the model class for table "questionset".
 *
 * @property integer $id
 * @property string $question_set_id
 * @property string $question_set_name
 * @property string $exam_time
 * @property integer $point_to_be_deducted
 * @property integer $bonus_point
 * @property string $pasue
 * @property integer $deduct_on_pause
 * @property integer $country_id
 * @property integer $category_id
 * @property integer $sub_category_id
 * @property integer $subject_id
 * @property integer $status
 */
class Questionset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionset';
    }

    public $subject;
    public $no_of_question;
    public $type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_set_id', 'question_set_name', 'exam_time', 'pasue', 'deduct_on_pause', 'country_id', 'category_id', 'sub_category_id', 'subject_id', 'status'], 'required'],
            [['deduct_on_pause', 'country_id', 'category_id', 'sub_category_id', 'status'], 'integer'],
            [['question_set_id', 'question_set_name', 'exam_time', 'pasue', 'type'], 'string', 'max' => 255],
            [['subject_with_q_no', 'subject', 'no_of_question'], 'safe']
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_set_id' => 'Question Set ID',
            'question_set_name' => 'Question Set Name',
            'exam_time' => 'Exam Time',
            'pasue' => 'Pasue',
            'deduct_on_pause' => 'Deduct On Pause',
            'country_id' => 'Country Name',
            'category_id' => 'Category Name',
            'sub_category_id' => 'Sub Category Name',
            'subject_id' => 'Subject Name',
            'status' => 'Status',
            'subject' =>'Subject',
            'no_of_question' => 'No of question'
        ];
    }

    public static function getSubjectSortList($data){
        
        if(!empty($data)){
            return ArrayHelper::map(Subject::find()->where(['id'=>$data])->asArray()->all(), 'id', 'subject_name');
        }else{
            return ArrayHelper::map(Subject::find()->asArray()->all(), 'id', 'subject_name');
        }
    }

    public function getQuestions(){
        return $this->hasMany(questionsetitems::className(), ['question_set_id' => 'question_set_id']);
    }

    public function getSubcat_name(){
        return $this->hasOne(Category::className(), ['id' => 'sub_category_id']);
    }

    public function getCat_name(){
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
