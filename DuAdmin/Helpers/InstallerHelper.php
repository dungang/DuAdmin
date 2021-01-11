<?php

namespace DuAdmin\Helpers;

use Backend\Models\AuthItemChild;
use Backend\Models\AuthPermission;
use DuAdmin\Models\Menu;
use DuAdmin\Models\Navigation;
use DuAdmin\Models\Setting;
use DuAdmin\Models\PageBlock;
use yii\base\ErrorException;
use yii\helpers\Json;

class InstallerHelper
{

    public static function installPermissions($permissions, $parent = null)
    {
        if ($permissions) {
            foreach ($permissions as $index => $permission) {
                $model = new AuthPermission();
                $model->sort = $index;
                $model->load($permission, '');
                $model->save();
                if ($model->hasErrors()) {
                    throw new ErrorException(Json::encode($model->errors));
                }
                if ($parent) {
                    $relation = new AuthItemChild();
                    $relation->parent = $parent;
                    $relation->child = $model->id;
                    $relation->sort = $index;
                    $relation->save();
                    if ($relation->hasErrors()) {
                        throw new ErrorException(Json::encode($model->errors));
                    }
                }
                if (isset($permission['children']) && is_array($permission['children'])) {
                    static::installPermissions($permission['children'], $model->id);
                }
            }
        }
    }

    public static function uninstallPermissions($permissionIds)
    {
        AuthPermission::deleteAll(['id' => $permissionIds]);
    }

    public static function installPageBlocks($blocks, $sourceApp = 'backend')
    {

        if ($blocks) {
            foreach ($blocks as $block) {
                $model = new PageBlock();
                $model->load($block, '');
                $model->sourceApp = $sourceApp;
                $model->save();
                if ($model->hasErrors()) {
                    throw new ErrorException(Json::encode($model->errors));
                }
            }
        }
    }

    /**
     * 安装菜单
     *
     * @param array $menus
     * @param number $pid
     * @param string $app
     * @param boolean $isBackend
     */
    public static function installMenus($menus, $pid = 0, $app = 'core', $isBackend = true, $weight = 50)
    {
        if (is_array($menus)) {
            foreach ($menus as $index => $menu) {
                $model = new Menu();
                $model->load($menu, '');
                $model->pid = $pid;
                $model->isFront = $isBackend ? 0 : 1;
                $model->app = $app;
                if (isset($menu['sort'])) {
                    $model->sort = $menu['sort'];
                } else if ($pid === 0) {
                    $model->sort = $weight;
                } else {
                    $model->sort = $index;
                }
                $model->save();
                if ($model->hasErrors()) {
                    throw new ErrorException(Json::encode($model->errors));
                }
                if (isset($menu['children']) && is_array($menu['children'])) {
                    static::installMenus($menu['children'], $model->id, $app = 'core', $isBackend, $weight);
                }
            }
        }
    }

    public static function uninstallMenus($app)
    {
        Menu::deleteAll([
            'app' => $app
        ]);
    }

    /**
     * 安装导航
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
                $model = new Navigation();
                $model->load($navigation, '');
                $model->pid = $pid;
                if (isset($navigation['sort'])) {
                    $model->sort = $navigation['sort'];
                } else if ($pid === 0) {
                    $model->sort = $weight;
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
    public static function installSettings($settings, $category = 'base', $parent = '')
    {
        if (is_array($settings)) {
            foreach ($settings as $setting) {
                $children = isset($setting['children']) ? $setting['children'] : null;
                $model = new Setting();
                $model->load($setting, '');
                if (isset($setting['parent'])) {
                    $model->parent = $setting['parent'];
                } else {
                    $model->parent = $parent;
                }
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
}