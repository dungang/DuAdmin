<?php

namespace Addons\Cms\Models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FlashSearch represents the model behind the search form of `app\Addons\flash\models\FeFlash`.
 */
class FlashSearch extends Flash {

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

    return [
        [
            [
                'id',
                'sort',
                'createdAt',
                'updatedAt'
            ],
            'integer'
        ],
        [
            [
                'language',
                'name',
                'pic',
                'bgColor',
                'url'
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
    return Model::scenarios();

  }

  /**
   * Creates data provider instance with search query applied
   *
   * @param array $params
   *
   * @return ActiveDataProvider
   */
  public function search( $params ) {

    $query = Flash::find();
    // add conditions that should always apply here
    $dataProvider = new ActiveDataProvider( [
        'query' => $query
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
        'sort' => $this->sort
    ] );
    $query->andFilterWhere( [
        'like',
        'name',
        $this->name
    ] )->andFilterWhere( [
        'like',
        'pic',
        $this->pic
    ] )->andFilterWhere( [
        'like',
        'bgColor',
        $this->bgColor
    ] )->andFilterWhere( [
        'like',
        'url',
        $this->url
    ] );
    return $dataProvider;

  }
}
