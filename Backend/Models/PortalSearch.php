<?php

namespace Backend\Models;

use Yii;
use yii\data\ActiveDataProvider;
use Backend\Models\Portal;

/**
 * PortalSearch represents the model behind the search form of `Backend\Models\Portal`.
 */
class PortalSearch extends Portal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isStatic', 'unlimited'], 'integer'],
            [['name', 'code', 'source'], 'safe'],
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
     * @param string|NULL $formName
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = NULL)
    {
        $query = Portal::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
		    'sort' => [
               'defaultOrder' => [
                   'id' => SORT_DESC               ]
            ]
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'isStatic' => $this->isStatic,
            'unlimited' => $this->unlimited,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'source', $this->source]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['name','code','source'],$full_search]);
        }

        return $dataProvider;
    }
}
