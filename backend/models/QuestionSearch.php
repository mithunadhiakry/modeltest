<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Question;

/**
 * QuestionSearch represents the model behind the search form about `backend\models\Question`.
 */
class QuestionSearch extends Question
{
    /**
     * @inheritdoc
     */

    public $from_date;

    public function rules()
    {
        return [
            [['chapter_id', 'category_id','sub_category_id','country_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['details', 'created_at', 'updated_at', 'subject_id','from_date'], 'safe'],
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
    public function search($params,$subtract='',$added_list='')
    {
        $query = Question::find();

        $auth_user_id = Yii::$app->user->identity->id;

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
            'chapter_id' => $this->chapter_id,
            'category_id' => $this->category_id,
            'country_id' => $this->country_id,
            'sub_category_id' => $this->sub_category_id,
            'subject_id' => $this->subject_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        if($added_list == 'added_list'){
            foreach ($subtract as $key => $value) {
                $query->andFilterWhere(['!=', 'id', $value]);
            }
        }

        

        $query->andFilterWhere(['like', 'details', $this->details]);
        $query->andFilterWhere(['=', 'category_id', $this->category_id]);

        if($auth_user_id != 9){
            $query->andFilterWhere(['=', 'created_by', $auth_user_id]);
        }
        

        if(isset($_GET['from_date']) && $_GET['from_date'] != '' && isset($_GET['to_date']) && $_GET['to_date'] != '' ){
            $query->andFilterWhere(['BETWEEN', 'created_at', $_GET['from_date'], $_GET['to_date']]);
        }

        

        return $dataProvider;
    }
}
