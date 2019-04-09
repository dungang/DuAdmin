<?php
namespace app\kit\core;

use yii\web\AssetManager;
use app\kit\models\Asset;
use yii\helpers\ArrayHelper;

/**
 *
 * @author dungang
 */
class CoreAssetManager extends AssetManager
{

    public function init()
    {
        parent::init();
        if ($bundles = Asset::getActiveAssets()) {
            $this->bundles = ArrayHelper::merge($this->bundles, $bundles);
        }
    }
}

