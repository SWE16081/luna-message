<?php

namespace Luna\Message;

use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool

     */

    protected $defer = true; // 延迟加载服务
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 单例绑定服务
        $this->app->singleton('message', function ($app) {
            return new MessageService($app['config']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // 发布配置文件
        $this->publishes([
            __DIR__ . '/Config/message.php' => config_path('message.php'),
        ]);
    }


}
