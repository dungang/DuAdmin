<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;
use DuAdmin\Models\GenTableColumn;

/**
 * GenTableColumnSearch represents the model behind the search form of `DuAdmin\Models\GenTableColumn`.
 */
class GenTableColumnSearch extends GenTableColumn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tableId', 'enableRequired', 'enableList', 'enableQuery', 'enableSearch', 'sort'], 'integer'],
            [['field', 'comment', 'tips', 'sortable', 'widgetType', 'dictType', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = GenTableColumn::find();

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
            'tableId' => $this->tableId,
            'enableRequired' => $this->enableRequired,
            'enableList' => $this->enableList,
            'enableQuery' => $this->enableQuery,
            'enableSearch' => $this->enableSearch,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['DATE_RANGE','createdAt',$this->createdAt])
            ->andFilterWhere(['DATE_RANGE','updatedAt',$this->updatedAt]);

        $query->andFilterWhere(['like', 'field', $this->field])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'tips', $this->tips])
            ->andFilterWhere(['like', 'sortable', $this->sortable])
            ->andFilterWhere(['like', 'widgetType', $this->widgetType])
            ->andFilterWhere(['like', 'dictType', $this->dictType]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['field','comment','tips','sortable','widgetType','dictType'],$full_search]);
        }

        return $dataProvider;
    }
}
