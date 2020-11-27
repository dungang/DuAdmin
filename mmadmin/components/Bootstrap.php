<?php
namespace app\mmadmin\components;

use app\mmadmin\core\Application;
use Yii;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;
use app\mmadmin\helpers\LoaderHelper;
use app\mmadmin\core\Hook;
use yii\validators\Validator;

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
        // 注册MMAdmin的多语言
        $app->i18n->translations['ma'] = [
            'class' => PhpMessageSource::className(),
            'sourceLanguage' => Yii::$app->sourceLanguage,
            'basePath' => '@app/mmadmin/messages'
        ];

        // 更换mysql的schema对象，支持for update 排他锁
        if ($app->db) {
            $app->db->schemaMap['mysql'] = 'app\mmadmin\mysql\Schema';
            $app->db->schemaMap['mysqli'] = 'app\mmadmin\mysql\Schema';
        }
        $this->dynamicParseAddons($app);
    }

    /**
     * 是否可以配置插件
     *
     * @param array $addon
     * @return boolean
     */
    protected function canConfigAddon(array $addon)
    {
        if (RUNTIME_MODE === 'Frontend') {
            return isset($addon['hasFrontend']) && $addon['hasFrontend'];
        } else if (RUNTIME_MODE === 'Backend') {
            return isset($addon['hasBackend']) && $addon['hasBackend'];
        } else if (RUNTIME_MODE === 'Api') {
            return isset($addon['hasApi']) && $addon['hasApi'];
        }
        return false;
    }

    protected function dynamicParseAddons($app)
    {
        $addons = LoaderHelper::dynamicParseAddons();

        if (is_array($addons)) {
            foreach ($addons as $addon) {
                // 1. 注册加载的类库
                LoaderHelper::loadAddonLibs($addon);
                // 2. 设置模块
                if ($this->canConfigAddon($addon)) {
                    $app->setModule($addon['id'], [
                        'class' => $addon['mainClass']
                    ]);
                    \Yii::debug($addon);
                }
                // 3. 绑定hook处理器
                if (isset($addon['hooksMap']) && is_array($addon['hooksMap'])) {
                    foreach ($addon['hooksMap'] as $hookName => $handlerNames) {
                        if (is_array($handlerNames)) {
                            foreach ($handlerNames as $handlerName) {
                                Hook::registerHookHandler($hookName, $handlerName);
                            }
                        } else {
                            Hook::registerHookHandler($hookName, $handlerNames);
                        }
                    }
                }
                // 4 注册模块的表当验证器
                if (isset($addon['validatorMap']) && is_array($addon['validatorMap'])) {
                    foreach($addon['validatorMap'] as $name => $validator) {
                        Validator::$builtInValidators[$name] = $validator; 
                    }
                }
                // 5. 其他待定
            }
        }
    }
}
