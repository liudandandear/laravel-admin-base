<?php


namespace AdminBase\Providers;


use AdminBase\Adapters\FastDFSAdapter;
use Storage;
use League\Flysystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class FastDFSServiceProvider extends ServiceProvider
{
    /**
     * 执行注册后引导服务。
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('admin', function ($app, $config) {
            $adapter = new FastDFSAdapter($config['root']);
            return new Filesystem($adapter);
        });
    }

    /**
     * 在容器中注册绑定。
     *
     * @return void
     */
    public function register()
    {
        //
    }
}