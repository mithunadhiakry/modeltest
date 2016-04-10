<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use backend\models\Subjectchapterrel;

use backend\models\Country;
use backend\models\Subject;

/**
 * This is the model class for table "chapter".
 *
 * @property integer $id
 * @property string $chaper_name
 * @property integer $chapter_status
 * @property integer $sort_order
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Chapter extends \yii\db\ActiveRecord
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
        return 'chapter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id','category_id','sub_category_id','subject_id','chaper_name', 'chapter_status'], 'required'],
            [['chapter_status','sort_order', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at','created_by','updated_by','sort_order'], 'safe'],
            [['chaper_name', ], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chaper_name' => 'Chaper Name',
            'chapter_status' => 'Chapter Status',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'country_id' => 'Country',
            'category_id' => 'Category',
            'sub_category_id' => 'Sub Category',
            'subject_id' => 'Subject'
        ];
    }

    public static function get_all_chapter_list() {
        $options = [];
        $chapter_q = self::find()->where(['chapter_status' => '1'])->all();
        
        if(!empty($chapter_q)){
            foreach ($chapter_q as $key => $value) {
                $options[$value->id] = $value->chaper_name;

            }
        }        

        return $options;
    }

    public static function get_all_subject_list(){
        $options = [];
        $country_q = self::find()->where(['subject_status' => '1'])
        ->all();
        
        if(!empty($country_q)){
            foreach ($country_q as $key => $value) {
                $options[$value->id] = $value->subject_name;

            }
        }        

        return $options;
    }

    public static function getCountryname($id){
       // $data = Countrycategoryrel::find()->where(['category_id'=>$id])->one();
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

    public static function getSubjectname($id){
        
        $data = Subject::find()->where(['id'=>$id])->one();
                
        if(!empty($data->subject_name)){
            return $data->subject_name;
        }else{
            return '';
        }
    }

   public static function getChapterSortList($subject_id){
        
        if(!empty($subject_id)){
            return ArrayHelper::map(Chapter::find()->where(['subject_id'=>$subject_id])->asArray()->all(), 'id', 'chaper_name');
        }else{
            return ArrayHelper::map(Chapter::find()->asArray()->all(), 'id', 'chaper_name');
        }
        
    }

   
}
