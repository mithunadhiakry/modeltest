<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use frontend\models\Subject;


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

    public static function get_all_chapter_list($id) {
       
        $chapter_q = self::find()->where(['chapter_status' => '1','subject_id' => $id])->all();
        
        return $chapter_q;
    }

    public function getSubject(){
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    public function getSubcategory(){
        return $this->hasOne(Category::className(), ['id' => 'sub_category_id']);
    }

   
}
