<?php
namespace Addons\Cms\Widgets;

use DuAdmin\Widgets\BasePageBlock;
use Addons\Cms\Models\Post;
use Addons\Cms\Assets\CmsAsset;

class NewestPostsBlock extends BasePageBlock
{

    public function initQuery()
    {
        $this->query = Post::find()->where(['isPublished'=>1]);

        
    }

    public function renderPageBlock()
    {
        CmsAsset::register($this->view);
        $posts = $this->query->all();
        if ($posts) {
            return $this->render('newest-posts', [
                'models' => $posts,
                'block' => $this->model,
            ]);
        }
        return null;
    }
}

