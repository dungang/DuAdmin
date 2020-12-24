<?php
namespace DuAdmin\Helpers;

use DuAdmin\Models\Menu;
use DuAdmin\Models\Navigation;

class InstallerHelper
{

    /**
     * 安装菜单
     *
     * @param array $menus
     * @param number $pid
     * @param boolean $isBackend
     */
    public static function installMenus($menus, $pid = 0, $isBackend = true)
    {
        
        if (is_array($menus)) {
            foreach ($menus as $menu) {
                $children = isset($menu['children']) ?: null;
                unset($menu['children']);
                $menuModel = new Menu($menu);
                $menuModel->pid = $pid;
                $menuModel->isFront =  $isBackend ? 0 : 1;
                $menuModel->save();
                if ($children && is_array($children)) {
                    static::installMenus($children, $menuModel->id, $isBackends);
                }
            }
        }
    }

    /**
     * 安装导航
     *
     * @param array $navigations
     * @param number $pid
     * @param string $app
     */
    public static function installNavigations($navigations, $pid = 0, $app = 'frontend')
    {
        if (is_array($navigations)) {
            foreach ($navigations as $navigation) {
                $children = isset($navigation['children']) ?: null;
                unset($navigation['children']);
                $navigationModel = new Navigation($navigation);
                $navigationModel->pid = $pid;
                $navigationModel->save();
                if ($children && is_array($children)) {
                    static::installMenus($navigation['children'], $navigationModel->id, $app);
                }
            }
        }
    }
}

