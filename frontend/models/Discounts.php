<?php

namespace frontend\models;

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
            [['start_date', 'end_date', 'discounts_name','discounts_amount','discounts_type','discounts_slot', 'discounts_code', 'status'], 'required'],
            [['start_date', 'end_date', 'timestamp'], 'safe'],
            [['status'], 'integer'],
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
            'discounts_name' => 'Discounts Name',
            'discounts_code' => 'Discounts Code',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
}
