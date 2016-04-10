<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "invite_friends".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $invite_friends_email
 */
class InviteFriends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invite_friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'invite_friends_email'], 'required'],
            [['user_id'], 'integer'],
            [['status'],'safe'],
            [['invite_friends_email'], 'string', 'max' => 255]
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
            'invite_friends_email' => 'Invite Friends Email',
        ];
    }
}
