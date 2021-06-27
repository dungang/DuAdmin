<?php

namespace DuAdmin\Widgets;

use DuAdmin\Helpers\AppHelper;
use yii\base\Widget;

class DefaultPageFooter extends Widget {

  public $viewName = 'page-footer';

  public function run() {

    return $this->render( $this->viewName );

  }

  public static function renderPageFooter( $setting = [ ] ) {

    $className = AppHelper::getSetting( 'site.pageFooterWidget' );
    $className = $className ?: DefaultPageFooter::class;
    return call_user_func( [
        $className,
        'widget'
    ], $setting );

  }
}