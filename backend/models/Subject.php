<?php

namespace backend\models;

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
            [['sub_category_id','created_at', 'updated_at','created_by','updated_by','sort_order','for_admission_job'], 'safe'],
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
            'sub_category_id' => "Sub Category",
            'exam_time' => 'Exam Time (if previous year)'
        ];
    }

    public static function get_all_subject_list() {
        $options = [];
        $subject_q = self::find()->where(['subject_status' => '1'])->all();
        
        if(!empty($subject_q)){
            foreach ($subject_q as $key => $value) {
                $options[$value->id] = $value->subject_name;

            }
        }        

        return $options;
    }


    


    public function getCountryname($id){      
        $countty_data = Country::find()->where(['id' => $id ])->one();
        return $countty_data->name;
    }

    public function getParentcategoryname($id){
        
        $data = Category::find()->where(['id'=>$id])->one();
                
        if(!empty($data->category_name)){
            return $data->category_name;
        }else{
            return '';
        }
    }

    public static function getSubjectSortList($sub_category_id){
        
        if(!empty($sub_category_id)){
            return ArrayHelper::map(Subject::find()->where(['sub_category_id'=>$sub_category_id])->asArray()->all(), 'id', 'subject_name');
        }else{
            return ArrayHelper::map(Subject::find()->asArray()->all(), 'id', 'subject_name');
        }
        
    }
}
