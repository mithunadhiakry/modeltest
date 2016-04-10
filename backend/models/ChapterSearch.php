<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Chapter;

/**
 * ChapterSearch represents the model behind the search form about `backend\models\Chapter`.
 */
class ChapterSearch extends Chapter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','country_id','category_id','sub_category_id', 'chapter_status',  'sort_order', 'created_by', 'updated_by','subject_id'], 'integer'],
            [['chaper_name',  'created_at', 'updated_at'], 'safe'],
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
        $query = Chapter::find();

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
            'chapter_status' => $this->chapter_status,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'country_id' => $this->country_id,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'subject_id' => $this->subject_id,
        ]);

        $query->andFilterWhere(['like', 'chaper_name', $this->chaper_name]);

        return $dataProvider;
    }
}
