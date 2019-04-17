<?php
namespace app\kit\core;

use yii\web\AssetManager;
use app\kit\models\Asset;

/**
 *
 * @author dungang
 */
class CoreAssetManager extends AssetManager
{

    private static $__assets;

    public function getBundle($name, $publish = true)
    {
        if (empty(self::$__assets) && (self::$__assets = Asset::getActiveAssets())) {
            $common = isset(self::$__assets['common']) ? self::$__assets['common'] : [];

            $bundles = [];
            $module_id = \Yii::$app->controller->module->id;
            if (\Yii::$app->controller instanceof BackendController && isset(self::$__assets['backend'])) {
                $bundles = self::$__assets['backend'];
            } else if (isset(self::$__assets[$module_id])) {
                $bundles = self::$__assets[$module_id];
            }
            //print_r($bundles);die;
            $this->bundles = array_merge($this->bundles, $common, $bundles);
        }
        return parent::getBundle($name, $publish);
    }
}

