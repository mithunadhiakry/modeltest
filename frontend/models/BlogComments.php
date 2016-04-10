<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "blog_comments".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property integer $user_id
 * @property string $comments
 * @property string $time
 */
class BlogComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_id', 'user_id', 'comments'], 'required'],
            [['blog_id', 'user_id'], 'integer'],
            [['comments'], 'string'],
            [['time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blog_id' => 'Blog ID',
            'user_id' => 'User ID',
            'comments' => 'Comments',
            'time' => 'Time',
        ];
    }

    public function getAuthor_name(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
        
    }
}
