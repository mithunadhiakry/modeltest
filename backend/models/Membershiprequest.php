<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;

use app\models\User;

/**
 * This is the model class for table "membershiprequest".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $invoice_id
 * @property string $payment_type
 * @property integer $status
 * @property string $timestamp
 */
class Membershiprequest extends \yii\db\ActiveRecord
{

    public $membershipstatus;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'membershiprequest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'invoice_id', 'payment_type', 'status'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['timestamp','discounts_code'], 'safe'],
            [['invoice_id', 'payment_type'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'invoice_id' => 'Invoice Number',
            'payment_type' => 'Payment Method',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUserdata()
    {
        return $this->user ? '<a href="'.Url::toRoute(['user/view?id='.$this->user->id]).'">'.$this->user->email.'</a>' : 'email not found';
    }

    public function getPackage(){
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }

    public function getPackagedata(){
        return $this->package ? $this->package->package_type : 'package not found';
    }

    public function getInvoicedata(){
        $data = "<a href='#'>sdsds</a>";
        return $data;
    }

    public function getExperied_date()
    {
        return $this->hasMany(Membershiprequest::className(), ['user_id' => 'user_id'])->where(['status' => 1]);
    }

    public function getDiscounts(){
        return $this->hasOne(Discounts::className(), ['discounts_code' => 'discounts_code']);
    }

    public function getAmountofpaymentdata(){

        if(!empty($this->discounts)){
            $original_amount = $this->package->price_bd * ($this->package->duration)/30;
            $amount = $original_amount - ($original_amount * $this->discounts->discounts_amount)/100;
        }else{

           if(!empty($this->package)){
                $amount = $this->package->price_bd * ($this->package->duration)/30;
           }
        }

        return 'Tk. '.$amount;
        
    }

    public function getAmountofdiscountdata(){

        if(!empty($this->discounts)){
            $original_amount = $this->package->price_bd * ($this->package->duration)/30;
            $amount = 'Tk.' .floor(($original_amount * $this->discounts->discounts_amount)/100);
        }else{

           $amount = '';
        }

        return $amount;
    }

    public static function get_all_payment_list() {
        $options = [];
        $payment_q = self::find()->all();
        
        if(!empty($payment_q)){
            foreach ($payment_q as $key => $value) {
                if($value->status == 1){
                    $options[$value->status] = 'PAID';
                }
                if($value->status == 0){
                    $options[$value->status] = 'DUE';
                }
                

            }
        }        

        return $options;
    }


    public static function get_all_membershipstatus(){

        $options = [];
        $options['1'] = 'PAID';
        $options['0'] = 'Free';

        return $options;
    }

}
