<?php

namespace Addons\Cms\Dashboard;

use yii\base\Widget;
use Addons\Cms\Models\Post;

class PostCounterWidget extends Widget
{
    public function run()
    {
        $count = Post::find()->count();
        return $this->render('post-counter',[
            'count' => $count,
        ]);
    }
}