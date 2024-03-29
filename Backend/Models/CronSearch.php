<?php

namespace Backend\Models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use DuAdmin\Models\Cron;

/**
 * CronSearch represents the model behind the search form of `Backend\Models\Cron`.
 */
class CronSearch extends Cron
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id' ], 'integer'],
            [['task', 'mhdmd','app', 'jobScript', 'param', 'intro', 'token','runAt','createdAt', 'updatedAt'], 'safe'],
            [['isOk', 'isActive'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = Cron::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'isOk' => $this->isOk,
            'isActive' => $this->isActive,
            'runAt' => $this->runAt,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'task', $this->task])
            ->andFilterWhere(['like', 'mhdmd', $this->mhdmd])
            ->andFilterWhere(['like', 'app', $this->app])
            ->andFilterWhere(['like', 'jobScript', $this->jobScript])
            ->andFilterWhere(['like', 'param', $this->param])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
