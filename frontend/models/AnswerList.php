<?php

namespace frontend\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;


class AnswerList extends \yii\db\ActiveRecord
{

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


    
    
}
