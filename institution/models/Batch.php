<?php

namespace institution\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use institution\models\Courses;
use institution\models\Students;

/**
 * This is the model class for table "batch".
 *
 * @property integer $id
 * @property string $batch_no
 * @property integer $course_id
 * @property string $course_start
 * @property string $course_end
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $status
 */
class Batch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $student_amount;


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
        return 'batch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['batch_no', 'course_id', 'course_start', 'course_end', 'status'], 'required'],
            [['course_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['course_start', 'course_end', 'created_at', 'created_by', 'updated_at', 'updated_by','student_amount'], 'safe'],
            [['batch_no'], 'string', 'max' => 100],
            [['batch_no', 'course_id'], 'unique', 'targetAttribute' => ['batch_no', 'course_id'],'message' => 'Already taken' ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_no' => 'Batch No',
            'course_id' => 'Course Name',
            'course_start' => 'Course Start',
            'course_end' => 'Course End',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
            'student_amount' => 'Student Amount'
        ];
    }

    public static function getCoursename($id){       
        $course_data = Courses::find()->where(['id' => $id ])->one();
        return $course_data->course_name;
    }

    public static function getNumberofstudent($id){       
        $number_of_student = Students::find()
            ->where(['batch_no' => $id ])
            ->count();
        
        if(!empty($number_of_student)){
            return $number_of_student;
        }else{
            return '0';
        }
        
    }

    public static function get_all_batch_list() {
        $options = [];
        $batch_q = self::find()->where(['status' => '1'])->all();
        
        if(!empty($batch_q)){
            foreach ($batch_q as $key => $value) {
                $options[$value->id] = $value->batch_no;

            }
        }        

        return $options;
    }

    public function getCourse(){
        return $this->hasOne(Courses::className(), ['id' => 'course_id']);
    }

    public static function get_all_batch_list_for_sort() {
        $options = [];
        $batch_q = self::find()->where(['status' => '1'])->all();
        
        if(!empty($batch_q)){
            foreach ($batch_q as $key => $value) {
                $course = $value->course->course_name;
                $options[$value->id] = $value->batch_no.'-'.$course;

            }
        }        

        return $options;
    }

}
