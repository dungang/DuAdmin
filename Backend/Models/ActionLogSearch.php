<?php

namespace Backend\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * ActionLogSearch represents the model behind the search form of `Backend\Models\ActionLog`.
 */
class ActionLogSearch extends ActionLog {

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
                'ip'
            ],
            'integer'
        ],
        [
            [
                'action',
                'method',
                'sourceType',
                'createdAt',
                'data'
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
  public function search($params, $formName = NULL) {
    $query = ActionLog::find();

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider( [
        'query' => $query,
        'sort' => [
            'defaultOrder' => [
                'createdAt' => SORT_DESC
            ]
        ]
    ] );

    $this->load( $params, $formName );

    if (! $this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    // grid filtering conditions
    $query->andFilterWhere( [
        'id' => $this->id,
        'userId' => $this->userId,
        'ip' => $this->ip
    ] );

    $query->andFilterWhere( [
        'DATE_RANGE',
        'createdAt',
        $this->createdAt
    ] );

    $query->andFilterWhere( [
        'like',
        'action',
        $this->action
    ] )->andFilterWhere( [
        'like',
        'method',
        $this->method
    ] )->andFilterWhere( [
        'like',
        'sourceType',
        $this->sourceType
    ] )->andFilterWhere( [
        'like',
        'data',
        $this->data
    ] );

    if ($full_search = Yii::$app->request->get( 'full_search' )) {
      $query->andFilterWhere( [
          'FULL_SEARCH',
          [
              'action',
              'method',
              'sourceType',
              'data'
          ],
          $full_search
      ] );
    }

    return $dataProvider;
  }
}
