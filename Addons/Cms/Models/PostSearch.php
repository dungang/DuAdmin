<?php

namespace Addons\Cms\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form of `Addons\Cms\Models\Post`.
 */
class PostSearch extends Post {

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

    return [
        [
            [
                'id',
                'userId',
                'cateId',
                'isPublished',
                'viewTimes'
            ],
            'integer'
        ],
        [
            [
                'createdAt',
                'updatedAt',
                'title',
                'cover',
                'keywords',
                'description',
                'content'
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

    $query = Post::find();
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
        'id' => $this->id,
        'userId' => $this->userId,
        'cateId' => $this->cateId,
        'isPublished' => $this->isPublished
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
        'title',
        $this->title
    ] )->andFilterWhere( [
        'like',
        'keywords',
        $this->keywords
    ] )->andFilterWhere( [
        'like',
        'description',
        $this->description
    ] )->andFilterWhere( [
        'like',
        'content',
        $this->content
    ] );
    if ( $full_search = Yii::$app->request->get( 'full_search' ) ) {
      $query->andFilterWhere( [
          'FULL_SEARCH',
          [
              'title',
              'keywords',
              'description',
              'content'
          ],
          $full_search
      ] );
    }
    return $dataProvider;

  }
}
