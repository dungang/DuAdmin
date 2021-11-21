<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * DashboardWidgetSearch represents the model behind the search form of `DuAdmin\Models\DashboardWidget`.
 */
class DashboardWidgetSearch extends DashboardWidget
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'sort'], 'integer'],
            [['name', 'widget', 'args', 'argsInfo', 'type'], 'safe'],
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
    public function search($params = [], $formName = NULL)
    {
        $query = DashboardWidget::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
		    'sort' => [
               'defaultOrder' => [
                   'id' => SORT_ASC               ]
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
            'status' => $this->status,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'widget', $this->widget])
            ->andFilterWhere(['like', 'args', $this->args])
            ->andFilterWhere(['like', 'argsInfo', $this->argsInfo])
            ->andFilterWhere(['like', 'type', $this->type]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['name','widget','args','argsInfo','type'],$full_search]);
        }

        return $dataProvider;
    }
}
