<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "purchase_histroy".
 *
 * @property integer $id
 * @property string $package_name
 * @property integer $points
 * @property integer $price
 * @property string $payment_id
 * @property string $payment_type
 * @property integer $duration
 * @property string $start_date
 * @property string $end_date
 * @property string $time
 */
class PurchaseHistroy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_histroy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_name', 'points', 'price', 'payment_id', 'payment_type', 'duration', 'start_date', 'end_date','user_id'], 'required'],
            [['points', 'price', 'duration'], 'integer'],
            [['start_date', 'end_date', 'time'], 'safe'],
            [['package_name', 'payment_id', 'payment_type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_name' => 'Package Name',
            'points' => 'Points',
            'price' => 'Price',
            'payment_id' => 'Payment ID',
            'payment_type' => 'Payment Type',
            'duration' => 'Duration',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'time' => 'Time',
        ];
    }
}
