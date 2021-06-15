<?php

namespace Backend\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * AdminSearch represents the model behind the search form of `Backend\Models\Admin`.
 */
class AdminSearch extends Admin {

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

    return [
        [
            [
                'id',
                'status',
                'isSuper'
            ],
            'integer'
        ],
        [
            [
                'username',
                'nickname',
                'avatar',
                'email',
                'mobile',
                'loginAt',
                'loginFailure',
                'loginIp',
                'createdAt',
                'updatedAt'
            ],
            'safe'
        ]
    ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function scenarios() {

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
  public function search($params) {

    $query = Admin::find();
    // add conditions that should always apply here
    $dataProvider = new ActiveDataProvider( [
        'query' => $query,
        'sort' => [
            'defaultOrder' => [
                'createdAt' => SORT_ASC
            ]
        ]
    ] );
    $this->load( $params );
    if (! $this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }
    // grid filtering conditions
    $query->andFilterWhere( [
        'id' => $this->id,
        'status' => $this->status,
        'isSuper' => $this->isSuper
    ] );
    $query->andFilterWhere( [
        'DATE_RANGE',
        'loginAt',
        $this->loginAt
    ] )->andFilterWhere( [
        'DATE_RANGE',
        'createdAt',
        $this->createdAt
    ] )->andFilterWhere( [
        'DATE_RANGE',
        'updatedAt',
        $this->updatedAt
    ] );
    $query->andFilterWhere( [
        'like',
        'username',
        $this->username
    ] )->andFilterWhere( [
        'like',
        'nickname',
        $this->nickname
    ] )->andFilterWhere( [
        'like',
        'avatar',
        $this->avatar
    ] )->andFilterWhere( [
        'like',
        'email',
        $this->email
    ] )->andFilterWhere( [
        'like',
        'mobile',
        $this->mobile
    ] )->andFilterWhere( [
        'like',
        'loginFailure',
        $this->loginFailure
    ] )->andFilterWhere( [
        'like',
        'loginIp',
        $this->loginIp
    ] );
    if ($full_search = Yii::$app->request->get( 'full_search' )) {
      $query->andFilterWhere( [
          'FULL_SEARCH',
          [
              'username',
              'nickname',
              'avatar',
              'email',
              'mobile'
          ],
          $full_search
      ] );
    }
    return $dataProvider;

  }
}
