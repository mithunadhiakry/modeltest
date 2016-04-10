<?php

namespace institution\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use institution\models\UserDetails;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $password_reset_token
 * @property integer $status
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $repeat_password;
    public $old_password;
    public $new_password;

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
    public static function tableName()
    {
        return 'user';
    }

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'username', 'password', 'status','image','address', 'user_type'], 'required','on'=>'signup'],
            [['status'], 'integer'],
            [['name', 'email', 'username', 'password', 'password_reset_token', 'last_access', 'image'], 'string', 'max' => 255],
            [['auth_key','phone'], 'string', 'max' => 32],
            [['user_type'], 'string', 'max' => 255],
            [['phone'], 'safe'],

            [['repeat_password', 'old_password', 'new_password'], 'required' , 'on' => 'change_password'],
            ['repeat_password', 'compare', 'compareAttribute'=>'new_password','on'=>'change_password'],
            ['old_password', 'findPasswords', 'on' => 'change_password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'phone' => 'Phone',
            'address' => 'Address',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'image' => 'Image',
        ];
    }

    public function findPasswords($attribute, $params)
    {
        $user = self::find()->where(['id'=>Yii::$app->user->identity->id])->one();

        if (!$user->validatePassword($this->old_password)){
            $this->addError($attribute, 'Old Password Invalid.');
        }else{
            $this->clearErrors($attribute);
        }
    }



        /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
        /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
/* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
 
/* removed
    public static function findIdentityByAccessToken($token)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
*/
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }



    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /** EXTENSION MOVIE **/

    public function getDetails()
    {
        return $this->hasOne(UserDetails::className(), ['user_id' => 'id']);
    }

    public static function get_all_student_list() {
        $options = [];
        $user_q = self::find()
            ->where(['status' => '1','user_type' => 'student'])
            ->andWhere(['approved_by_institution' => 1])
            ->andWhere(['institution_id' => \Yii::$app->user->identity->id])
            ->all();
        
        if(!empty($user_q)){
            foreach ($user_q as $key => $value) {
                $options[$value->id] = $value->email;

            }
        }        

        return $options;
    }

    public static function get_all_user_list() {
        $options = [];
        $user_q = self::find()->where(['status' => '1'])->all();
        
        if(!empty($user_q)){
            foreach ($user_q as $key => $value) {
                $options[$value->id] = $value->email;

            }
        }        

        return $options;
    }

    public static function get_all_adminuser_list() {
        $options = [];
        $user_q = self::find()->where(['status' => '1','user_type' => 'admin'])->all();
        
        if(!empty($user_q)){
            foreach ($user_q as $key => $value) {
                $options[$value->id] = $value->email;

            }
        }        

        return $options;
    }

    
}
