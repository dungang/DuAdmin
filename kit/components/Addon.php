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
class Addon extends Module {

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

    public function init() {
        parent::init();
        $this->on(self::EVENT_BEFORE_ACTION, [$this, 'initAddonResouces']);
    }

    /**
     * 插件初始化的方法
     *
     * @return void
     */
    public static function initAddon(){
        //空实现，可以在这注册第三方代码库
        //LoaderHelper::addNamespace() //psr0
        //LoaderHelper::addPsr4()
        //LoaderHelper::addClassMap()
        
    }

    public function initAddonResouces() {
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
    protected function registerAddonFrontendAssetBundle() {
        if (Yii::$app->controller instanceof FrontendController) {
            $class = '\\app\\addons\\' . Yii::$app->controller->module->id . '\\assets\\AddonAsset';
            if (class_exists($class)) {
                call_user_func([$class, 'register'], Yii::$app->view);
            }
        }
        
    }

    /**
     * 注册插件模块的home面包屑
     */
    protected function registerAddonBackendHomeBreadscrumb() {
        if (self::$has_set_addon_home_breadscrumb === false 
            && (\Yii::$app->controller instanceof BackendController)) {
            \Yii::$app->view->params['breadcrumbs'][] = $this->home;
            self::$has_set_addon_home_breadscrumb = true;
        }
    }

}
