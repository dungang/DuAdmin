<?php

namespace app\kit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserExtPropertySearch represents the model behind the search form of `app\kit\models\UserExtProperty`.
 */
class UserExtPropertySearch extends UserExtProperty
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'data_length', 'sort'], 'integer'],
            [['field', 'name', 'data_type', 'hint', 'input_type', 'input_value'], 'safe'],
            [['is_required'], 'boolean'],
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
        $query = UserExtProperty::find();

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
            'data_length' => $this->data_length,
            'is_required' => $this->is_required,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'field', $this->field])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'data_type', $this->data_type])
            ->andFilterWhere(['like', 'hint', $this->hint])
            ->andFilterWhere(['like', 'input_type', $this->input_type])
            ->andFilterWhere(['like', 'input_value', $this->input_value]);

        return $dataProvider;
    }
}
