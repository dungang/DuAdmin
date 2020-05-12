<?php
namespace app\mmadmin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AuthRoleSearch represents the model behind the search form of `app\mmadmin\models\AuthRole`.
 */
class AuthRoleSearch extends AuthRole
{

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                    'description',
                    'group_name',
                    'rule_name',
                ],
                'safe'
            ],
            [
                [
                    'type',
                    'created_at',
                    'updated_at'
                ],
                'integer'
            ]
        ];
    }

    /**
     *
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
        $query = AuthRole::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
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
            'group_name' => $this->group_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ]);

        $query->andFilterWhere([
            'like',
            'name',
            $this->name
        ])
            ->andFilterWhere([
                'like',
                'description',
                $this->description
            ])
            ->andFilterWhere([
                'like',
                'rule_name',
                $this->rule_name
            ]);

        return $dataProvider;
    }
}
