<?php
namespace app\kit\core;

use yii\web\AssetManager;
use app\kit\events\CustomerEvent;
use app\kit\models\EventHandler;

/**
 *
 * @author dungang
 */
class CoreAssetManager extends AssetManager {

    const EVENT_BEORE_GET_BUNDLE = 'beforeGetBundle';

    private static $__assets;

    public function init()
    {
        parent::init();
        EventHandler::registerLevel($this,'AssetManager');
    }

    public function getBundle($name, $publish = true) {
        $this->beforeGetBundle();
        if (self::$__assets) {
            //加载功能的资源
            $common = isset(self::$__assets['common']) ? self::$__assets['common'] : [];
            $bundles = [];
            $module_id = \Yii::$app->controller->module->id;
            //如果是后台的请求，则加载后台的公共资源
            if (\Yii::$app->controller instanceof BackendController) {
                $bundles = isset(self::$__assets['backend']) ? self::$__assets['backend'] : [];
            } else {
                //否则就是前端请求，则加载前端的公共资源
                if (!empty(self::$__assets['frontend'])) {
                    $bundles = self::$__assets['frontend'];
                }
                //如果前端有针对插件模块有特殊的资源，则加载
                if (isset(self::$__assets[$module_id])) {
                    $bundles = \array_merge($bundles, self::$__assets[$module_id]);
                }
            }
            $this->bundles = array_merge($this->bundles, $common, $bundles);
        }
        return parent::getBundle($name, $publish);
    }

    public function beforeGetBundle(){
        $event = new CustomerEvent();
        $this->trigger(self::EVENT_BEORE_GET_BUNDLE,$event);
        self::$__assets = $event->payload;
    }

}
