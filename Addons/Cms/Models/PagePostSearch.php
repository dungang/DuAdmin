<?php

namespace Addons\Cms\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * PagePostSearch represents the model behind the search form of `Addons\Cms\Models\PagePost`.
 */
class PagePostSearch extends PagePost {

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

    return [
        [
            [
                'pageId'
            ],
            'integer'
        ],
        [
            [
                'language',
                'title',
                'content',
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
  public function search( $params ) {

    $query = PagePost::find();
    // add conditions that should always apply here
    $dataProvider = new ActiveDataProvider( [
        'query' => $query,
        'sort' => [
            'defaultOrder' => [
                'createdAt' => SORT_DESC
            ]
        ]
    ] );
    $this->load( $params );
    if ( ! $this->validate() ) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }
    // grid filtering conditions
    $query->andFilterWhere( [
        'pageId' => $this->pageId
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
        'language',
        $this->language
    ] )->andFilterWhere( [
        'like',
        'title',
        $this->title
    ] )->andFilterWhere( [
        'like',
        'content',
        $this->content
    ] );
    if ( $full_search = Yii::$app->request->get( 'full_search' ) ) {
      $query->andFilterWhere( [
          'FULL_SEARCH',
          [
              'language',
              'title',
              'content'
          ],
          $full_search
      ] );
    }
    return $dataProvider;

  }
}
