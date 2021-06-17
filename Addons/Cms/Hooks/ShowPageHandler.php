<?php

namespace Addons\Cms\Hooks;

use Addons\Cms\Models\Page;
use DuAdmin\Hooks\Handler;
use Yii;

/**
 * 查找slug的page的内容事件处理器
 */
class ShowPageHandler extends Handler {

  /**
   * SlugHook
   *
   * @param \DuAdmin\Hooks\FindSlugHook $hook
   * @return void
   */
  public function process( $hook ) {

    if ( $page = Page::find()->where( [
        'slug' => $hook->slug
    ] )->limit( 1 )->one() ) {
      $view = '@Addons/Cms/Views/Frontend/page/page';
      $hook->payload = Yii::$app->controller->render( $view, [
          'model' => $page
      ] );
      $hook->stop = true;
    }

  }
}
