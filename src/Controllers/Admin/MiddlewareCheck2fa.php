<?php

namespace AdminBase\Middleware;

use AdminBase\Models\Admin\NewOperationLog;
use AdminBase\Models\Admin\User;
use Closure;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use ReflectionException;
use ReflectionClass;
use Exception;

class MiddlewareCheck2fa
{
    /**
     * 操作日志收集
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //检查是否开启了二次验证
        $user = Admin::user();
        if (strstr($request->getRequestUri(), '/auth/setting')) {
            return $next($request);
        }
        if ($user && Admin::user()->isAdministrator()) {
            return $next($request);
        }
        //如果未开启，所有的路由请求重定向到设置二次验证页面
        if ($user && $user->is_validate == 0) {
            return $next($request);
        }

        //如果开启，但是google2fa_secret和recovery_code 为null，也需要重定向
        if ($user && $user->is_validate == User::IS_CALIDATE_ON && empty($user->google2fa_secret) && empty($user->recovery_code)) {
            return redirect('/auth/setting');
        }
        return $next($request);
    }
}
