<?php


namespace AdminBase\Models\Admin;


use AdminBase\Models\AdminBaseModel;

class RolePermission extends AdminBaseModel
{
    protected $table = 'admin_role_permissions';

    /**
     * 获取角色有权限的路由
     * @param array $roleIds
     * @return array
     */
    public static function allowRouter(array $roleIds){
        $list = self::query()->leftJoin('admin_permissions as p', 'p.id', '=', 'admin_role_permissions.permission_id')
            ->whereIn('admin_role_permissions.role_id', $roleIds)->get(['p.http_path'])->toArray();
        return $list ? array_column($list, 'http_path') : [];
    }

    /**
     * 获取权限id组
     * @param $roleIds
     * @return array
     */
    public static function allowPermission($roleIds){
        $list = self::query()->where('role_id', $roleIds)->get(['permission_id'])->toArray();
        return $list ? array_column($list, 'permission_id') : [];
    }
}