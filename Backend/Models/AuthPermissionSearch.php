<?php

namespace Backend\Models;

use yii\data\ActiveDataProvider;

/**
 * AuthPermissionSearch represents the model behind the search form of `Backend\Models\AuthPermission`.
 */
class AuthPermissionSearch extends AuthPermission
{

    /**
     * 内部查询字段，非模型字段
     *
     * @var array
     */
    public $_groups;

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'name',
                    'ruleId',
                ],
                'safe'
            ],
            [
                [
                    'type',
                    'createdAt',
                    'updatedAt'
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
        $query = AuthPermission::find();

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
        ]);

        $query->andFilterWhere([
            'like',
            'id',
            $this->id
        ])
        ->andFilterWhere([
            'like',
            'name',
            $this->name
        ])
        ->andFilterWhere([
            'like',
            'ruleId',
            $this->ruleId
        ]);
        $query->leftJoin(AuthItemChild::tableName(), self::tableName() . '.id = ' . AuthItemChild::tableName() . '.child')->andFilterWhere([
            'parent' => isset($params['parent']) ? $params['parent'] : null
        ]);

        return $dataProvider;
    }
}
