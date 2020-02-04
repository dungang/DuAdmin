<?php
namespace app\kit\core;

use yii\web\AssetManager;
use app\kit\events\CustomerEvent;
use app\kit\models\EventHandler;

/**
 * 增强资源文件的加载
 *
 * @author dungang
 */
class CoreAssetManager extends AssetManager
{

    /**
     * 定义事件名称
     * 在获取资源包之前
     *
     * @var string
     */
    const EVENT_BEORE_GET_BUNDLE = 'beforeGetBundle';

    /**
     * 记录加载的资源包
     *
     * @var array
     */
    private static $__assets;

    public function init()
    {
        parent::init();
        // 注册需要处理的事件级别或者类型
        // 请查看Event模型表
        EventHandler::registerLevel($this, 'AssetManager');
    }

    /**
     * 获取具体的资源
     * {@inheritDoc}
     * @see \yii\web\AssetManager::getBundle()
     */
    public function getBundle($name, $publish = true)
    {

        // 触发获取价值资源包事件
        $this->beforeGetBundle();
        if (self::$__assets) {
            // 加载功能的资源
            $common = isset(self::$__assets['common']) ? self::$__assets['common'] : [];
            $bundles = [];
            $module_id = \Yii::$app->controller->module->id;
            // 如果是后台的请求，则加载后台的公共资源
            if (\Yii::$app->controller instanceof BackendController) {
                $bundles = isset(self::$__assets['backend']) ? self::$__assets['backend'] : [];
            } else {
                // 否则就是前端请求，则加载前端的公共资源
                if (! empty(self::$__assets['frontend'])) {
                    $bundles = self::$__assets['frontend'];
                }
                // 如果前端有针对插件模块有特殊的资源，则加载
                if (isset(self::$__assets[$module_id])) {
                    $bundles = \array_merge($bundles, self::$__assets[$module_id]);
                }
            }
            $this->bundles = array_merge($this->bundles, $common, $bundles);
        }
        //print_r(self::$__assets);die;
        return parent::getBundle($name, $publish);
    }

    public function beforeGetBundle()
    {
        $event = new CustomerEvent();
        $this->trigger(self::EVENT_BEORE_GET_BUNDLE, $event);
        //var_dump($event);die;
        self::$__assets = $event->payload;
    }
}
