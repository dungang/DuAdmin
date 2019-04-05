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
        $this->whenAddonToAppReset($app);

        $this->dynamicRegistAddons($app);

        $this->dynamicSetSiteHome($app);

        $this->initBackendPageInitAssets($app);
    }

    /**
     * 当插件独立运行的时候，需要告知插件
     * 1.发布资源的时候在哪里？
     * 2.加载资源的时候在哪里？
     * 3.图片上传保存在哪里？
     * 4.还可以加载额外的改变默认的app属性
     * 如果没有独立运行的需求则不需要执行
     *
     * @param Application $app
     */
    protected function whenAddonToAppReset($app)
    {

        //读取插件脚本下的配置，修改网站默认的配置。
        //默认@webroot的值是入口脚本的目录
        $scriptDir = \Yii::getAlias('@webroot');
        if (\is_file($scriptDir . '/' . 'config.php')) {
            $config = require $scriptDir . '/' . 'config.php';
            foreach ($config as $attr => $val) {
                $app->{$attr} = $val;
            }
        }
        //重置app的入口目录。
        //目的是解决当插件独立域名运行的时候，需要通过该参数固定发布资源文件的目录。
        \Yii::setAlias('@webroot', '@app/public');
        //重置baseUri，由于资源文件是同意在public目录的。
        //当插件独立域名运行的时候需要通过@web知道资源的文件的位置
        //\Yii::setAlias('@web', '/baiyuan-yii2/public');
    }

    /**
     * 通过参数配置，修改app的默认的homepage
     *
     * @param Application $app
     */
    protected function dynamicSetSiteHome($app)
    {
        if ($home = Setting::getSettings("site.index-page")) {

            $app->setHomeUrl([
                $home
            ]);
        }
    }

    /**
     * 固定后台的样式配置。
     * 为什么要在app级别配置？
     * 因为处理backend模块，还有其他的插件的也有backendController,
     * 并不是加载了backend模块之后再加载其他插件的，所以最佳的时机再app级别
     *
     * @param Application $app
     */
    protected function initBackendPageInitAssets($app)
    {
        //在处理请求之前
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

    /**
     * 动态注册Addons
     *
     * @param Application $app
     */
    protected function dynamicRegistAddons($app)
    {
        // To-Do
    }
}

