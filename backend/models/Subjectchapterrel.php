<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "subjectchapterrel".
 *
 * @property integer $id
 * @property integer $subject_id
 * @property integer $chapter_id
 */
class Subjectchapterrel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjectchapterrel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject_id', 'chapter_id'], 'required'],
            [['subject_id', 'chapter_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_id' => 'Subject ID',
            'chapter_id' => 'Chapter ID',
        ];
    }

    public function getChapter()
    {
        return $this->hasOne(Chapter::className(), ['id' => 'chapter_id'])->andWhere(['chapter_status'=>1]);
    }
}
