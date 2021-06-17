<?php
namespace Addons\Cms\Hooks;

use DuAdmin\Hooks\Handler;
use Yii;
use Addons\Cms\Models\Page;

/**
 * 查找slug的page的内容事件处理器
 */
class ShowPageHandler extends Handler
{

    /**
     * SlugHook
     *
     * @param \DuAdmin\Hooks\FindSlugHook $hook
     * @return void
     */
    public function process($hook)
    {
        if ($page = Page::find()->where([
            'slug' => $hook->slug
        ])
            ->limit(1)
            ->one()) {
            $view = '@Addons/Cms/resource/views/frontend/page/page';
            $hook->payload = Yii::$app->controller->render($view, [
                'model' => $page
            ]);
            $hook->stop = true;
        }
    }
}
