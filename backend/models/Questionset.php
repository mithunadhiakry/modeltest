<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\Subject;
use app\models\User;

use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                ],
        ];
    }

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
            [['question_set_id', 'question_set_name', 'exam_time', 'pasue', 'deduct_on_pause', 'country_id', 'category_id', 'sub_category_id', 'subject_id', 'status','positive_point','negative_point'], 'required'],
            [['deduct_on_pause', 'country_id', 'category_id', 'sub_category_id', 'status'], 'integer'],
            [['question_set_id', 'question_set_name', 'exam_time', 'pasue', 'type','alternate_name'], 'string', 'max' => 255],
            [['subject_with_q_no', 'subject', 'no_of_question','created_at','created_by','updated_at','updated_by','alternate_name'], 'safe']
            
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
            'no_of_question' => 'No of question',
            'negative_point' => 'Negative Point',
            'positive_point' => 'Positive Point',
            'alternate_name' => 'Alternate Name'
        ];
    }

    public static function getSubjectSortList($data){
        
        if(!empty($data)){
            return ArrayHelper::map(Subject::find()->where(['id'=>$data])->asArray()->all(), 'id', 'subject_name');
        }else{
            return ArrayHelper::map(Subject::find()->asArray()->all(), 'id', 'subject_name');
        }
    }

    public static function getCountryname($id){
        $countty_data = Country::find()->where(['id' => $id ])->one();
        return $countty_data->name;
    }

    public static function getParentcategoryname($id){
        
        $data = Category::find()->where(['id'=>$id])->one();
                
        if(!empty($data->category_name)){
            return $data->category_name;
        }else{
            return '';
        }
    }

     public function getUserdata(){

       
        $user_data = User::find()->where(['id' => $this->created_by])->one();
        return $user_data->name;
       
    }

     public static function getSubjectname($id){
        
       $subject_data_r = \yii\helpers\Json::decode($id);

       $message_data = '';
       $total = 1;

       if(!empty($subject_data_r)){
        foreach($subject_data_r as $subject_data){
                $data = Subject::find()->where(['id'=>$subject_data])->one();
                if(!empty($data->subject_name)){
                    if(count($subject_data_r) == $total){
                        $message_data.=$data->subject_name;
                    }else{
                        $message_data.=$data->subject_name . ' | ';
                    }
                    
                }else{
                    return '';
                }

                $total++;
            }
       }

        return $message_data;
    }
}
