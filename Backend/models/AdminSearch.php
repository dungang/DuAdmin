<?php

namespace Backend\Models;

use yii\data\ActiveDataProvider;
use Backend\Models\Admin;

/**
 * AdminSearch represents the model behind the search form of `Backend\Models\Admin`.
 */
class AdminSearch extends Admin
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'login_failure', 'login_at', 'created_at', 'updated_at'], 'integer'],
            [['username', 'nickname', 'avatar', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'mobile', 'login_ip'], 'safe'],
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
        $query = Admin::find();

        // add conditions that should always apply here

        // search before event
        $this->beforeSearch($query,$params);    

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
            'status' => $this->status,
            'login_failure' => $this->login_failure,
            'login_at' => $this->login_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere($this->filterBetween('created_at', $this->created_at))
            ->andFilterWhere($this->filterBetween('updated_at', $this->updated_at));

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'login_ip', $this->login_ip]);

        return $dataProvider;
    }
}
