<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "contactform".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string $subject
 * @property string $message
 * @property string $timestamp
 */
class Contactform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contactform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'mobile', 'subject', 'message'], 'required'],
            [['message'], 'string'],
            [['email'],'email'],
            [['timestamp'], 'safe'],
            [['name', 'email', 'subject'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'subject' => 'Subject',
            'message' => 'Message',
            'timestamp' => 'Timestamp',
        ];
    }
}
