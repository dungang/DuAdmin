<?php
namespace app\kit\components;

use yii\base\BootstrapInterface;
use app\kit\models\Setting;
use yii\web\Application;
use app\kit\core\BackendController;

/**
 * 以后这里的配置从其他的外部配置读取
 *
 * @author dungang
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app
     *            the application currently running
     * {@inheritdoc}
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function bootstrap($app)
    {
        //读取插件脚本下的配置，修改网站默认的配置。
        $scriptDir = \Yii::getAlias('@webroot');
        if (\is_file($scriptDir . '/' . 'config.php')) {
            $config = require $scriptDir . '/' . 'config.php';
            foreach ($config as $attr => $val) {
                $app->{$attr} = $val;
            }
        }
        \Yii::setAlias('@webroot', '@app/public');
        //\Yii::setAlias('@web', '/baiyuan-yii2/public');
        $app->setHomeUrl([
            Setting::getSettings("site.index-page")
        ]);
        //固定后台的样式配置
        $app->on(Application::EVENT_BEFORE_ACTION,
            function ($event) use ($app) {
                if ($app->controller instanceof BackendController) {
                    $app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
                        'baseUrl' => '@web',
                        'css' => [
                            'css/bootstrap.min.css'
                        ],
                        'sourcePath' => null // 防止在 frontend/web/asset 下生产文件
                    ];
                }
            });
    }
}

