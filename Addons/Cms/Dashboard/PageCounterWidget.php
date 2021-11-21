<?php

namespace Addons\Cms\Dashboard;

use yii\base\Widget;
use Addons\Cms\Models\Page;

class PageCounterWidget extends Widget
{

    public function run()
    {
        $count = Page::find()->count();
        return $this->render('page-counter', [
            'count' => $count
        ]);
    }
}
