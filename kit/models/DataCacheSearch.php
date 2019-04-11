<?php

namespace app\kit\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\kit\models\DataCache;

/**
 * DataCacheSearch represents the model behind the search form of `app\kit\models\DataCache`.
 */
class DataCacheSearch extends DataCache
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'expired'], 'integer'],
            [['name', 'cache_key', 'cache_handler', 'intro'], 'safe'],
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
        $query = DataCache::find();

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
            'expired' => $this->expired,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cache_key', $this->cache_key])
            ->andFilterWhere(['like', 'cache_handler', $this->cache_handler])
            ->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
