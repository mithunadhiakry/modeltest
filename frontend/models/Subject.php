<?php

namespace frontend\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "subject".
 *
 * @property integer $id
 * @property string $subject_name
 * @property integer $subject_status 
 * @property integer $sort_order
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Subject extends \yii\db\ActiveRecord
{
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

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject_name', 'subject_status','country_id','category_id','sub_category_id'], 'required'],
            [['subject_status', 'sort_order', 'exam_time'], 'integer'],
            [['sub_category_id','created_at', 'updated_at','created_by','updated_by','sort_order'], 'safe'],
            [['subject_name'], 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_name' => 'Subject Name',
            'subject_status' => 'Subject Status',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'country_id' => "Country",
            'category_id' => "Category",
            'sub_category_id' => "Sub Category"
        ];
    }

    public static function get_all_subject_list($id) {

        $subject_q = self::find()->where(['subject_status' => '1','sub_category_id' => $id])->all();
          
        return $subject_q;
    }


    public static function get_all_subject_list_with_group($id) {

        $subject_q = self::find()->where(['subject_status' => '1','sub_category_id' => $id])->groupBy('for_admission_job')->all();
          
        return $subject_q;
    }
   

    public static function get_chaper_data_r($sub_category_id,$for_admission_job) {

        $subject_q = self::find()->where(['subject_status' => '1','sub_category_id' => $sub_category_id,'for_admission_job'=>$for_admission_job])->all();
          
        return $subject_q;
    }
    
}
