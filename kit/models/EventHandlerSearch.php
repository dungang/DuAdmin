<?php

namespace app\kit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EventHandlerSearch represents the model behind the search form of `app\kit\models\EventHandler`.
 */
class EventHandlerSearch extends EventHandler
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','event_id', 'sort'], 'integer'],
            [['is_active'], 'boolean'],
            [['name', 'handler', 'intro'], 'safe'],
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
        $query = EventHandler::find();

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
            'event_id' => $this->event_id,
            'is_active' => $this->is_active,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'handler', $this->handler])
            ->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
