<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchased_package".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $package_name
 * @property integer $points
 * @property string $expired_date
 * @property string $time
 */
class PurchasedPackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchased_package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'package_name', 'points', 'expired_date'], 'required'],
            [['user_id', 'points'], 'integer'],
            [['expired_date', 'time'], 'safe'],
            [['package_name'], 'string', 'max' => 255]
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
            'package_name' => 'Package Name',
            'points' => 'Points',
            'expired_date' => 'Expired Date',
            'time' => 'Time',
        ];
    }
}
