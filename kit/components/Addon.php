<?php
namespace app\kit\components;

use yii\base\Module;
use app\kit\models\Setting;
use app\kit\core\BackendController;

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
    public static $module_breadscrumb = false;

    /**
     * 插件的名称
     *
     * @var string
     */
    public $name;

    /**
     * 参数的前缀，比如site
     *
     * @var string
     */
    public $setting_prefix;

    public function init()
    {
        parent::init();

        //默认的插件模块面包屑，只出现在后台程序
        $this->on(self::EVENT_BEFORE_ACTION,
            function () {
                if (self::$module_breadscrumb === false && (\Yii::$app->controller instanceof BackendController)) {
                    \Yii::$app->view->params['breadcrumbs'][] = $this->name;
                    self::$module_breadscrumb = true;
                }
                \Yii::$app->errorHandler->errorAction = 'backend/default/error';
            });
    }

    /**
     * 获取字符串值的参数
     *
     * @param string $name
     * @return NULL
     */
    public static function getSetting($name)
    {
        /* @var $self Addon */
        $self = \Yii::$app->module;
        return Setting::getSettings($self->setting_prefix . '.' . $name);
    }

    /**
     * 获取数组值的参数
     *
     * @param string $name
     * @return NULL
     */
    public static function getSettingAssoc($name)
    {
        /* @var $self Addon */
        $self = \Yii::$app->module;
        return Setting::getSettingAssoc($self->setting_prefix . '.' . $name);
    }

    /**
     * 获取字符串值的参数
     *
     * @param string $name
     * @return NULL
     */
    public static function getSettingAry($name)
    {
        /* @var $self Addon */
        $self = \Yii::$app->module;
        return Setting::getSettingAry($self->setting_prefix . '.' . $name);
    }
}

