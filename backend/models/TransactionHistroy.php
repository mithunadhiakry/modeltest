<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "transaction_histroy".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $opening
 * @property integer $points
 * @property string $action
 * @property integer $closing
 * @property string $type
 * @property string $exam_id
 * @property string $time
 */
class TransactionHistroy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_histroy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'opening', 'points', 'action', 'closing', 'type'], 'required'],
            [['user_id', 'opening', 'points', 'closing', 'purchased_package_id'], 'integer'],
            [['time'], 'safe'],
            [['action'], 'string', 'max' => 10],
            [['type'], 'string', 'max' => 255],
            [['exam_id'], 'string', 'max' => 200]
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
            'opening' => 'Opening',
            'points' => 'Points',
            'action' => 'Action',
            'closing' => 'Closing',
            'type' => 'Type',
            'exam_id' => 'Exam ID',
            'time' => 'Time',
        ];
    }

    public function getPackage_name(){
        return $this->hasOne(PurchasedPackage::className(), ['id' => 'purchased_package_id']);
    }
}
