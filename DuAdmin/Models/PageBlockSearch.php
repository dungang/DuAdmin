<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * PageBlockSearch represents the model behind the search form of `DuAdmin\Models\PageBlock`.
 */
class PageBlockSearch extends PageBlock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'size', 'isActive', 'sort'], 'integer'],
            [['title', 'showTitle', 'background', 'widget', 'sourceApp', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = PageBlock::find();

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
            'size' => $this->size,
            'isActive' => $this->isActive,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['DATE_RANGE','createdAt',$this->createdAt])
            ->andFilterWhere(['DATE_RANGE','updatedAt',$this->updatedAt]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'showTitle', $this->showTitle])
            ->andFilterWhere(['like', 'background', $this->background])
            ->andFilterWhere(['like', 'widget', $this->widget])
            ->andFilterWhere(['like', 'sourceApp', $this->sourceApp]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['title','showTitle','background','widget','sourceApp'],$full_search]);
        }

        return $dataProvider;
    }
}
