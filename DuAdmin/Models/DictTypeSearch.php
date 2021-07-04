<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;
use DuAdmin\Models\DictType;

/**
 * DictTypeSearch represents the model behind the search form of `DuAdmin\Models\DictType`.
 */
class DictTypeSearch extends DictType {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [ [ 'id', 'status' ], 'integer' ],
            [ [ 'dictName', 'dictType', 'createdAt', 'updatedAt' ], 'safe' ],
        ];
    }

    /**
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
        $query = DictType::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider( [
            'query' => $query,
        ] );

        $this->load( $params, $formName );

        if ( !$this->validate() ) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere( [
            'id'     => $this->id,
            'status' => $this->status,
        ] );

        $query->andFilterWhere( [ 'DATE_RANGE', 'createdAt', $this->createdAt ] )
            ->andFilterWhere( [ 'DATE_RANGE', 'updatedAt', $this->updatedAt ] );

        $query->andFilterWhere( [ 'like', 'dictName', $this->dictName ] )
            ->andFilterWhere( [ 'like', 'dictType', $this->dictType ] );

        if ( $full_search = Yii::$app->request->get( 'full_search' ) ) {
            $query->andFilterWhere( [ 'FULL_SEARCH', [ 'dictName', 'dictType' ],
                $full_search ] );
        }

        return $dataProvider;
    }

}
