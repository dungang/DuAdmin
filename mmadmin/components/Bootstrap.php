<?php

namespace app\mmadmin\components;

use app\mmadmin\core\Application;
use app\mmadmin\hooks\ViewInitedHook;
use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\BaseFileHelper;
use yii\helpers\Inflector;
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
        $this->dynamicRegistAddons($app);
    }

    /**
     * 动态注册Addons
     * 注册模块的加载器的资源包
     * 注册模块事件处理器
     *
     * @param Application $app
     */
    protected function dynamicRegistAddons($app)
    {
        $dirs = BaseFileHelper::findDirectories(Yii::$app->basePath . '/addons', [
            'recursive' => false
        ]);
        foreach ($dirs as $name) {
            $addonName = basename($name);
            $id = Inflector::camel2id($addonName);
            $addonClass = 'Addons\\' . $addonName . '\\Addon';
            if ($addonClass && class_exists($addonClass)) {
                $app->setModule($id, ['class' => $addonClass]);
                if (method_exists($addonClass, 'initAddon')) {
                    //加载类
                    call_user_func([$addonClass, 'initAddon']);
                    //注册hook的处理器
                    call_user_func([$addonClass, 'registerCommonHookHandlers']);
                }
            }
        }
    }
}
