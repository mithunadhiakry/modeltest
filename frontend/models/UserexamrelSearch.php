<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Userexamrel;

/**
 * UserexamrelSearch represents the model behind the search form about `frontend\models\Userexamrel`.
 */
class UserexamrelSearch extends Userexamrel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'exam_id', 'assign_by', 'number_of_question'], 'integer'],
            [['subject_course', 'exam_time', 'created_at'], 'safe'],
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
        $query = Userexamrel::find();

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
            'user_id' => $this->user_id,
            'exam_id' => $this->exam_id,
            'assign_by' => $this->assign_by,
            'number_of_question' => $this->number_of_course,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'subject_course', $this->subject_course])
            ->andFilterWhere(['like', 'exam_time', $this->exam_time]);

        return $dataProvider;
    }
}
