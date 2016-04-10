<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Membershiprequest;

/**
 * MembershiprequestSearch represents the model behind the search form about `backend\models\Membershiprequest`.
 */
class MembershiprequestSearch extends Membershiprequest
{
    /**
     * @inheritdoc
     */
    public $user_profile;
    public $points_pack;

    public function rules()
    {
        return [
            [['id', 'user_id', 'status'], 'integer'],
            [['invoice_id', 'payment_type', 'user_profile','points_pack','membershipstatus'], 'safe'],
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
    public function search($params)
    {

        $query = Membershiprequest::find()->joinWith('user')->joinWith('package');


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //  $dataProvider->sort->attributes['id'] = [
        //     'asc' => ['id' => SORT_DESC],
        // ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,           
        ]);


        
        
         $query->orderBy('id desc');


        $query->andFilterWhere(['like', 'invoice_id', $this->invoice_id])
            ->andFilterWhere(['like', 'payment_type', $this->payment_type])
            ->andFilterWhere(['like', 'membershiprequest.status', $this->status])
            ->andFilterWhere(['like', 'user.email', $this->user_profile])
            ->andFilterWhere(['like', 'package.package_type', $this->points_pack]);

        return $dataProvider;
    }
}
