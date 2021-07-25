<?php

namespace Addons\Cms\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * PageSearch represents the model behind the search form of `Addons\Cms\Models\Page`.
 */
class PageSearch extends Page
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
                    'pid',
                    'sort',
                    'isLive'
                ],
                'integer'
            ],
            [
                [
                    'slug',
                    'title',
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
    public function search( $params )
    {

        $query = Page::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider( [
            'query' => $query,
            'sort'  => [
                'defaultOrder' => [
                    'sort' => SORT_ASC
                ]
            ]
        ] );
        $this->load( $params );
        if ( !$this->validate() ) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere( [
            'id'     => $this->id,
            'pid'    => $this->pid,
            'sort'   => $this->sort,
            'isLive' => $this->isLive
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
            'slug',
            $this->slug
        ] )->andFilterWhere( [
            'like',
            'title',
            $this->title
        ] );
        if ( $full_search = Yii::$app->request->get( 'full_search' ) ) {
            $query->andFilterWhere( [
                'FULL_SEARCH',
                [
                    'slug',
                    'title'
                ],
                $full_search
            ] );
        }
        return $dataProvider;

    }
}
