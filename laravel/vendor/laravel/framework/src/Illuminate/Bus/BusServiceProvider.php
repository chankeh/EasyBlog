<?php

namespace Illuminate\Bus;

use Illuminate\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Illuminate\Bus\Dispatcher', function ($app) {
            return new Dispatcher($app, function ($connection = null) use ($app) {
                return $app['Illuminate\Contracts\Queue\Factory']->connection($connection);  //注册分发器服务   在Illuminate\Foundation\Application类的registerCoreContainerAliases()函数中将'Illuminate\Contracts\Queue\Factory'注册为'queue'别名
            });
        });  //单例

        $this->app->alias(
            'Illuminate\Bus\Dispatcher', 'Illuminate\Contracts\Bus\Dispatcher'  //别名
        );

        $this->app->alias(
            'Illuminate\Bus\Dispatcher', 'Illuminate\Contracts\Bus\QueueingDispatcher'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Illuminate\Bus\Dispatcher',
            'Illuminate\Contracts\Bus\Dispatcher',
            'Illuminate\Contracts\Bus\QueueingDispatcher',
        ];
    }
}
