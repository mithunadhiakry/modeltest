<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "categorysubjectrel".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $subject_id
 */
class Categorysubjectrel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categorysubjectrel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'subject_id'], 'required'],
            [['category_id', 'subject_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'subject_id' => 'Subject ID',
        ];
    }

    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id'])->andWhere(['subject_status'=>1]);
    }
}
