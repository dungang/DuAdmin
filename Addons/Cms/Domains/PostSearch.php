<?php
namespace Addons\Cms\Domains;

use Addons\Cms\Models\Post;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form of `Addons\Cms\Models\Post`.
 */
class PostSearch extends Post
{

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'userId',
                    'isPublished',
                    'viewTimes'
                ],
                'integer'
            ],
            [
                [
                    'title',
                    'keywords',
                    'description',
                    'content',
                    'cateId', // 如果传递的参数是多个，数组，则不能使用整型
                ],
                'safe'
            ]
        ];
    }

    /**
     *
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        // add conditions that should always apply here

        // search before event
        $this->beforeSearch($query, $params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'createdAt' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params, '');

        if (! $this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'userId' => $this->userId,
            'cateId' => $this->cateId
        ]);

        if ($full_search = Yii::$app->request->get('full_search')) {
            $query->andFilterWhere([
                'FULL_SEARCH',
                [
                    'title',
                    'keywords',
                    'description',
                    'content'
                ],
                $full_search
            ]);
        }

        return $dataProvider;
    }
}
