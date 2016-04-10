<?php

namespace backend\models;

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
            [['gender'], 'required'],
            [['recommended_other','your_expectation','how_do_you_know_about_modeltest','employee_organization','date_of_birth', 'institution_name','education', 'designation', 'date_of_birth', 'employee_status','profile_complete' ], 'safe'],
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
            'education' => 'Education Lavel (last)',
            'designation' => 'Designation',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'employee_status' => 'Employee Status',
            'user_id' => 'User ID',
            'institution_name' => 'Educational Institute',
            'employee_organization' => 'Organization',
            'how_do_you_know_about_modeltest' => 'How do you know about model-test.com?',
            'your_expectation' => 'What is your main expectation from model-test.com?',
            'recommended_other' => 'Will you recommend model-test.com to others, if you find it helpful?'
        ];
    }
}
