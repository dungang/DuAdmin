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
    public static function installMenus($menus, $pid = 0, $isBackend = true, $weight = 50)
    {
        if (is_array($menus)) {
            foreach ($menus as $menu) {
                $menuModel = new Menu();
                $menuModel->load($menu, '');
                $menuModel->pid = $pid;
                $menuModel->isFront = $isBackend ? 0 : 1;
                $menuModel->sort = $weight;
                $menuModel->save();
                if (isset($menu['children']) && is_array($menu['children'])) {
                    static::installMenus($menu['children'], $menuModel->id, $isBackend, $weight);
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
                $children = isset($navigation['children']) ? $navigation['children'] : null;
                $navigationModel = new Navigation();
                $navigationModel->load($navigation, '');
                $navigationModel->pid = $pid;
                $navigationModel->save();
                if ($children && is_array($children)) {
                    static::installNavigations($navigation['children'], $navigationModel->id, $app);
                }
            }
        }
    }
}

