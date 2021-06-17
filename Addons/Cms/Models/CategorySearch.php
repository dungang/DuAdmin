<?php

namespace Addons\Cms\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * CategorySearch represents the model behind the search form of `Addons\Cms\Models\Category`.
 */
class CategorySearch extends Category {

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
                'slug',
                'name',
                'template',
                'intro'
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

    $query = Category::find();
    // add conditions that should always apply here
    $dataProvider = new ActiveDataProvider( [
        'query' => $query,
        'sort' => [
            'defaultOrder' => [
                'sort' => SORT_DESC
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
        'pid' => $this->pid,
        'sort' => $this->sort
    ] );
    $query->andFilterWhere( [
        'like',
        'slug',
        $this->slug
    ] )->andFilterWhere( [
        'like',
        'name',
        $this->name
    ] )->andFilterWhere( [
        'like',
        'template',
        $this->template
    ] )->andFilterWhere( [
        'like',
        'intro',
        $this->intro
    ] );
    if ( $full_search = Yii::$app->request->get( 'full_search' ) ) {
      $query->andFilterWhere( [
          'FULL_SEARCH',
          [
              'slug',
              'name',
              'template',
              'intro'
          ],
          $full_search
      ] );
    }
    return $dataProvider;

  }
}
