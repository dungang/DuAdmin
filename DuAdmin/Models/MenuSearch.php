<?php

namespace DuAdmin\Models;

use Yii;
use yii\data\ActiveDataProvider;
use DuAdmin\Models\Menu;

/**
 * MenuSearch represents the model behind the search form of `DuAdmin\Models\Menu`.
 */
class MenuSearch extends Menu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'isFront', 'isOuter', 'requireAuth', 'sort'], 'integer'],
            [['name', 'url', 'icon', 'app'], 'safe'],
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
        $query = Menu::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
		    'sort' => [
               'defaultOrder' => [
                   'name' => SORT_DESC               ]
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
            'pid' => $this->pid,
            'isFront' => $this->isFront,
            'isOuter' => $this->isOuter,
            'requireAuth' => $this->requireAuth,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'app', $this->app]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere(['FULL_SEARCH',['name','url','icon','app'],$full_search]);
        }

        return $dataProvider;
    }
}
