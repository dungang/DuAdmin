<?php

namespace DuAdmin\Helpers;

use Backend\Models\AuthAssignment;
use Backend\Models\AuthItem;
use Backend\Models\AuthItemChild;
use Backend\Models\AuthPermission;
use DuAdmin\Core\BizException;
use DuAdmin\Models\Cron;
use DuAdmin\Models\DashboardWidget;
use DuAdmin\Models\DictData;
use DuAdmin\Models\DictType;
use DuAdmin\Models\MailTemplate;
use DuAdmin\Models\Menu;
use DuAdmin\Models\Navigation;
use DuAdmin\Models\PrettyUrl;
use DuAdmin\Models\Setting;
use Exception;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Yii;
use yii\base\ErrorException;
use yii\helpers\Json;

class InstallerHelper
{

    /**
     * 安装一个权限
     */
    public static function installAddonPermission($addon, $addonName)
    {
        InstallerHelper::installPermissions([
            [
                'id'       => $addon,
                'name'     => $addonName . '管理'
            ]
        ]);
    }

    /**
     * 第一层的权限去重
     */
    public static function installPermissionCRUDShortcut($name, $routePrefix, $addon)
    {

        InstallerHelper::installPermissions([
            [
                'id' => $addon,
                'children' => [
                    [
                        'id'       => $routePrefix,
                        'name'     => $name . '管理',
                        'children' => [
                            [
                                'id'       => $routePrefix . '/index',
                                'name'     => $name . '列表',
                                'children' => [
                                    [
                                        'id'   => $routePrefix . '/view',
                                        'name' => '查看' . $name
                                    ]
                                ]
                            ],
                            [
                                'id'   => $routePrefix . '/create',
                                'name' => '添加' . $name
                            ],
                            [
                                'id'   => $routePrefix . '/update',
                                'name' => '更新' . $name
                            ],
                            [
                                'id'   => $routePrefix . '/delete',
                                'name' => '删除' . $name
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * 安装权限
     */
    public static function installPermissions($permissions, $parent = null)
    {

        if ($permissions) {
            foreach ($permissions as $index => $permission) {
                $filter = $permission;
                unset($filter['children']);
                $model = AuthPermission::findOne($filter);
                if (!$model) {
                    try {
                        $model = new AuthPermission();
                        $model->sort = $index;
                        $model->load($permission, '');
                        $model->save();
                        if ($model->hasErrors()) {
                            throw new ErrorException(Json::encode($model->errors));
                        }
                    } catch (Exception $e) {
                        throw new ErrorException($e->getMessage());
                    }
                }
                if ($parent) {
                    $relation = new AuthItemChild();
                    $relation->parent = $parent;
                    $relation->child = $model->id;
                    $relation->sort = $index;
                    try {
                        $relation->save();
                        if ($relation->hasErrors()) {
                            throw new ErrorException(Json::encode($model->errors));
                        }
                    } catch (Exception $e) {
                        throw new ErrorException($e->getMessage());
                    }
                }
                if (isset($permission['children']) && is_array($permission['children'])) {
                    static::installPermissions($permission['children'], $model->id);
                }
            }
        }
    }

    /**
     * 卸载权限
     */
    public static function uninstallPermissions($permissionId)
    {
        $childiren = AuthItemChild::find()->select('child')->where(['parent' => $permissionId])->column();
        AuthItem::deleteAll(['id' => $permissionId]);
        AuthAssignment::deleteAll(['itemId' => $permissionId]);
        if ($childiren) {
            AuthItemChild::deleteAll(['parent' => $permissionId]);
            foreach ($childiren as $child) {
                static::uninstallPermissions($child);
            }
        }
        AppHelper::cleanCache(['rbac']);
    }

    /**
     * 安装数据字典
     */
    public static function InstallDict($dictType, $dictName, $dictData)
    {
        $dict = DictType::findOne(['dictType' => $dictType]);
        if (empty($dict)) {
            $dict = new DictType(['dictType' => $dictType, 'dictName' => $dictName]);
            $dict->status = 1;
            $dict->save(false);
        }
        foreach ($dictData as $data) {
            $data['dictType'] = $dictType;
            $data['status'] = 1;
            $model = new DictData($data);
            $model->updateOrInsert(false, ['dictType' => $dictType, 'dictValue' => $data['dictValue']]);
        }
    }

    /**
     * 卸载数据字典类型
     */
    public static function UninstallDict($dictType)
    {
        DictData::deleteAll(['dictType' => $dictType]);
        DictType::deleteAll(['dictType' => $dictType]);
    }

    /**
     * 卸载数据字典数据
     */
    public static function UninstallDictData($dictType, $value)
    {
        DictData::deleteAll(['dictType' => $dictType, 'dictValue' => $value]);
    }

    /**
     * 安装后台菜单
     *
     * @param array $menus
     * @param number $pid
     * @param string $app
     */
    public static function installMenus($menus, $pid = 0, $app = 'core', $weight = 50)
    {

        if (is_array($menus)) {
            foreach ($menus as $index => $menu) {
                $filter = $menu;
                unset($filter['children']);
                $filter['app'] = $app;
                $model = Menu::findOne($filter);
                if (!$model) {
                    $model = new Menu();
                    $model->load($menu, '');
                    $model->pid = $pid;
                    $model->app = $app;
                    if (isset($menu['sort'])) {
                        $model->sort = $menu['sort'];
                    } else if ($pid === 0) {
                        $model->sort = $weight + $index;
                    } else {
                        $model->sort = $index;
                    }
                    $model->url = trim($model->url, '/');
                    if (!$model->save()) {
                        Yii::error("创建菜单失败：" . $menu['name']);
                        throw new ErrorException("创建菜单失败：" . $menu['name']);
                    }
                    if ($model->hasErrors()) {
                        Yii::error("创建菜单失败：" . Json::encode($model->errors));
                        throw new ErrorException(Json::encode($model->errors));
                    }
                }
                if (isset($menu['children']) && is_array($menu['children'])) {
                    static::installMenus($menu['children'], $model->id, $app, $weight);
                }
            }
        }
    }

    /**
     * 卸载后台菜单
     */
    public static function uninstallMenus($app)
    {

        Menu::deleteAll([
            'app' => $app
        ]);
    }

    /**
     * 安装前端导航
     *
     * @param array $navigations
     * @param number $pid
     * @param string $app
     */
    public static function installNavigations($navigations, $pid = 0, $app = 'frontend', $weight = 50)
    {

        if (is_array($navigations)) {
            foreach ($navigations as $index => $navigation) {
                $children = isset($navigation['children']) ? $navigation['children'] : null;
                $model = new Navigation(['app' => $app]);
                $model->load($navigation, '');
                $model->pid = $pid;
                if (!isset($navigation['requireAuth'])) {
                    $model->requireAuth = 1;
                }
                if (isset($navigation['sort'])) {
                    $model->sort = $navigation['sort'];
                } else if ($pid === 0) {
                    $model->sort = $weight + $index;
                } else {
                    $model->sort = $index;
                }
                $model->save();
                if ($model->hasErrors()) {
                    throw new ErrorException(Json::encode($model->errors));
                }
                if ($children && is_array($children)) {
                    static::installNavigations($navigation['children'], $model->id, $app, $weight);
                }
            }
        }
    }

    /**
     * 卸载前端导航数据
     */
    public static function uninstallNavigations($app)
    {

        Navigation::deleteAll([
            'app' => $app
        ]);
    }

    /**
     * 安装设置
     *
     * @param array $settings
     * @param string $category
     * @param string $parent
     */
    public static function installSettings($settings, $category = 'base')
    {

        if (is_array($settings)) {
            foreach ($settings as $setting) {
                $children = isset($setting['children']) ? $setting['children'] : null;
                $model = new Setting();
                $model->load($setting, '');
                if (isset($setting['category'])) {
                    $model->category = $setting['category'];
                } else {
                    $model->category = $category;
                }
                $model->save();
                if ($model->hasErrors()) {
                    throw new ErrorException(Json::encode($model->errors));
                }
                if ($children && is_array($children)) {
                    static::installSettings($setting['children'], $category, $model->name);
                }
            }
        }
    }

    /**
     * 卸载参数设置
     */
    public static function uninstallSetting($category)
    {

        Setting::deleteAll([
            'category' => $category
        ]);
    }


    /**
     * 添加路由美化规则
     */
    public static function installPrettyUrl($name, $route, $pattern, $weight = 0)
    {
        $prettyUrl = new PrettyUrl([
            'name' => $name,
            'route' => $route,
            'express' => $pattern,
            'weight' => $weight,
        ]);
        $prettyUrl->save(false);
    }

    /**
     * 安装定时任务
     */
    public static function installCronJob($script, $name, $time, $intro = null, $param = null)
    {
        $cron = Cron::findOne(['jobScript' => $script]);
        if (!$cron) {
            $cron = new Cron();
            $cron->jobScript = $script;
            $cron->task = $name;
            $cron->mhdmd = $time;
            $cron->intro = $intro;
            $cron->param = $param;
            $cron->isActive = false;
            $cron->save(false);
            if ($cron->hasErrors()) {
                throw new ErrorException(Json::encode($cron->errors));
            }
        }
    }

    /**
     * 卸载定时任务
     */
    public static function uninstallCronJob($scripts)
    {
        Cron::deleteAll(['jobScript' => $scripts]);
    }

    /**
     * 安装邮件模板
     */
    public static function installMailTemplate($unicode, $title, $content, $varsInfo = '')
    {
        $template = MailTemplate::findOne(['code' => $unicode]);
        if ($template) {
            throw new BizException("邮件模板已经存在:" . $unicode);
        }
        $template = new MailTemplate([
            'code' => $unicode,
            'title' => $title,
            'content' => $content,
            'varsInfo' => $varsInfo,
        ]);
        $template->save();
    }

    /**
     * 卸载邮件模板
     */
    public static function uninstallMailTemplate($unicode)
    {
        MailTemplate::deleteAll(['code' => $unicode]);
    }

    /**
     * 安装看板小部件
     */
    public static function installDashboardWidget($widgetClass, $name, $type = "counter", $args = "", $argsInfo = "")
    {
        $widget = new DashboardWidget([
            'name' => $name,
            'widget' => $widgetClass,
            'type' => $type,
            'args' => $args,
            'argsInfo' => $argsInfo
        ]);
        $widget->save(false);
    }

    /**
     * 卸载看板小部件
     */
    public static function uninstallDashboardWidget($widgetClass)
    {
        DashboardWidget::deleteAll(['widget' => $widgetClass]);
    }
}
