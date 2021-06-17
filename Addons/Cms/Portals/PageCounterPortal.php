<?php
namespace Addons\Cms\Portals;

use yii\base\Widget;
use Addons\Cms\Models\Page;

class PageCounterPortal extends Widget
{

    public function run()
    {
        $count = Page::find()->count();
        return $this->render('page-counter', [
            'count' => $count
        ]);
    }
}