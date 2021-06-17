<?php

namespace Addons\Cms\Widgets;

use Addons\Cms\Models\FriendLink;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\DefaultPageFooter;

class CmsPageFooter extends DefaultPageFooter
{

    public function run()
    {
        $models = FriendLink::find()->asArray()->all();
        $tree = AppHelper::listToTree($models);
        return $this->render('page-footer', [
            'tree' => $tree
        ]);
    }
}