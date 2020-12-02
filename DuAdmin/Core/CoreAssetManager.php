<?php
namespace DuAdmin\Core;

use yii\web\AssetManager;
use DuAdmin\Hooks\AssetManagerInitedHook;
use Yii;

/**
 * 增强资源文件的加载
 *
 * @author dungang
 */
class CoreAssetManager extends AssetManager
{

    /**
     * 记录加载的资源包
     *
     * @var array
     */
    private static $__assets;

    public function init()
    {
        parent::init();
        AssetManagerInitedHook::emit($this,['payload'=>$this]);
    }

    public function updateAssets($assets){
        self::$__assets = $assets;
    }

    /**
     * 获取具体的资源,生成资源替代的映射表
     * {@inheritDoc}
     * @see \yii\web\AssetManager::getBundle()
     */
    public function getBundle($name, $publish = true)
    {
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
        Yii::trace(static::$__assets,__CLASS__);
        return parent::getBundle($name, $publish);
    }
}
