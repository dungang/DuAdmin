<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * PageBlockDataSearch represents the model behind the search form of `DuAdmin\Models\PageBlockData`.
 */
class PageBlockDataSearch extends PageBlockData
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'blockId', 'size', 'enableCache', 'sort'], 'integer'],
            [['showTitle', 'filter', 'orderBy', 'style', 'expiredAt'], 'safe'],
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
        $query = PageBlockData::find();

        // add conditions that should always apply here

        // search before event
        $this->beforeSearch($query,$params);    

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
		    'sort' => [ 
               'defaultOrder' => [ 
                   'sort' => SORT_ASC 
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
            'blockId' => $this->blockId,
            'size' => $this->size,
            'enableCache' => $this->enableCache,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['DATE_RANGE','expiredAt',$this->expiredAt]);

        $query->andFilterWhere(['like', 'showTitle', $this->showTitle])
            ->andFilterWhere(['like', 'filter', $this->filter])
            ->andFilterWhere(['like', 'orderBy', $this->orderBy])
            ->andFilterWhere(['like', 'style', $this->style]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['showTitle','filter','orderBy','style'],$full_search]);
        }

        return $dataProvider;
    }
}
