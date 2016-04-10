<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "question_country_rels".
 *
 * @property integer $id
 * @property integer $question_id
 * @property integer $country_id
 */
class QuestionCountryRels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_country_rels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'country_id'], 'required'],
            [['question_id', 'country_id'], 'integer']
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
            'country_id' => 'Country ID',
        ];
    }
}
