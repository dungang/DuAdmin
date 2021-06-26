<?php

namespace Addons\Cms\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * AdvBlockSearch represents the model behind the search form of `Addons\Cms\Models\AdvBlock`.
 */
class AdvBlockSearch extends AdvBlock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isFlat'], 'integer'],
            [['name', 'nameCode', 'urlPath', 'pic', 'type', 'url', 'content', 'startedAt', 'endAt', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = AdvBlock::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
		    'sort' => [
               'defaultOrder' => [
                   'createdAt' => SORT_DESC               ]
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
            'isFlat' => $this->isFlat,
        ]);

        $query->andFilterWhere(['DATE_RANGE','startedAt',$this->startedAt])
            ->andFilterWhere(['DATE_RANGE','endAt',$this->endAt])
            ->andFilterWhere(['DATE_RANGE','createdAt',$this->createdAt])
            ->andFilterWhere(['DATE_RANGE','updatedAt',$this->updatedAt]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nameCode', $this->nameCode])
            ->andFilterWhere(['like', 'urlPath', $this->urlPath])
            ->andFilterWhere(['like', 'pic', $this->pic])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'content', $this->content]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['name','nameCode','urlPath','pic','type','url','content'],$full_search]);
        }

        return $dataProvider;
    }
}
