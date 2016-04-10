<?php

namespace backend\models;

use Yii;

use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "classlist".
 *
 * @property integer $id
 * @property integer $country_id
 * @property integer $category_id
 * @property string $subject_name
 * @property integer $subject_status
 * @property integer $sort_order
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class Classlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

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
        return 'classlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'category_id', 'subject_name', 'subject_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['country_id', 'category_id', 'subject_status', 'sort_order'], 'integer'],
            [['created_at', 'updated_at','sort_order'], 'safe'],
            [['subject_name'], 'string', 'max' => 255],
            [['created_by', 'updated_by'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_id' => 'Country ID',
            'category_id' => 'Category ID',
            'subject_name' => 'Subject Name',
            'subject_status' => 'Subject Status',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
