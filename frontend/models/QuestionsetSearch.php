<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Questionset;

/**
 * QuestionsetSearch represents the model behind the search form about `frontend\models\Questionset`.
 */
class QuestionsetSearch extends Questionset
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'deduct_on_pause', 'country_id', 'category_id', 'sub_category_id', 'subject_id', 'status'], 'integer'],
            [['question_set_id', 'question_set_name', 'exam_time', 'pasue'], 'safe'],
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
        $query = Questionset::find();

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
            'deduct_on_pause' => $this->deduct_on_pause,
            'country_id' => $this->country_id,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'subject_id' => $this->subject_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'question_set_id', $this->question_set_id])
            ->andFilterWhere(['like', 'question_set_name', $this->question_set_name])
            ->andFilterWhere(['like', 'exam_time', $this->exam_time])
            ->andFilterWhere(['like', 'pasue', $this->pasue]);

        return $dataProvider;
    }
}
