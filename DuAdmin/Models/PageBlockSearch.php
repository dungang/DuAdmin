<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;
use DuAdmin\Models\PageBlock;

/**
 * PageBlockSearch represents the model behind the search form of `DuAdmin\Models\PageBlock`.
 */
class PageBlockSearch extends PageBlock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'widget', 'sourceApp', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = PageBlock::find();

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
        ]);

        $query->andFilterWhere(['DATE_RANGE','createdAt',$this->createdAt])
            ->andFilterWhere(['DATE_RANGE','updatedAt',$this->updatedAt]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'widget', $this->widget])
            ->andFilterWhere(['like', 'sourceApp', $this->sourceApp]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['name','widget','sourceApp'],$full_search]);
        }

        return $dataProvider;
    }
}
