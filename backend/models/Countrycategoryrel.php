<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "countrycategoryrel".
 *
 * @property integer $id
 * @property integer $country_id
 * @property integer $category_id
 */
class Countrycategoryrel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countrycategoryrel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'category_id'], 'required'],
            [['country_id', 'category_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_id' => 'Country ID',
            'category_id' => 'Category ID',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])->andWhere(['category_status'=>1]);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
}
