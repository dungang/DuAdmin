<?php

namespace Addons\Cms\Hooks;

use Addons\Cms\Assets\LiveEditorCssAsset;
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
      $this->detechLiveEditor();
      $view = '@Addons/Cms/Views/Frontend/page/' . $page->template;
      $hook->payload = Yii::$app->controller->render( $view, [
          'model' => $page
      ] );
      $hook->stop = true;
    }

  }

  public function detechLiveEditor(){
    if (Yii::$app->request->isGet && !Yii::$app->request->isAjax) {
      if(Yii::$app->request->get('live') == 1) {
        LiveEditorCssAsset::register(Yii::$app->view);
      }
    }
  }
}
