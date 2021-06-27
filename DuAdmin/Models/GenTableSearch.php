<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;
use DuAdmin\Models\GenTable;

/**
 * GenTableSearch represents the model behind the search form of `DuAdmin\Models\GenTable`.
 */
class GenTableSearch extends GenTable
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'enableSearchModel', 'enableI18n', 'enableUserData', 'enablePjax'], 'integer'],
            [['tableName', 'tableComment', 'modelNamespace', 'modelName', 'modelBaseName', 'activeQueryBaseName', 'dbConnectionId', 'backendControllerNamespace', 'frontendControllerNamespace', 'apiControllerNamespace', 'backendControllerBase', 'frontendControllerBase', 'apiControllerBase', 'controllerName', 'backendViewPath', 'frontendViewPath', 'backendListView', 'frontendistView', 'backendActions', 'frontendActions', 'modalDailogSize', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = GenTable::find();

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
            'enableSearchModel' => $this->enableSearchModel,
            'enableI18n' => $this->enableI18n,
            'enableUserData' => $this->enableUserData,
            'enablePjax' => $this->enablePjax,
        ]);

        $query->andFilterWhere(['DATE_RANGE','createdAt',$this->createdAt])
            ->andFilterWhere(['DATE_RANGE','updatedAt',$this->updatedAt]);

        $query->andFilterWhere(['like', 'tableName', $this->tableName])
            ->andFilterWhere(['like', 'tableComment', $this->tableComment])
            ->andFilterWhere(['like', 'modelNamespace', $this->modelNamespace])
            ->andFilterWhere(['like', 'modelName', $this->modelName])
            ->andFilterWhere(['like', 'modelBaseName', $this->modelBaseName])
            ->andFilterWhere(['like', 'activeQueryBaseName', $this->activeQueryBaseName])
            ->andFilterWhere(['like', 'dbConnectionId', $this->dbConnectionId])
            ->andFilterWhere(['like', 'backendControllerNamespace', $this->backendControllerNamespace])
            ->andFilterWhere(['like', 'frontendControllerNamespace', $this->frontendControllerNamespace])
            ->andFilterWhere(['like', 'apiControllerNamespace', $this->apiControllerNamespace])
            ->andFilterWhere(['like', 'backendControllerBase', $this->backendControllerBase])
            ->andFilterWhere(['like', 'frontendControllerBase', $this->frontendControllerBase])
            ->andFilterWhere(['like', 'apiControllerBase', $this->apiControllerBase])
            ->andFilterWhere(['like', 'controllerName', $this->controllerName])
            ->andFilterWhere(['like', 'backendViewPath', $this->backendViewPath])
            ->andFilterWhere(['like', 'frontendViewPath', $this->frontendViewPath])
            ->andFilterWhere(['like', 'backendListView', $this->backendListView])
            ->andFilterWhere(['like', 'frontendistView', $this->frontendistView])
            ->andFilterWhere(['like', 'backendActions', $this->backendActions])
            ->andFilterWhere(['like', 'frontendActions', $this->frontendActions])
            ->andFilterWhere(['like', 'modalDailogSize', $this->modalDailogSize]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['tableName','tableComment','modelNamespace','modelName','modelBaseName','activeQueryBaseName','dbConnectionId','backendControllerNamespace','frontendControllerNamespace','apiControllerNamespace','backendControllerBase','frontendControllerBase','apiControllerBase','controllerName','backendViewPath','frontendViewPath','backendListView','frontendistView','backendActions','frontendActions','modalDailogSize'],$full_search]);
        }

        return $dataProvider;
    }
}
