<?php

namespace Addons\Cms\Portals;

use yii\base\Widget;
use Addons\Cms\Models\Post;

class PostCounterPortal extends Widget
{
    public function run()
    {
        $count = Post::find()->count();
        return $this->render('post-counter',[
            'count' => $count,
        ]);
    }
}