<?php
namespace app\kit\eventhandlers;

use app\kit\helpers\KitHelper;
use abei2017\wx\Application;
use yii\web\View;
use app\kit\core\FrontendController;
use abei2017\wx\mp\js\Js;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 *
 * @author dungang
 */
class WechatJsShareHandler extends EventHandler
{

    public $apis = [
        'updateTimelineShareData',
        'updateAppMessageShareData'
    ];

    /**
     * (non-PHPdoc)
     *
     * @see \app\kit\eventhandlers\EventHandler::process()
     */
    public function process($event)
    {
        if (\Yii::$app->controller instanceof FrontendController) {

            if ($mp = KitHelper::getSettingAssoc('wechat.mp')) {
                $wechat = new Application([
                    'conf' => $mp,
                    'httpConf' => [
                        'transport' => 'yii\httpclient\CurlTransport',
                        'requestConfig' => [
                            'options' => [
                                'SSL_VERIFYPEER' => false
                            ]
                        ]
                    ]
                ]);
                $driver = $wechat->driver('mp.js');
                $this->registerAsset($driver);
            }
        }
    }

    /**
     * 注册视图的资源
     *
     * @param Js $driver
     */
    protected function registerAsset($driver)
    {
        /* @var $view View */
        $view = \Yii::$app->view;
        $view->registerJsFile('http://res.wx.qq.com/open/js/jweixin-1.4.0.js', [
            'position' => View::POS_HEAD
        ]);
        $config = $driver->buildConfig($this->apis, false);
        $view->registerJs("wx.config({$config})", View::POS_HEAD);
        $data = [

            'title' => $view->title,
            'desc' => $view->title,
            'link' => \Yii::$app->request->absoluteUrl,
            'imgUrl' => KitHelper::getSetting('wechat.mp.img')
        ];
        if ($desc = $this->getDescFromMeta($view)) {
            $data['desc'] = $desc;
        }
        //         if ($img = $this->getFirstImage($event->output)) {
        //             $data['imgUrl'] = $img;
        //         }
        $view->registerJs($this->composeWxReady($data), View::POS_HEAD);
    }

    /**
     *
     * @param View $view
     * @return mixed
     */
    protected function getDescFromMeta($view)
    {
        foreach ($view->metaTags as $meta) {
            if (\preg_match('#name="description"#', $meta)) {
                $match = [];
                if (\preg_match('#content="(.*?)"#', $meta, $match)) {
                    return $match[1];
                }
            }
        }
        return null;
    }

    protected function getFirstImage($content)
    {
        $match = [];
        if (\preg_match('#src="(.*？)"#', $content, $match)) {
            $url = $match[1];
            if (\substr($url, 0, 5) == 'http') {
                return $url;
            }
            return Url::to($url, true);
        }
        return null;
    }

    protected function composeWxReady($data)
    {
        return new JsExpression(
            "
wx.ready(function () {
    var shareData = {
        title: '{$data['title']}',
        desc: '{$data['desc']}',
        link: '{$data['link']}',
        imgUrl: '{$data['imgUrl']}',
        success: function(){ alert(123);}
    };

    wx.updateTimelineShareData(shareData);//分享给好友
    wx.updateAppMessageShareData(shareData);//分享到朋友圈

});
wx.error(function (res) {
    alert(res.errMsg);//错误提示

});
");
    }
}

