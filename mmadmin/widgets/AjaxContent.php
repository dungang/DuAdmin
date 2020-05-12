<?php
namespace app\mmadmin\widgets;

use Yii;
use yii\base\Widget;
use yii\web\Response;

/**
 * 当Ajax的时候只输出包含的内容
 */
class AjaxContent extends Widget
{
    public function init()
    {
        parent::init();

        if (Yii::$app->request->isAjax) {
            ob_start();
            ob_implicit_flush(false);
            $view = $this->getView();
            $view->clear();
            $view->beginPage();
            $view->head();
            $view->beginBody();
        }
    }
    public function run()
    {
        if (Yii::$app->request->isAjax) {
            $view = $this->getView();
            $view->endBody();
            $view->endPage(true);

            
            $content = ob_get_clean();

            // only need the content enclosed within this widget
            $response = Yii::$app->getResponse();
            $response->clearOutputBuffers();
            $response->setStatusCode(200);
            $response->format = Response::FORMAT_HTML;
            $response->content = $content;
            $response->headers->setDefault('X-Pjax-Url', Yii::$app->request->url);
            $response->send();
            Yii::$app->end();
        }
    }
}
