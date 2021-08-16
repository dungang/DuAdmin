<?php

namespace Addons\Cms\Hooks;

use Addons\Cms\Assets\LiveEditorCssAsset;
use Addons\Cms\Models\Page;
use DuAdmin\Hooks\FindSlugHook;
use DuAdmin\Hooks\Handler;
use Yii;

/**
 * 查找slug的page的内容事件处理器
 */
class ShowPageHandler extends Handler {

  /**
   * SlugHook
   *
   * @param FindSlugHook $hook
   * @return void
   */
  public function process( $hook ) {

    if ( $page = Page::find()->where( [
        'slug' => $hook->slug
    ] )->limit( 1 )->one() ) {
      $this->detectLiveEditor();
      $view = '@Addons/Cms/Views/Frontend/page/empty';
      $hook->payload = Yii::$app->controller->render( $view, [
          'model' => $page
      ] );
      $hook->stop = true;
    }
  }

  public function detectLiveEditor(){
    if (Yii::$app->request->isGet && !Yii::$app->request->isAjax) {
      if(Yii::$app->request->get('live') == 1) {
        // 注册编辑器的特殊标签的样式
        LiveEditorCssAsset::register(Yii::$app->view);
        // 阻止页面的默认a标签页面挑战
        Yii::$app->view->registerJs('$("a").off("click").on("click",function(e){e.preventDefault()})');
      }
    }
  }
}
