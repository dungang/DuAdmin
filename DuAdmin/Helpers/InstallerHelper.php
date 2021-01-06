<?php
namespace DuAdmin\Helpers;

use DuAdmin\Models\Menu;
use DuAdmin\Models\Navigation;
use DuAdmin\Models\Setting;
use DuAdmin\Models\PageBlock;

class InstallerHelper
{
    
    public static function installPageBlocks($blocks,$sourceApp='backend'){
        
        if($blocks) {
            foreach($blocks as $block) {
                $model = new PageBlock();
                $model->load($block,'');
                $model->sourceApp = $sourceApp;
                $model->save();
                if ($model->hasErrors()) {
                    print_r($model->errors);
                    die();
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
                $menuModel = new Menu();
                $menuModel->load($menu, '');
                $menuModel->pid = $pid;
                $menuModel->isFront = $isBackend ? 0 : 1;
                $menuModel->app = $app;
                if (isset($menu['sort'])) {
                    $menuModel->sort = $menu['sort'];
                } else if ($pid === 0) {
                    $menuModel->sort = $weight;
                } else {
                    $menuModel->sort = $index;
                }
                $menuModel->save();
                if ($menuModel->hasErrors()) {
                    print_r($menuModel->errors);
                    die();
                }
                if (isset($menu['children']) && is_array($menu['children'])) {
                    static::installMenus($menu['children'], $menuModel->id, $app = 'core', $isBackend, $weight);
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
                $navigationModel = new Navigation();
                $navigationModel->load($navigation, '');
                $navigationModel->pid = $pid;
                if (isset($navigation['sort'])) {
                    $navigationModel->sort = $navigation['sort'];
                } else if ($pid === 0) {
                    $navigationModel->sort = $weight;
                } else {
                    $navigationModel->sort = $index;
                }
                $navigationModel->save();
                if ($navigationModel->hasErrors()) {
                    print_r($navigationModel->errors);
                    die();
                }
                if ($children && is_array($children)) {
                    static::installNavigations($navigation['children'], $navigationModel->id, $app, $weight);
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
                $model->load($setting,'');
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
                    print_r($model->errors);
                    die();
                }
                if ($children && is_array($children)) {
                    static::installSettings($setting['children'], $category, $model->name);
                }
            }
        }
    }
}

