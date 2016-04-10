<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "package".
 *
 * @property integer $id
 * @property string $package_type
 * @property string $price_bd
 * @property string $duration
 * @property string $assign_exam_ability
 * @property string $save_exam
 * @property string $advanced_reporting
 * @property string $share_an_advance_report
 * @property string $time
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * @inheritdoc
     */
     public function rules()
    {
        return [
            [['package_type', 'price_bd', 'duration', 'share_exam', 'save_exam', 'advanced_reporting'], 'required'],
            [['time'], 'safe'],
            [['price_bd'],'integer'],
            [['package_type', 'duration', 'share_exam', 'save_exam', 'advanced_reporting'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_type' => 'Points Pack*',
            'price_bd' => 'Price (BDT)',
            'duration' => 'Validation Duration',
            'share_exam' => 'Share Exam',            
            'save_exam' => 'Save Exam',
            'advanced_reporting' => 'Advanced Reporting',
            'time' => 'Time',
        ];
    }
}
