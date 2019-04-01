<?php
namespace app\kit\components;

use yii\base\Module;
use app\kit\models\Setting;

/**
 * 插件基类
 *
 * @author dungang
 */
class Addon extends Module
{

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
    
    public function init(){
        parent::init();
        \Yii::$app->view->params['breadcrumbs'][] = $this->name;
    }

    /**
     * 获取字符串值的参数
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

