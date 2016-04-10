<?php

namespace frontend\models;

use Yii;

use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use frontend\models\Chapter;
use frontend\models\Question;
/**
 * This is the model class for table "tempquestionlist".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $question_id
 * @property integer $answer_id
 * @property integer $is_correct
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Tempquestionlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tempquestionlist';
    }

    public $is_skip = 0;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mark_for_review','exam_id','serial','chapter_id','user_id', 'question_id', 'answer_id', 'is_correct'], 'required'],
            [['user_id', 'question_id', 'answer_id', 'is_correct', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
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
            'question_id' => 'Question ID',
            'answer_id' => 'Answer ID',
            'chapter_id' => 'Chapter Id',
            'is_correct' => 'Is Correct',
            'serial' => 'Serial',
            'exam_id' => 'Exam id',
            'mark_for_review' => "Mark for Review",
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getChapter(){
        return $this->hasOne(Chapter::className(), ['id' => 'chapter_id']);
    }
    public function getQuestion(){
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }
}
