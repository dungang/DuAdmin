<?php

namespace Addons\Cms\Widgets\views;

use Addons\Cms\Models\Page;
use yii\base\Widget;

/**
 * 读取一篇单页
 *
 * @author admin
 *
 */
class PageContentWiget extends Widget {

    public $slug = 'about-us';
    public $viewName = '';

    public function run() {

        $page = Page::findOne( [
                    'slug' => $this->slug
                ] );
        return $this->render( $this->viewName, [
                    'page' => $page,
                    'slug' => $this->slug
                ] );
    }

}
