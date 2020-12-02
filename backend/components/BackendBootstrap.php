<?php
namespace app\backend\Components;

use yii\base\BootstrapInterface;
use DuAdmin\Core\Application;

/**
 *
 * @author dungang
 */
class BackendBootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app
     *            the application currently running
     * @throws \yii\base\InvalidConfigException
     * {@inheritdoc}
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function bootstrap($app)
    {
        \Yii::$app->assetManager->loadBundle('yii\bootstrap\BootstrapAsset',[
            'baseUrl' => '@web',
            'css' => [
                'css/bootstrap.min.css',
            ],
            'sourcePath' => null // 防止在 frontend/web/asset 下生产文件
        ]);
    }
}

