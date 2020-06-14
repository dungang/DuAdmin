<?php

namespace app\backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CronSearch represents the model behind the search form of `app\backend\models\Cron`.
 */
class CronSearch extends Cron
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'run_at', 'created_at', 'updated_at'], 'integer'],
            [['task', 'mhdmd', 'job_script', 'param', 'intro', 'token'], 'safe'],
            [['is_ok', 'is_active'], 'boolean'],
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
            'is_ok' => $this->is_ok,
            'is_active' => $this->is_active,
            'run_at' => $this->run_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'task', $this->task])
            ->andFilterWhere(['like', 'mhdmd', $this->mhdmd])
            ->andFilterWhere(['like', 'job_script', $this->job_script])
            ->andFilterWhere(['like', 'param', $this->param])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
