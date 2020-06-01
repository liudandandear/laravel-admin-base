<?php

namespace AdminBase\Models\Admin;

use Encore\Admin\Auth\Database\OperationLog;

class NewOperationLog extends OperationLog
{
    const ROUTE_UPDATE = 'update';
    const ROUTE_STORE = 'store';
    const ROUTE_DESTROY = 'destroy';

    protected $fillable = ['user_id', 'path', 'method', 'ip', 'input', 'do'];

    public static $ROUTE_DO = [
        self::ROUTE_UPDATE => '更新',
        self::ROUTE_STORE => '创建',
        self::ROUTE_DESTROY => '删除',
    ];
}
