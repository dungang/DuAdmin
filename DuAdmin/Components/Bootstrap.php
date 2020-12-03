<?php

namespace DuAdmin\Components;

use DuAdmin\Core\Application;
use Yii;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;
use DuAdmin\Helpers\LoaderHelper;
use DuAdmin\Core\Hook;
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

        // 注册DUAdmin的多语言
        $app->i18n->translations['da'] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => Yii::$app->sourceLanguage,
            'basePath' => $app->basePath . '/DuAdmin/messages'
        ];


        // 更换mysql的schema对象，支持for update 排他锁
        $app->db->schemaMap['mysql'] = 'DuAdmin\Mysql\Schema';
        $app->db->schemaMap['mysqli'] = 'DuAdmin\Mysql\Schema';

        // 增加自定义的DB查询条件表达式
        $app->db->queryBuilder->setExpressionBuilders([
            'DuAdmin\Db\DateRangeCondition' => 'DuAdmin\Db\DateRangeConditionBuilder'
        ]);
        $app->db->queryBuilder->setConditionClasses([
            'DATE_RANGE' => 'DuAdmin\Db\DateRangeCondition'
        ]);
        $app->db->queryBuilder->setExpressionBuilders([
            'DuAdmin\Db\FullSearchCondition' => 'DuAdmin\Db\FullSearchConditionBuilder'
        ]);
        $app->db->queryBuilder->setConditionClasses([
            'FULL_SEARCH' => 'DuAdmin\Db\FullSearchCondition'
        ]);

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
        $Addons = LoaderHelper::dynamicParseAddons();

        if (is_array($Addons)) {
            foreach ($Addons as $addon) {
                // 注册加载的类库
                LoaderHelper::loadAddonLibs($addon);
                // 设置模块
                if ($this->canConfigAddon($addon)) {
                    $app->setModule($addon['id'], [
                        'class' => $addon['mainClass']
                    ]);
                    //调试查看加载的插件
                    \Yii::debug($addon);
                }

                // 设置模块的国际化消息文件
                if (isset($addon['i18n']) && is_array($addon['i18n'])) {
                    foreach ($addon['i18n'] as $category) {
                        $app->i18n->translations[$category] = [
                            'class' => PhpMessageSource::class,
                            'basePath' => $app->basePath . '/Addons/' . $addon['addon'] . '/resource/messages'
                        ];
                    }
                }

                // 绑定hook处理器
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
                // 注册模块的表当验证器
                if (isset($addon['validatorMap']) && is_array($addon['validatorMap'])) {
                    foreach ($addon['validatorMap'] as $name => $validator) {
                        Validator::$builtInValidators[$name] = $validator;
                    }
                }
                // 其他待定
            }
        }
    }
}
