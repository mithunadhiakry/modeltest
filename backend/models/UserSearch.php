<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;
use backend\models\Membershiprequest;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{

    public $membershiprequest_status;
    public $memreqstatus;

    public $x=1;
    public $y=0;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status','membershiprequest_status','memreqstatus'], 'integer'],
            [['name', 'user_type', 'email', 'username', 'password','created_at', 'auth_key', 'password_reset_token'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$status = '',$user_type ='',$addtion = '')
    {
        $query = User::find();
        
        // if(empty($params['UserSearch']['memreqstatus'])){
        //     $query = User::find();
        // }else{
            
        //     if($params['UserSearch']['memreqstatus']=='FREE'){
        //         $this->x=0;
        //         $this->y=1;
        //     }
        //     $query = User::find()->select('user.*,membershiprequest.status as st')->joinWith('mstatus')
        //                 ->groupBy('user.id')
        //                 ->where(count('st' == 1) == 0);
            // $query = User::find()->joinWith(['mstatus'=>function($q){
            //     $q->where(['membershiprequest.status'=>$this->x]);
            //     $q->andWhere(['!=','membershiprequest.status',$this->y]);
            // }])->groupBy('user.id,membershiprequest.status')->having(count('membershiprequest.status' == 1) == 0);
        // }
       /*echo '<pre>';
       var_dump($query->all());
       exit();*/
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       

        if(!empty($user_type)){

            $query->andFilterWhere([
                'id' => $this->id,
                'user.status' => $status,
            ])->andFilterWhere(['!=', 'user_type', 'admin']);

            $query->orderBy('id desc');

        }else{

            $query->andFilterWhere([
                'id' => $this->id,
                'user.status' => $status,
            ]);

        }

        if($addtion == 'new'){
            $query->andFilterWhere([
                'user.status' => '0',
            ]);
        }
        
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'user_type', $this->user_type])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token]);

        return $dataProvider;
    }
}
