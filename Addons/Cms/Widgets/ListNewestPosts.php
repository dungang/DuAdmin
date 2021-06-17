<?php
namespace Addons\Cms\Widgets;

use yii\base\Widget;
use Addons\Cms\Models\Post;

/**
 * 显示最新的文章列表
 *
 * @author dunga
 *        
 */
class ListNewestPosts extends Widget
{

    public $size = 10;

    public function run()
    {
        $posts = Post::find()->where([
            'isPublished' => 1
        ])
            ->limit($this->size)
            ->orderBy('createdAt desc')
            ->all();
        return $this->render('list-newest-posts', [
            'models' => $posts
        ]);
    }
}

