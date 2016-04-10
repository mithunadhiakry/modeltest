<?php

namespace institution\models;

use Yii;

/**
 * This is the model class for table "user_details".
 *
 * @property integer $id
 * @property string $education
 * @property string $designation
 * @property string $gender
 * @property string $date_of_birth
 * @property string $employee_status
 * @property integer $user_id
 */
class UserDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender','date_of_birth', 'institution_name','education', 'designation', 'date_of_birth', 'employee_status' ], 'safe'],
            [['user_id'], 'integer'],
            [['institution_name'],'string'],
            [['education', 'designation', 'gender', 'employee_status'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'education' => 'Education',
            'designation' => 'Designation',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'employee_status' => 'Employee Status',
            'user_id' => 'User ID',
            'institution_name' => 'Institution Name'
        ];
    }
}
