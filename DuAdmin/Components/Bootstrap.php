<?php

namespace DuAdmin\Components;

use DuAdmin\Core\Application;
use DuAdmin\Core\Hook;
use DuAdmin\Helpers\LoaderHelper;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;
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
     *          the application currently running
     * {@inheritdoc}
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function bootstrap( $app )
    {

        \Yii::$classMap[ 'yii\helpers\BaseHtml' ] = '@app/DuAdmin/Clazz/BaseHtml.php';
        // 注册DUAdmin的多语言
        $app->i18n->translations [ 'da' ] = [
            'class'          => PhpMessageSource::class,
            'sourceLanguage' => $app->sourceLanguage,
            'basePath'       => $app->basePath . '/DuAdmin/Messages'
        ];
        // 注册表单验证器
        Validator::$builtInValidators [ 'mobile' ] = '\DuAdmin\Validators\MobileValidator'; // 验证手机
        Validator::$builtInValidators [ 'alternative' ] = '\DuAdmin\Validators\AlternativeValidator'; // 二选一验证
        Validator::$builtInValidators [ 'slug' ] = '\DuAdmin\Validators\SlugValidator';
        $this->dynamicParseAddons( $app );
    }

    /**
     * 是否可以配置插件
     *
     * @param array $addon
     * @return boolean
     */
    protected function canConfigAddon( array $addon )
    {

        if ( RUNTIME_MODE === 'Frontend' ) {
            return isset( $addon [ 'hasFrontend' ] ) && $addon [ 'hasFrontend' ];
        } else if ( RUNTIME_MODE === 'Backend' ) {
            return isset( $addon [ 'hasBackend' ] ) && $addon [ 'hasBackend' ];
        } else if ( RUNTIME_MODE === 'Api' ) {
            return isset( $addon [ 'hasApi' ] ) && $addon [ 'hasApi' ];
        }
        return false;
    }

    protected function dynamicParseAddons( $app )
    {

        $Addons = LoaderHelper::dynamicParseAddons();
        if ( is_array( $Addons ) ) {
            foreach ( $Addons as $addon ) {
                // 注册加载的类库
                LoaderHelper::loadAddonLibs( $addon );
                // 设置模块
                if ( $this->canConfigAddon( $addon ) ) {
                    $app->setModule( $addon [ 'id' ], [
                        'class' => $addon [ 'mainClass' ]
                    ] );
                    // 调试查看加载的插件
                    // \Yii::debug($addon);
                }
                // 设置模块的国际化消息文件
                if ( isset( $addon [ 'i18n' ] ) && is_array( $addon [ 'i18n' ] ) ) {
                    foreach ( $addon [ 'i18n' ] as $category ) {
                        $app->i18n->translations [ $category ] = [
                            'class'    => PhpMessageSource::class,
                            'basePath' => $app->basePath . '/Addons/' . $addon [ 'addon' ] . '/Messages'
                        ];
                    }
                }
                // 绑定hook处理器
                if ( isset( $addon [ 'hooksMap' ] ) && is_array( $addon [ 'hooksMap' ] ) ) {
                    foreach ( $addon [ 'hooksMap' ] as $hookName => $handlerNames ) {
                        if ( is_array( $handlerNames ) ) {
                            foreach ( $handlerNames as $handlerName ) {
                                Hook::registerHookHandler( $hookName, $handlerName );
                            }
                        } else {
                            Hook::registerHookHandler( $hookName, $handlerNames );
                        }
                    }
                }
                // 注册模块的表当验证器
                if ( isset( $addon [ 'validatorMap' ] ) && is_array( $addon [ 'validatorMap' ] ) ) {
                    foreach ( $addon [ 'validatorMap' ] as $name => $validator ) {
                        Validator::$builtInValidators [ $name ] = $validator;
                    }
                }
                // 其他待定
            }
        }
    }

}
