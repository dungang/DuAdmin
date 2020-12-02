<?php
namespace DuAdmin\Components;

use Yii;
use yii\base\Module;
use yii\helpers\Inflector;
use ReflectionClass;
use yii\base\NotSupportedException;

/**
 * 插件基类
 *
 * @author dungang
 */
abstract class Addon extends Module
{

    /**
     * 避免重复赋值插件模块的面包屑
     * 比如，出现异常的时候，如果是backendcontroller 处理的异常的情况。
     *
     * @var boolean
     */
    public static $has_set_addon_home_breadscrumb = false;

    /**
     * 插件的名称
     *
     * @var string
     */
    public $name;

    /**
     * 模块home地址
     *
     * @var string | array
     */
    public $home;

    /**
     * 插件模块的namespace 基础名称
     */
    public $addonNamespaceBase = null;

    /**
     * 初始化API
     *
     * @throws NotSupportedException
     */
    protected function initApi()
    {
        // 初始化API的模块配置
    }

    /**
     * 初始化后端
     *
     * @throws NotSupportedException
     */
    protected function initBackend()
    {
        // 初始化后端的模块配置
    }

    /**
     * 初始化前端
     *
     * @throws NotSupportedException
     */
    protected function initFrontend()
    {
        // 初始化前端的模块配置
    }

    /**
     * 初始化语言
     *
     * @return void
     */
    protected function initI18N()
    {}

    public function registerFrontendTheme()
    {
        $this->on(self::EVENT_BEFORE_ACTION, function ($event) {
            if (Yii::$app->view->theme) {
                Yii::$app->view->theme->pathMap['@Addons/' . Yii::$app->controller->module->id . '/views'] = Yii::$app->view->theme->basePath . '/Addons/' . Yii::$app->controller->module->id;
            }
        });
    }

    /**
     *
     * @throws NotSupportedException
     * @throws \ReflectionException
     */
    public function init()
    {
        $this->initI18N();

        if (empty($this->addonNamespaceBase)) {
            $reflector = new ReflectionClass(get_called_class());
            $this->addonNamespaceBase = $reflector->getNamespaceName();
        }
        if (RUNTIME_MODE === 'Console') {
            $this->configConsoleContrllerNamespace();
        } else {
            $this->configWebControllerNamespace();
            // 注意这里代码执行的顺序
            switch (RUNTIME_MODE) {
                case 'Backend':
                    $this->initViewPath(Yii::$app->mode);
                    $this->initBackend();
                    $this->registerAddonBackendHomeBreadscrumb();
                    break;
                case 'Frontend':
                    $this->initViewPath();
                    $this->registerFrontendTheme();
                    $this->initFrontend();
                    break;
                case 'Api':
                    $this->initApi();
                    break;
            }
        }
    }

    private function configWebControllerNamespace()
    {
        $this->controllerNamespace = $this->addonNamespaceBase . '\\Controllers' . '\\' . RUNTIME_MODE;
    }

    private function configConsoleContrllerNamespace()
    {
        $this->controllerNamespace = $this->addonNamespaceBase . '\\Console';
    }

    private function initViewPath($mode = null)
    {
        $path = Yii::$app->basePath . '/Addons/' . Inflector::id2camel($this->id);
        if ($mode) {
            $this->viewPath = $path . '/resource/views/' . strtolower($mode);
        } else {
            // 减少目录层次，方便theme管理?
            $this->viewPath = $path . '/resource/views';
        }
    }


    /**
     * 注册插件模块的home面包屑
     * 仅且只能注册一次
     */
    protected function registerAddonBackendHomeBreadscrumb()
    {
        if (self::$has_set_addon_home_breadscrumb == false) {
            \Yii::$app->view->params['breadcrumbs'][] = $this->home;
            self::$has_set_addon_home_breadscrumb = true;
        }
    }
}
