<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "discounts".
 *
 * @property integer $id
 * @property string $start_date
 * @property string $end_date
 * @property string $discounts_name
 * @property string $discounts_code
 * @property integer $status
 * @property string $timestamp
 */
class Discounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date', 'discounts_name','discounts_type','discounts_slot', 'discounts_code','discounts_amount','discounts_month', 'status','discounts_year'], 'required'],
            [['start_date', 'end_date', 'timestamp'], 'safe'],
            [['status','discounts_slot','discounts_year'], 'integer'],
            [['discounts_name', 'discounts_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'discounts_name' => 'Discount Name',
            'discounts_code' => 'Discount Code',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
            'discounts_amount' => 'Discount Offers',
            'discounts_month' => 'Discount Month',
            'discounts_slot' => 'Discount Slot',
            'discounts_type' => 'Discount Type',
            'discounts_year' => 'Discount Year'
        ];
    }
}
