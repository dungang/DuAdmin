<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * NavigationSearch represents the model behind the search form of `DuAdmin\Models\Navigation`.
 */
class NavigationSearch extends Navigation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'isOuter', 'requireAuth', 'sort'], 'integer'],
            [['name', 'intro', 'url', 'icon', 'app'], 'safe'],
        ];
    }

    /**
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
    public function search( $params, $formName = Null )
    {
        $query = Navigation::find();

        // add conditions that should always apply here

        // search before event
        $this->beforeSearch( $query, $params );

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
            'id'           => $this->id,
            'pid'          => $this->pid,
            'isOuter'      => $this->isOuter,
            'requireAuth' => $this->requireAuth,
            'sort'         => $this->sort,
        ] );

        $query->andFilterWhere( ['like', 'name', $this->name] )
            ->andFilterWhere( ['like', 'intro', $this->intro] )
            ->andFilterWhere( ['like', 'url', $this->url] )
            ->andFilterWhere( ['like', 'icon', $this->icon] )
            ->andFilterWhere( ['like', 'app', $this->app] );

        if ( $full_search = Yii::$app->request->get( 'full_search' ) ) {
            $query->andFilterWhere( ['FULL_SEARCH', ['name', 'intro', 'url', 'icon', 'app'], $full_search] );
        }

        return $dataProvider;
    }
}
