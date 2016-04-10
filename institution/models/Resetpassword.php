<?php
namespace institution\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Login form
 */
class Resetpassword extends Model
{
    public $email;
    public $password;
    public $repeat_password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required' , 'on' => 'send_token'],
            [['email'],'email'],
            [['password', 'repeat_password'], 'required' , 'on' => 'reset_pass'],
            ['repeat_password', 'compare', 'compareAttribute'=>'password','on'=>'reset_pass'],
            ['email', 'findEmail', 'on' => 'send_token'],
        ];
    }

    public function findEmail($attribute, $params)
    {
        $user = User::find()->where(['email'=>$this->email])->one();

        if (!$user){
            $this->addError($attribute, 'Sorry email is Invalid.');
        }else{
            $this->clearErrors($attribute);
        }
    }

}
