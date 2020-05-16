<?php

namespace AdminBase\Providers;

use Encore\Admin\AdminServiceProvider;

class NewAdminServiceProvider extends AdminServiceProvider
{
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.auth' => \Encore\Admin\Middleware\Authenticate::class,
        'admin.pjax' => \Encore\Admin\Middleware\Pjax::class,
        'admin.bootstrap' => \Encore\Admin\Middleware\Bootstrap::class,
        'admin.session' => \Encore\Admin\Middleware\Session::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin' => [
            'admin.auth',
            'admin.pjax',
            'admin.bootstrap',
            'admin.permission',
        ],
    ];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'common');
    }
}
