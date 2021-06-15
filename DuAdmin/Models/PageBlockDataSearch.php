<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;
use DuAdmin\Models\PageBlockData;

/**
 * PageBlockDataSearch represents the model behind the search form of `DuAdmin\Models\PageBlockData`.
 */
class PageBlockDataSearch extends PageBlockData
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'blockId', 'isOuterUrl', 'size', 'enableCache', 'sort'], 'integer'],
            [['title', 'intro', 'url', 'urlText', 'filter', 'orderBy', 'style', 'options', 'expiredAt'], 'safe'],
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
     * @param string|NULL $formName
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = NULL)
    {
        $query = PageBlockData::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
		    'sort' => [
               'defaultOrder' => [
                   'sort' => SORT_DESC               ]
            ]
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'blockId' => $this->blockId,
            'isOuterUrl' => $this->isOuterUrl,
            'size' => $this->size,
            'enableCache' => $this->enableCache,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['DATE_RANGE','expiredAt',$this->expiredAt]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'urlText', $this->urlText])
            ->andFilterWhere(['like', 'filter', $this->filter])
            ->andFilterWhere(['like', 'orderBy', $this->orderBy])
            ->andFilterWhere(['like', 'style', $this->style])
            ->andFilterWhere(['like', 'options', $this->options]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['title','intro','url','urlText','filter','orderBy','style','options'],$full_search]);
        }

        return $dataProvider;
    }
}
