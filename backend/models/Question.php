<?php

namespace backend\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use backend\models\Subject;
use backend\models\Category;
use backend\models\Chapter;
use backend\models\Country;
use backend\models\User;

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

    public $subtract;

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
            [['details' ,'copied_to','copied_from'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'],'safe'],
            [['chapter_id', 'category_id', 'sub_category_id', 'country_id', 'subject_id', 'status', 'created_by', 'updated_by','parent_question'], 'integer'],
            [['created_at', 'updated_at','subtract','questions_of_year'], 'safe']
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

    public function getCreateUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
     
    public function getCreateUserName()
    {
        return $this->createUser ? $this->createUser->username : '- no user -';
    }

    public function getUpdateUser()
    {
       return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
        
    public function getUpdateUserName()
    {
        return $this->createUser ? $this->updateUser->username : '- no user -';
    } 

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    public function getSubcategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'sub_category_id']);
    }
    public function getChapter()
    {
        return $this->hasOne(Chapter::className(), ['id' => 'chapter_id']);
    }

    public function getAnswers()
    {
        return $this->hasMany(AnswerList::className(), ['question_id' => 'id']);
    }

    public static function getCountryname($id){
        $countty_data = Country::find()->where(['id' => $id ])->one();
        return $countty_data->name;
    }

    public static function getParentcategoryname($id){
        
        $data = Category::find()->where(['id'=>$id])->one();
                
        if(!empty($data->category_name)){
            return $data->category_name;
        }else{
            return '';
        }
    }

    public static function getSubjectname($id){
        
        $data = Subject::find()->where(['id'=>$id])->one();
                
        if(!empty($data->subject_name)){
            return $data->subject_name;
        }else{
            return '';
        }
    }

    public static function getChaptername($id){
        
        $data = Chapter::find()->where(['id'=>$id])->one();
                
        if(!empty($data->chaper_name)){
            return $data->chaper_name;
        }else{
            return '';
        }
    }
}
