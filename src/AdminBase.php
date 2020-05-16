<?php

namespace AdminBase;

use Encore\Admin\Controllers\AuthController;
use Illuminate\Routing\Router;

class AdminBase
{
    public static function router()
    {
        $attributes = [
            'prefix' => config('admin.route.prefix'),
            'middleware' => config('admin.route.middleware'),
        ];

        //需要限流的路由，每日100次
        app('router')->group([
            'prefix' => config('admin.route.prefix'),
            'middleware' => ['web', 'admin', 'throttle:100,1440']
        ], function (Router $router) {
            $router->namespace('\AdminBase\Controllers')->group(function (Router $router) {
                $router->get('auth/recovery', 'Auth\RecoveryLoginController@get')->name('恢复代码登录页面');
                $router->post('auth/recovery', 'Auth\RecoveryLoginController@store')->name('恢复代码登录');
            });

            $authController = config('admin.auth.controller', AuthController::class);
            $router->post('auth/login', $authController.'@postLogin');
            $router->get('auth/logout', $authController.'@getLogout')->name('登出');
            $router->get('auth/check', $authController.'@check')->name('验证码验证');
            $router->get('auth/verify', $authController.'@verify')->name('验证码生成');
        });

        app('router')->group($attributes, function ($router) {
            $router->namespace('\AdminBase\Controllers')->group(function (Router $router) {
                //----------------------------二次登陆验证----------------------------//
                $router->put('auth/setting/enable_2fa', 'Auth\SecurityController@validateTwoFactor')->name('开启二次验证');
                $router->put('auth/setting/disable_2fa', 'Auth\SecurityController@deactivateTwoFactor')->name('关闭二次验证');
                $router->post('auth/validate2fa', 'Auth\Validate2faController@index')->name('二次登陆验证');

                //----------------------------项目导航----------------------------//
                $router->resource('webstack/categories', 'WebStack\CategoryController');
                $router->resource('webstack/sites', 'WebStack\SiteController');

                //----------------------------自定义laravel-admin核心路由----------------------------//
                $router->resource('auth/logs', 'Admin\LogController')->names('用户日志');
                $router->resource('auth/users', 'Admin\UserController')->names('用户管理');
                $router->resource('auth/permissions', 'Admin\PermissionController')->names('权限管理');
                $router->resource('auth/roles', 'Admin\RoleController')->names('角色管理');
            });
            $authController = config('admin.auth.controller', AuthController::class);
            $router->put('auth/setting/password', $authController.'@password')->name('修改密码');
        });
    }
}