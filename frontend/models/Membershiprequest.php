<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "membershiprequest".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $invoice_id
 * @property string $payment_type
 * @property integer $status
 * @property string $timestamp
 */
class Membershiprequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'membershiprequest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'invoice_id', 'payment_type','discount', 'vat','status','package_id'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['timestamp','discounts_code'], 'safe'],
            [['invoice_id', 'payment_type'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'invoice_id' => 'Invoice ID',
            'payment_type' => 'Payment Type',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
}
