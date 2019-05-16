<?php
namespace app\kit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\kit\helpers\KitHelper;

/**
 * UserSearch represents the model behind the search form of `app\kit\models\User`.
 */
class UserSearch extends User
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
                    'id',
                    'status'
                ],
                'integer'
            ],
            [
                [
                    'created_at',
                    'updated_at'
                ],
                'date',
                'format' => 'yyyy-mm-dd'
            ],
            [
                [
                    'username',
                    'nick_name',
                    'role',
                    'is_admin',
                    'is_super',
                    'mobile',
                    'email',
                    'def_project'
                ],
                'safe'
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
        $query = User::find();

        // add conditions that should always apply here

        $this->beforeSearch($query,$params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (! $this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'role' => $this->role
        ]);
        $query->andFilterWhere([
            'like',
            'username',
            $this->username
        ])
            ->andFilterWhere([
            'like',
            'email',
            $this->email
        ])
            ->andFilterWhere([
            'like',
            'mobile',
            $this->mobile
        ])
            ->andFilterWhere(KitHelper::betweenDayWithTimestamp('updated_at', $this->updated_at))
            ->andFilterWhere(KitHelper::betweenDayWithTimestamp('created_at', $this->created_at));

        return $dataProvider;
    }
}
