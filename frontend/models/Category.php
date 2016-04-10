<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $category_name
 * @property integer $category_status
 * @property string $meta_key
 * @property string $meta_description
 * @property integer $sort_order
 * @property integer $country_id
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Category extends \yii\db\ActiveRecord
{
    public $countryname;
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
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'category_status'], 'required'],
            [['category_status', 'sort_order'], 'integer'],
            [['country_id','parent_id','created_at', 'updated_at','created_by','updated_by','sort_order'], 'safe'],
            [['category_name'], 'string', 'max' => 255],
            [['created_at', 'updated_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'category_status' => 'Category Status',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'created_by' => 'Careated By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'country_id' => 'Country',
            'parent_id' => 'Parent Category'
        ];
    }

    public static function get_all_category_list($id) {
       
        $category_q = self::find()
                    ->where(['parent_id'=>0,'country_id' => $id,'category_status' => 1])
                    ->all();
        
        return $category_q;
    }

   
    public static function get_sub_category($id){
        $category_q = self::find()
                    ->where(['parent_id'=>$id,'category_status' => 1])
                    ->all();
        
        return $category_q;
    }

    

    
}
