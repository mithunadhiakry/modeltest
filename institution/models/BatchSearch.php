<?php

namespace institution\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use institution\models\Batch;

/**
 * BatchSearch represents the model behind the search form about `institution\models\Batch`.
 */
class BatchSearch extends Batch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['batch_no', 'course_start', 'course_end', 'created_at', 'updated_at'], 'safe'],
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
        $query = Batch::find();

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
            'course_id' => $this->course_id,
            'course_start' => $this->course_start,
            'course_end' => $this->course_end,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $logged_id = Yii::$app->user->identity->id;
        $query->andFilterWhere(['like', 'batch_no', $this->batch_no]);
        $query->andWhere(['created_by' => $logged_id ]);

        return $dataProvider;
    }
}
