<?php

namespace DuAdmin\Models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SettingSearch represents the model behind the search form of `Backend\Models\Setting`.
 */
class SettingSearch extends Setting {

    /**
     *
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [
                [
                    'name',
                    'title',
                    'value',
                    'hint',
                    'category',
                    'subCategory',
                    'valType'
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
        $query = Setting::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider( [
            'query' => $query
            ] );

        $this->load( $params );

        if ( !$this->validate() ) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere( [
            'category'    => $this->category,
            'subCategory' => $this->subCategory,
            'valType'     => $this->valType
        ] );

        // grid filtering conditions
        $query->andFilterWhere( [
                'like',
                'name',
                $this->name
            ] )
            ->andFilterWhere( [
                'like',
                'title',
                $this->title
            ] )
            ->andFilterWhere( [
                'like',
                'value',
                $this->value
            ] );

        return $dataProvider;
    }

}
