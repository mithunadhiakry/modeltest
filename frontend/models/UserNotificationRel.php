<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_notification_rel".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $notification_id
 */
class UserNotificationRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_notification_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'notification_id'], 'required'],
            [['user_id'], 'integer'],
            [['notification_id'], 'string', 'max' => 255]
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
            'notification_id' => 'Notification ID',
        ];
    }
}
