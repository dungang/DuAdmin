<?php

namespace app\kit\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\kit\models\Event;

/**
 * EventSearch represents the model behind the search form of `app\kit\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'event', 'level', 'intro'], 'safe'],
            [['is_backend'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Event::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_backend' => $this->is_backend,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
