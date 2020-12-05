<?php

namespace Backend\Models;

use Yii;
use yii\data\ActiveDataProvider;
use Backend\Models\SourceMessage;

/**
 * SourceMessageSearch represents the model behind the search form of `Backend\Models\SourceMessage`.
 */
class SourceMessageSearch extends SourceMessage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['category', 'message'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return parent::scenarios();
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
        $query = SourceMessage::find();

        // add conditions that should always apply here

        // search before event
        $this->beforeSearch($query,$params);    

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
		    'sort' => [ 
               'defaultOrder' => [ 
                   'category' => SORT_DESC 
               ] 
            ] 
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
        ]);

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'message', $this->message]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['category','message'],$full_search]);
        }

        return $dataProvider;
    }
}
