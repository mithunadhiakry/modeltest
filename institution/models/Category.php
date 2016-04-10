<?php

namespace institution\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use institution\models\Countrycategoryrel;
use institution\models\Country;

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

    public static function get_all_category_list() {
        $options = [];
        $country_q = self::find()->where(['category_status' => '1','parent_id'=>0])->all();
        
        if(!empty($country_q)){
            foreach ($country_q as $key => $value) {
                $options[$value->id] = $value->category_name;

            }
        }        

        return $options;
    }

    public static function get_all_sub_category_list() {
        $options = [];
        $country_q = self::find()->where(['category_status' => '1'])->andWhere(['!=','parent_id',0])->all();
        
        if(!empty($country_q)){
            foreach ($country_q as $key => $value) {
                $options[$value->id] = $value->category_name;

            }
        }        

        return $options;
    }

    public static function get_all_parentcategory_list(){
        $options = [];
        $country_q = self::find()->where(['category_status' => '1','parent_id' => '0'])->all();
        
        if(!empty($country_q)){
            foreach ($country_q as $key => $value) {
                $options[$value->id] = $value->category_name;

            }
        }        

        return $options;
    }


    public static function get_all_subcategory_list(){
        $options = [];
        $country_q = self::find()->where(['category_status' => '1'])
        ->andWhere(['!=', 'parent_id', '0'])
        ->all();
        
        if(!empty($country_q)){
            foreach ($country_q as $key => $value) {
                $options[$value->id] = $value->category_name;

            }
        }        

        return $options;
    }


    public function getCountryname($id){
       // $data = Countrycategoryrel::find()->where(['category_id'=>$id])->one();
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

    public function getCountrycategoryrel(){
        return $this->hasOne(Countrycategoryrel::className(), ['category_id' => 'id']);
    }


    public static function getCountrySortList($country_id){
        if(!empty($country_id)){
            return ArrayHelper::map(Category::find()->where(['parent_id' => 0,'country_id'=>$country_id])->asArray()->all(), 'id', 'category_name');
        }else{
            return ArrayHelper::map(Category::find()->where(['parent_id' => 0])->asArray()->all(), 'id', 'category_name');
        }
        
    }

    public static function getSubCategorySortList($category_id){
        if(!empty($category_id)){
            return ArrayHelper::map(Category::find()->andWhere(['!=', 'parent_id', '0'])->where(['parent_id'=>$category_id])->asArray()->all(), 'id', 'category_name');
        }else{
            return ArrayHelper::map(Category::find()->andWhere(['!=', 'parent_id', '0'])->asArray()->all(), 'id', 'category_name');
        }
        
    }
}
