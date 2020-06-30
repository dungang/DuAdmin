<?php

namespace app\mmadmin\components;

use app\mmadmin\core\Application;
use app\mmadmin\hooks\ViewInitedHook;
use Yii;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

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
        //注册MMAdmin的多语言
        $app->i18n->translations['ma'] = [
            'class' => PhpMessageSource::className(),
            'sourceLanguage' => Yii::$app->sourceLanguage,
            'basePath' => '@app/mmadmin/messages'
        ];

        //更换mysql的schema对象，支持for update 排他锁
        if ($app->db) {
            $app->db->schemaMap['mysql'] = 'app\mmadmin\mysql\Schema';
            $app->db->schemaMap['mysqli'] = 'app\mmadmin\mysql\Schema';
        }
        $this->whenAddonToAppReset($app);
        $this->dynamicRegistAddons($app);
        if (Yii::$app->mode === Application::MODE_FRONTEND) {
            ViewInitedHook::registerHandler('app\mmadmin\hooks\SiteStatisticCodeHandler');
        }
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
     * 动态注册Addons
     *
     * @param Application $app
     */
    protected function dynamicRegistAddons($app)
    {

        foreach (array_values($app->modules) as $module) {
            if (is_array($module)) {
                $module = $module['class'];
            }
            if ($module && class_exists($module)) {
                if (method_exists($module, 'initAddon')) {
                    //加载类
                    call_user_func([$module, 'initAddon']);
                    //注册hook的处理器
                    call_user_func([$module, 'registerCommonHookHandlers']);

                    if ($app->mode == Application::MODE_FRONTEND) {
                        call_user_func([$module, 'registerWebHookHandlers']);
                        call_user_func([$module, 'registerFrontHookHandlers']);
                    } else if ($app->mode == Application::MODE_BACKEND) {
                        call_user_func([$module, 'registerWebHookHandlers']);
                        call_user_func([$module, 'registerBackenHookHandlers']);
                    } else if ($app->mode == Application::MODE_API) {
                        call_user_func([$module, 'registerApiHookHandlers']);
                    }
                }
            }
        }
    }
}
