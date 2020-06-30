<?php

namespace app\mmadmin\components;

use app\mmadmin\core\Application;
use Yii;
use yii\base\Module;
use yii\web\View;
use ReflectionClass;
use yii\base\NotSupportedException;

/**
 * 插件基类
 *
 * @author dungang
 */
class Addon extends Module
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
     * @var string | array
     */
    public $home;

    /**
     * 插件模块的namespace 基础名称
     */
    public $addonNamespaceBase = null;

    /**
     * 是否忽略入口模式
     */
    public $ignoreMode = false;

    /**
     * 初始化API
     *
     * @return void
     */
    protected function initApi()
    {
        //初始化API的模块配置
        throw new NotSupportedException('不支持API服务');
    }

    /**
     * 初始化后端
     *
     * @return void
     */
    protected function initBackend()
    {
        //初始化后端的模块配置
        throw new NotSupportedException('不支持后端服务');
    }

    /**
     * 初始化前端
     *
     * @return void
     */
    protected function initFrontend()
    {
        //初始化前端的模块配置
        throw new NotSupportedException('不支持前端服务');
    }

    /**
     * 初始化语言
     *
     * @return void
     */
    protected function initI18N(){

    }

    /**
     * 插件初始化的方法
     *
     * @return void
     */
    public static function initAddon()
    {
        //空实现，可以在这注册第三方代码库
        //LoaderHelper::addNamespace() //psr0
        //LoaderHelper::addPsr4()
        //LoaderHelper::addClassMap()

    }

    public static function registerCommonHookHandlers()
    {
    }

    public static function registerBackenHookHandlers()
    {
    }

    public static function registerFrontHookHandlers()
    {
    }

    public static function registerWebHookHandlers()
    {
    }

    public static function registerApiHookHandlers()
    {
    }

    public function registerFrontendTheme()
    {
        $this->on(self::EVENT_BEFORE_ACTION, function ($event) {
            if (Yii::$app->view->theme) {
                Yii::$app->view->theme->pathMap['@app/addons/' . Yii::$app->controller->module->id . '/views'] =
                    Yii::$app->view->theme->basePath . '/addons/' . Yii::$app->controller->module->id;
            }
            //print_r(Yii::$app->view->theme->pathMap);
        });
    }

    public function init()
    {
        $this->initI18N();
        if ($this->ignoreMode == false) {
            if (empty($this->addonNamespaceBase)) {
                $reflector = new ReflectionClass(static::className());
                $this->addonNamespaceBase = $reflector->getNamespaceName();
            }
            $this->initControllerNamespace(Yii::$app->mode);
            //注意这里代码执行的顺序
            switch (Yii::$app->mode) {
                case Application::MODE_BACKEND:
                    $this->initViewPath(Yii::$app->mode);
                    $this->initBackend();
                    $this->registerAddonBackendHomeBreadscrumb();
                    break;
                case Application::MODE_FRONTEND:
                    $this->initViewPath();
                    $this->registerFrontendTheme();
                    $this->initFrontend();
                    Yii::$app->view->on(
                        View::EVENT_BEGIN_PAGE,
                        [$this, 'registerAddonFrontendAssetBundle']
                    );
                    break;
                case Application::MODE_API:
                    $this->initApi();
                    break;
            }
        }
    }

    private function initControllerNamespace($mode)
    {
        if ($mode == Application::MODE_FRONTEND) {
            $this->controllerNamespace = $this->addonNamespaceBase . '\\controllers';
        } else {
            $this->controllerNamespace = $this->addonNamespaceBase . '\\' . $mode . '\\controllers';
        }
    }

    private function initViewPath($mode = null)
    {
        $path = '@' . trim(str_replace('\\', '/', $this->addonNamespaceBase), '/');
        if ($mode) {
            $this->viewPath = $path . '/' . $mode . '/views';
        } else {
            //减少目录层次，方便theme管理
            $this->viewPath = $path . '/views';
        }
    }

    //     /**
    //      * 注册插件模块的错误处理执行处理动作
    //      */
    //     protected function registerAddonErrorAction() {
    //         \Yii::$app->errorHandler->errorAction = 'backend/default/error';
    //     }

    /**
     * 注册插件模块的前端资源文件，如果存在则注册
     */
    protected function registerAddonFrontendAssetBundle()
    {
        $class = '\\app\\addons\\' . Yii::$app->controller->module->id . '\\assets\\AddonAsset';
        if (class_exists($class)) {
            call_user_func([$class, 'register'], Yii::$app->view);
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
