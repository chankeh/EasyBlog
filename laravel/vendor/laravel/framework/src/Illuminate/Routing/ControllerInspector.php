<?php

namespace Illuminate\Routing;

use ReflectionClass;
use ReflectionMethod;
use Illuminate\Support\Str;

/**
 * @deprecated since version 5.2.
 */
class ControllerInspector
{
    /**
     * An array of HTTP verbs.
     *
     * @var array
     */
    protected $verbs = [
        'any', 'get', 'post', 'put', 'patch',
        'delete', 'head', 'options',
    ];

    /**
     * Get the routable methods for a controller.
     *
     * @param  string  $controller
     * @param  string  $prefix
     * @return array
     */
    public function getRoutable($controller, $prefix)  // App\Http\Controllers\HomeController   home
    {
        $routable = [];

        $reflection = new ReflectionClass($controller);

        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);  //访问权限为PUBLIC的那些方法

        // To get the routable methods, we will simply spin through all methods on the
        // controller instance checking to see if it belongs to the given class and
        // is a publicly routable method. If so, we will add it to this listings.
        foreach ($methods as $method) {
            if ($this->isRoutable($method)) {
                $data = $this->getMethodData($method, $prefix); ////// get home/index home/index/{one?}/{two?}/{three?}/{four?}/{five?}

                $routable[$method->name][] = $data;  // $method->name就是方法名  $routable[getIndex][] = ['verb' => 'get', 'plain' => 'home/index', 'uri' => 'home/index/{one?}/{two?}/{three?}/{four?}/{five?}']

                // If the routable method is an index method, we will create a special index
                // route which is simply the prefix and the verb and does not contain any
                // the wildcard place-holders that each "typical" routes would contain.
                if ($data['plain'] == $prefix.'/index') {
                    $routable[$method->name][] = $this->getIndexData($data, $prefix); // $method->name就是方法名 get home home
                }
            }
        }

        return $routable;
    }

    /**
     * Determine if the given controller method is routable.
     *
     * @param  \ReflectionMethod  $method
     * @return bool
     */
    public function isRoutable(ReflectionMethod $method)
    {
        if ($method->class == 'Illuminate\Routing\Controller') {  // $method->class方法所属类
            return false;
        }

        return Str::startsWith($method->name, $this->verbs); // $method->name(方法名)是否以$this->verbs(请求动词)开头
    }

    /**
     * Get the method data for a given method.
     *
     * @param  \ReflectionMethod  $method
     * @param  string  $prefix
     * @return array
     */
    public function getMethodData(ReflectionMethod $method, $prefix)  // getIndex  home
    {
        $verb = $this->getVerb($name = $method->name); // get

        $uri = $this->addUriWildcards($plain = $this->getPlainUri($name, $prefix));  //Plain Text纯文本  home/index/{one?}/{two?}/{three?}/{four?}/{five?}

        return compact('verb', 'plain', 'uri'); // get /home/index home/index/{one?}/{two?}/{three?}/{four?}/{five?}
    }

    /**
     * Get the routable data for an index method.
     *
     * @param  array   $data
     * @param  string  $prefix
     * @return array
     */
    protected function getIndexData($data, $prefix)
    {
        return ['verb' => $data['verb'], 'plain' => $prefix, 'uri' => $prefix];  // get home home
    }

    /**
     * Extract the verb from a controller action.
     *
     * @param  string  $name
     * @return string
     */
    public function getVerb($name)  // getIndex
    {
        return head(explode('_', Str::snake($name)));  // return reset([get,index]);
    }

    /**
     * Determine the URI from the given method name.
     *
     * @param  string  $name
     * @param  string  $prefix
     * @return string
     */
    public function getPlainUri($name, $prefix) // getIndex home
    {
        return $prefix.'/'.implode('-', array_slice(explode('_', Str::snake($name)), 1)); // array_slice取出位置1的切片，return home/index
    }

    /**
     * Add wildcards to the given URI.
     * 增加通配符
     *
     * @param  string  $uri
     * @return string
     */
    public function addUriWildcards($uri)  // home/index
    {
        return $uri.'/{one?}/{two?}/{three?}/{four?}/{five?}';  // home/index/{one?}/{two?}/{three?}/{four?}/{five?}
    }
}
