<?php

namespace Addons\Cms\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * FriendLinkSearch represents the model behind the search form of `Addons\Cms\Models\FriendLink`.
 */
class FriendLinkSearch extends FriendLink {

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

    return [
        [
            [
                'id',
                'pid',
                'sort'
            ],
            'integer'
        ],
        [
            [
                'name',
                'url',
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
   * @param string|NULL $formName
   *
   * @return ActiveDataProvider
   */
  public function search( $params, $formName = NULL ) {

    $query = FriendLink::find();
    // add conditions that should always apply here
    $dataProvider = new ActiveDataProvider( [
        'query' => $query,
        'sort' => [
            'defaultOrder' => [
                'sort' => SORT_ASC
            ]
        ]
    ] );
    $this->load( $params, $formName );
    if ( ! $this->validate() ) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }
    // grid filtering conditions
    $query->andFilterWhere( [
        'id' => $this->id,
        'pid' => $this->pid,
        'sort' => $this->sort
    ] );
    $query->andFilterWhere( [
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
        'name',
        $this->name
    ] )->andFilterWhere( [
        'like',
        'url',
        $this->url
    ] );
    if ( $full_search = Yii::$app->request->get( 'full_search' ) ) {
      $query->andFilterWhere( [
          'FULL_SEARCH',
          [
              'name',
              'url'
          ],
          $full_search
      ] );
    }
    return $dataProvider;

  }
}
