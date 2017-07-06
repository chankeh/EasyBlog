<?php

namespace Illuminate\Support\Facades;

/**
 * @see \Illuminate\Routing\Router
 */
class Route extends Facade
{
    /**
     * Get the registered name of the component.
     * 该方法的目的就是返回别名类所对应的在服务容器中的服务名称
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}
