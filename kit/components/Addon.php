<?php

namespace app\kit\components;

use Yii;
use yii\base\Module;
use yii\web\View;
use app\kit\core\BackendController;
use app\kit\core\FrontendController;

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
     * @var string
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


    public $namespaceBase = 'app';

    protected function initApi()
    {
    }

    protected function initBackend()
    {
    }

    protected function initFrontend()
    {
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

    public function init()
    {
        parent::init();
        //加载模块自己的资源文件
        $this->on(self::EVENT_BEFORE_ACTION, [$this, 'loadAddonAssets']);
        $this->initControllerNamespace(Yii::$app->mode);
        $this->initViewPath(Yii::$app->mode);
        switch (Yii::$app->mode) {
            case 1:
                $this->controllerNamespace = $this->namespaceBase . '\backend\controllers';
                $this->initBackend();
                break;
            case 2:
                $this->initFrontend();
                break;
            case 3:
                $this->controllerNamespace = $this->namespaceBase . '\api\controllers';
                $this->initApi();
                break;
        }
    }

    private function initControllerNamespace($mode)
    {
        $this->controllerNamespace = $this->namespaceBase . '\\' . $mode . '\\controllers';
    }

    private function initViewPath($mode)
    {
        $path = '@' . trim(str_replace('\\', '/', $this->namespaceBase), '/');
        $this->viewPath = $path . '/' . $mode . '/views';
    }


    public function loadAddonAssets()
    {
        //$this->registerAddonErrorAction();
        $this->registerAddonBackendHomeBreadscrumb();
        Yii::$app->view->on(View::EVENT_BEGIN_PAGE, [$this, 'registerAddonFrontendAssetBundle']);
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
        if (Yii::$app->controller instanceof FrontendController) {
            $class = '\\app\\addons\\' . Yii::$app->controller->module->id . '\\assets\\AddonAsset';
            if (class_exists($class)) {
                call_user_func([$class, 'register'], Yii::$app->view);
            }
        }
    }

    /**
     * 注册插件模块的home面包屑
     * 仅且只能注册一次
     */
    protected function registerAddonBackendHomeBreadscrumb()
    {
        if (
            self::$has_set_addon_home_breadscrumb === false
            && (\Yii::$app->controller instanceof BackendController)
        ) {
            \Yii::$app->view->params['breadcrumbs'][] = $this->home;
            self::$has_set_addon_home_breadscrumb = true;
        }
    }
}
