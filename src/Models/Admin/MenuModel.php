<?php


namespace AdminBase\Models\Admin;

use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Facades\Admin;

class MenuModel extends Menu
{
    public function toTree()
    {
        $menu = $this->buildNestedArray();
        if (Admin::user()->isAdministrator()) {
            return $menu;
        }
        $roles = Admin::user()->roles->toArray();
        $roleIds = array_column($roles, 'id');
        $routers = RolePermission::allowRouter($roleIds);

        $routers = $this->formatRouters($routers);
        $this->formatTree($menu, $routers);
        $this->emptyTree($menu);
        return $menu;
    }

    /**
     * 过滤没有权限的菜单
     * @param $menu
     * @param $allowRouter
     */
    public function formatTree(&$menu, $allowRouter)
    {
        foreach ($menu as $key => &$val) {
            if (isset($val['children']) && $val['children']) {
                $this->formatTree($val['children'], $allowRouter);
            }
            if ($val['uri'] == '/') continue;
            if ($val['parent_id'] != 0 && !in_array(str_replace('/', '', $val['uri']), str_replace('/', '', str_replace('*', '', $allowRouter)))) {
                unset($menu[$key]);
            }
        }
    }

    /**
     * 去除没有子菜单的item
     * @param $menu
     */
    public function emptyTree(&$menu)
    {
        foreach ($menu as $key => $val) {
            if ($val['uri'] == '/') continue;
            if (!isset($val['children']) || !$val['children']) {
                unset($menu[$key]);
            }
        }
    }

    /**
     * @param $routers
     * @return array
     */
    public function formatRouters($routers)
    {
        $newRouters = [];
        //权限菜单 $allowRouter 可以是多个的
        array_map(function ($val) use (&$newRouters) {
            if (strpos($val, "\r\n")) {
                $val = explode("\r\n", $val);
                $newRouters = array_merge($newRouters, $val);
            } else {
                array_push($newRouters, $val);
            }
        }, $routers);
        return $newRouters;
    }
}