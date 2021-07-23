<?php

namespace Addons\Cms\Widgets;

use Addons\Cms\Models\FriendLink;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Widgets\DefaultPageFooter;
use yii\base\Widget;

/**
 * 友情链接
 *
 * @author dungang
 *
 */
class CmsPageFooter extends Widget
{

    public $viewName = 'page-footer';

    public function run()
    {

        $models = FriendLink::find()->asArray()->orderBy( 'sort' )->all();
        $tree = AppHelper::listToTree( $models );
        return $this->render( $this->viewName, [
            'tree' => $tree
        ] );

    }
}