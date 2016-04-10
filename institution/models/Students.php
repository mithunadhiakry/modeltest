<?php

namespace institution\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use institution\models\User;

/**
 * This is the model class for table "students".
 *
 * @property integer $id
 * @property string $student_email
 * @property integer $course_id
 * @property integer $batch_no
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Students extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $course_start;
    public $course_end;

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
        return 'students';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_email', 'course_id', 'batch_no', 'status'], 'required'],
            [['course_id', 'batch_no', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['created_at', 'updated_at','course_start','course_end'], 'safe'],
            [['student_email'], 'string', 'max' => 255],
            [['student_email','batch_no', 'course_id'], 'unique', 'targetAttribute' => ['student_email','batch_no', 'course_id'],'message' => 'Already taken' ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_email' => 'Student Email',
            'course_id' => 'Course Name',
            'batch_no' => 'Batch No',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'course_start' => 'Course Start',
            'course_end' => 'Course End'
        ];
    }

    public static function getStudentemail($id){       
        $user_data = User::find()->where(['id' => $id ])->one();
        return $user_data->email;
    }

    public static function getCoursename($id){       
        $course_data = Courses::find()->where(['id' => $id ])->one();
        return $course_data->course_name;
    }

    public static function getBatchname($id){       
        $course_data = Batch::find()->where(['id' => $id ])->one();
        return $course_data->batch_no;
    }

    public static function getCourseStart($id){       
        $course_data = Batch::find()->where(['id' => $id ])->one();
        return $course_data->course_start;
    }

    public static function getCourseEnd($id){       
        $course_data = Batch::find()->where(['id' => $id ])->one();
        return $course_data->course_end;
    }

    public function getCourse(){
        return $this->hasOne(Courses::className(), ['id' => 'course_id']);
    }

    public function getBatch(){
        return $this->hasOne(Batch::className(), ['id' => 'batch_no']);
    }

    public static function get_all_batch_list_for_sort() {
        $options = [];
        $batch_q = self::find()->where(['status' => '1'])->all();
        
        if(!empty($batch_q)){
            foreach ($batch_q as $key => $value) {
                $course = $value->course->course_name;
                $batch = $value->batch->batch_no;
                $options[$value->id] = $batch.'-'.$course;

            }
        }        

        return $options;
    }
}
