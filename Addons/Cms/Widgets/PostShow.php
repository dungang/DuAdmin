<?php

namespace Addons\Cms\Widgets;

use Addons\Cms\Models\Post;
use Addons\Cms\Models\Category;
use Yii;
use yii\base\Widget;

class PostShow extends Widget
{

    /**
     * 分类的slug
     */
    public $slug = 'news';

    /**
     * 显示数量
     */
    public $num = 5;

    /**
     * 渲染条目回调
     */
    public $render_callback;

    public function run()
    {
        $html = '';
        if ($cateogry = Category::findOne(['slug' => $this->slug])) {
            $articles  = Post::find()
                ->from(['a' => Post::tableName(), 'c' => Category::tableName()])
                ->where('a.cate_id=c.id')
                ->andWhere(['language'=>Yii::$app->language])
                ->andWhere(['or', ['c.id' => $cateogry->id], ['c.pid' => $cateogry->id]])
                ->orderBy('a.created_at desc')
                ->select('a.*')
                ->limit($this->num)->all();
            if ($articles) {
                foreach ($articles as $article) {
                    $html .= call_user_func($this->render_callback, $article);
                }
            }
        }
        return $html;
    }
}
