<?php

namespace DuAdmin\Components;

use Exception;
use ReflectionClass;
use Yii;
use yii\base\Module;
use yii\base\NotSupportedException;
use yii\helpers\Inflector;

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
   * 插件的目录名称
   *
   * @var string
   */
  protected $addonName = '';

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
   * 初始化命令终端
   *
   * @throws NotSupportedException
   */
  protected function initConsole()
  {


    // 初始化前端的模块配置
  }

  public function registerFrontendTheme()
  {

    if (Yii::$app->view->theme) {
      $viewKey = '@Addons/' . $this->addonName . '/Views/Frontend';
      $viewAddon = Yii::$app->view->theme->basePath . '/Addons/' . $this->addonName;
      Yii::$app->view->theme->pathMap[$viewKey] = $viewAddon;
    }
  }

  /**
   *
   * @throws NotSupportedException
   * @throws \ReflectionException
   */
  public function init()
  {

    $this->addonName = Inflector::id2camel($this->id);
    if (empty($this->addonNamespaceBase)) {
      $reflector = new ReflectionClass(get_called_class());
      $this->addonNamespaceBase = $reflector->getNamespaceName();
    }
    //注册插件的命令行命名空间
    //yii2\console\controllers\HelpController.php 会扫描
    if (RUNTIME_MODE === 'Console') {
      $this->configConsoleContrllerNamespace();
    } else {
      $this->configWebControllerNamespace();
      // 注意这里代码执行的顺序
      switch (RUNTIME_MODE) {
        case 'Backend':
          $this->initViewPath(Yii::$app->mode);
          $this->initBackend();
          $this->registerAddonHomeBreadscrumb();
          break;
        case 'Frontend':
          $this->initViewPath(Yii::$app->mode);
          $this->registerFrontendTheme();
          $this->initFrontend();
          $this->registerAddonHomeBreadscrumb();
          break;
        case 'Api':
          $this->initApi();
          break;
        case 'Console':
          $this->initConsole();
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

    $path = '@Addons/' . $this->addonName;
    if ($mode) {
      $this->viewPath = $path . '/Views/' . $mode;
    } else {
      // 减少目录层次，方便theme管理?
      $this->viewPath = $path . '/Views';
    }
  }

  /**
   * 注册插件模块的home面包屑
   * 仅且只能注册一次
   */
  protected function registerAddonHomeBreadscrumb()
  {

    if (self::$has_set_addon_home_breadscrumb == false) {
      \Yii::$app->view->params['breadcrumbs'][] = $this->home;
      self::$has_set_addon_home_breadscrumb = true;
    }
  }
}
