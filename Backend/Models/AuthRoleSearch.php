<?php

namespace Backend\Models;

use Yii;
use yii\data\ActiveDataProvider;
use Backend\Models\AuthRole;

/**
 * AuthRoleSearch represents the model behind the search form of `Backend\Models\AuthRole`.
 */
class AuthRoleSearch extends AuthRole
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'ruleId', 'data', 'createdAt', 'updatedAt'], 'safe'],
            [['type'], 'integer'],
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
        $query = AuthRole::find();

        // add conditions that should always apply here

        // search before event
        $this->beforeSearch($query,$params);    

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
		    'sort' => [ 
               'defaultOrder' => [ 
                   'createdAt' => SORT_DESC 
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
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['DATE_RANGE','createdAt',$this->createdAt])
            ->andFilterWhere(['DATE_RANGE','updatedAt',$this->updatedAt]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'ruleId', $this->ruleId])
            ->andFilterWhere(['like', 'data', $this->data]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['id','name','ruleId','data'],$full_search]);
        }

        return $dataProvider;
    }
}
