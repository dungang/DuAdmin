<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * RewriteSearch represents the model behind the search form of `DuAdmin\Models\Rewrite`.
 */
class RewriteSearch extends Rewrite
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'weight'], 'integer'],
            [['name', 'express', 'route', 'category'], 'safe'],
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
        $query = Rewrite::find();
        
        // add conditions that should always apply here
        
        // search before event
        $this->beforeSearch($query,$params);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
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
            'weight' => $this->weight,
        ]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
        ->andFilterWhere(['like', 'express', $this->express])
        ->andFilterWhere(['like', 'route', $this->route])
        ->andFilterWhere(['like', 'category', $this->category]);
        
        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['name','express','route','category'],$full_search]);
        }
        
        return $dataProvider;
    }
}