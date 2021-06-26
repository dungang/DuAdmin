<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;
use DuAdmin\Models\DictData;

/**
 * DictDataSearch represents the model behind the search form of `DuAdmin\Models\DictData`.
 */
class DictDataSearch extends DictData
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isDefault', 'sort', 'status'], 'integer'],
            [['dictLabel', 'dictValue', 'dictType', 'listCss', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = DictData::find();

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
            'isDefault' => $this->isDefault,
            'sort' => $this->sort,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['DATE_RANGE','createdAt',$this->createdAt])
            ->andFilterWhere(['DATE_RANGE','updatedAt',$this->updatedAt]);

        $query->andFilterWhere(['like', 'dictLabel', $this->dictLabel])
            ->andFilterWhere(['like', 'dictValue', $this->dictValue])
            ->andFilterWhere(['like', 'dictType', $this->dictType])
            ->andFilterWhere(['like', 'listCss', $this->listCss]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['dictLabel','dictValue','dictType','listCss'],$full_search]);
        }

        return $dataProvider;
    }
}
