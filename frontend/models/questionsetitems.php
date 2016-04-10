<?php

namespace frontend\models;

use Yii;
use frontend\models\AnswerList;

/**
 * This is the model class for table "questionsetitems".
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $question_set_id
 * @property integer $subject_id
 */
class questionsetitems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionsetitems';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'question_set_id', 'subject_id'], 'required'],
            [['question_id', 'subject_id'], 'integer'],
            [['question_set_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'question_set_id' => 'Question Set ID',
            'subject_id' => 'Subject ID',
        ];
    }

    public function getCorrect_answer(){
        return $this->hasOne(AnswerList::className(), ['question_id' => 'question_id'])->andWhere(['is_correct'=>1]);
    }
}
