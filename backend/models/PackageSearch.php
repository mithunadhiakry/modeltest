<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Package;

/**
 * PackageSearch represents the model behind the search form about `backend\models\Package`.
 */
class PackageSearch extends Package
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['package_type', 'price_bd', 'duration', 'share_exam', 'save_exam', 'advanced_reporting','time'], 'safe'],
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
        $query = Package::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'time' => $this->time,
        ]);

        $query->andFilterWhere(['like', 'package_type', $this->package_type])
            ->andFilterWhere(['like', 'price_bd', $this->price_bd])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'share_exam', $this->share_exam])
            ->andFilterWhere(['like', 'save_exam', $this->save_exam])
            ->andFilterWhere(['like', 'advanced_reporting', $this->advanced_reporting]);

        return $dataProvider;
    }
}
