<?php

namespace backend\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "answer_list".
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $answer
 * @property integer $is_correct
 * @property integer $sort_order
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class AnswerList extends \yii\db\ActiveRecord
{

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
    

    public static function tableName()
    {
        return 'answer_list';
    }


    public function rules()
    {
        return [
            [['answer'], 'required'],
            [['question_id', 'is_correct', 'sort_order', 'created_by', 'updated_by'], 'integer'],
            [['answer'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'safe']
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'answer' => 'Answer',
            'is_correct' => 'Is Correct?',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public static function getFormAttribs() {
        return [
            // primary key column
            'id'=>[ // primary key attribute
                'type'=>TabularForm::INPUT_HIDDEN, 
                'columnOptions'=>['hidden'=>true]
            ], 
            'answer'=>['type'=>TabularForm::INPUT_STATIC],
            'is_correct'=>[
                'type'=>TabularForm::INPUT_CHECKBOX,
                'value'=>'is_correct',
                //'widgetClass'=>\kartik\checkbox\CheckboxX::classname(),
                //'options'=>['name'=>'AnswerList[is_correct]']
            ],
            'sort_order'=>['type'=>TabularForm::INPUT_TEXT],
            
        ];
    }
}
