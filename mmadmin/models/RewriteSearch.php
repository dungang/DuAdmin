<?php

namespace app\mmadmin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RewriteSearch represents the model behind the search form of `app\backend\models\Rewrite`.
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
        $query = Rewrite::find();

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
            'weight' => $this->weight,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'express', $this->express])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'category', $this->category]);

        return $dataProvider;
    }
}
