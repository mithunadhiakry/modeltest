<?php

namespace institution\models;

use Yii;
use yii\helpers\ArrayHelper;
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
            [['question_set_id', 'question_set_name', 'exam_time', 'pasue', 'deduct_on_pause', 'country_id', 'category_id', 'sub_category_id', 'subject_id'], 'required'],
            [['deduct_on_pause', 'country_id', 'category_id', 'sub_category_id', 'status'], 'integer'],
            [['question_set_id', 'question_set_name', 'exam_time', 'pasue', 'type'], 'string', 'max' => 255],
            [['subject_with_q_no', 'subject', 'no_of_question', 'status'], 'safe']
            
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

    public static function get_all_question_list(){

        $logged_id = Yii::$app->user->identity->id;

        $options = [];
        $questionset_q = self::find()->where(['created_by' => $logged_id])->all();
        
        if(!empty($questionset_q)){
            foreach ($questionset_q as $key => $value) {
                $options[$value->question_set_id] = $value->question_set_name;

            }
        }        

        return $options;

    }

    
}
