<?php

namespace frontend\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use frontend\models\AnswerList;


/**
 * This is the model class for table "question".
 *
 * @property integer $id
 * @property string $details
 * @property integer $chapter_id
 * @property integer $category_id
 * @property integer $subject_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Question extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

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
            [['details', 'country_id', 'chapter_id', 'category_id', 'sub_category_id', 'subject_id', 'status'], 'required'],
            [['details'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'],'safe'],
            [['chapter_id', 'category_id', 'sub_category_id', 'country_id', 'subject_id', 'status', 'created_by', 'updated_by'], 'integer'],
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
            'details' => 'Details',
            'country_id' => 'Country',
            'chapter_id' => 'Chapter',
            'category_id' => 'Category',
            'sub_category_id' => 'Sub Category',
            'subject_id' => 'Subject',
            'chapter_id' => 'Chapter',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    

    public static function get_numberof_question($id){
        
        $number_of_question = self::find()->where(['chapter_id'=>$id,'status' => 1])->count();
        
        return $number_of_question;
    }

    public function getCorrect_answer(){
        return $this->hasOne(AnswerList::className(), ['question_id' => 'id'])->andWhere(['is_correct'=>1]);
    }

    public function getAnswer(){
        return $this->hasMany(AnswerList::className(), ['question_id' => 'id']);
    }
}
