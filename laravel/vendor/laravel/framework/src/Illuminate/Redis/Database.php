<?php

namespace Illuminate\Redis;

use Closure;
use Predis\Client;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Redis\Database as DatabaseContract;

class Database implements DatabaseContract
{
    /**
     * The host address of the database.
     *
     * @var array
     */
    protected $clients;

    /**
     * Create a new Redis connection instance.
     * 举例：Redis::set('string:user:name', 'wshuo');
     * 此处只完成了Redis::部分
     *
     * @param  array  $servers
     * @return void
     */
    public function __construct(array $servers = [])
    {
        $cluster = Arr::pull($servers, 'cluster');  //返回false，移除'cluster'键值项

        $options = (array) Arr::pull($servers, 'options');  //返回空，移除'options'键值项，实际上没有该项。
        /*
         $servers =
         [
            'default' => [
                'host' => env('REDIS_HOST', 'localhost'),
                'password' => env('REDIS_PASSWORD', null),
                'port' => env('REDIS_PORT', 6379),
                'database' => 0,
            ],
         ]
        */



        if ($cluster) {
            $this->clients = $this->createAggregateClient($servers, $options);
        } else {
            $this->clients = $this->createSingleClients($servers, $options);  //////
        }
    }

    /**
     * Create a new aggregate client supporting sharding.
     *
     * @param  array  $servers
     * @param  array  $options
     * @return array
     */
    protected function createAggregateClient(array $servers, array $options = [])
    {
        return ['default' => new Client(array_values($servers), $options)];
    }

    /**
     * Create an array of single connection clients.
     *
     * @param  array  $servers
     * @param  array  $options
     * @return array
     */
    protected function createSingleClients(array $servers, array $options = [])
    {
        $clients = [];

        foreach ($servers as $key => $server) {
            $clients[$key] = new Client($server, $options);  //redis数据库客户端实例化。  $clients['default'] =
        }

        return $clients;
    }

    /**
     * Get a specific Redis connection instance.
     *
     * @param  string  $name
     * @return \Predis\ClientInterface|null
     */
    public function connection($name = 'default')
    {
        return Arr::get($this->clients, $name ?: 'default');
    }

    /**
     * Run a command against the Redis database.
     * 举例：Redis::set('string:user:name', 'wshuo');
     *
     * @param  string  $method  'set'
     * @param  array   $parameters  array('string:user:name', 'wshuo')
     * @return mixed
     */
    public function command($method, array $parameters = [])
    {
        return call_user_func_array([$this->clients['default'], $method], $parameters);  //调用\Predis\Client类的$method方法
    }

    /**
     * Subscribe to a set of given channels for messages.
     *
     * @param  array|string  $channels
     * @param  \Closure  $callback
     * @param  string  $connection
     * @param  string  $method
     * @return void
     */
    public function subscribe($channels, Closure $callback, $connection = null, $method = 'subscribe')
    {
        $loop = $this->connection($connection)->pubSubLoop();

        call_user_func_array([$loop, $method], (array) $channels);

        foreach ($loop as $message) {
            if ($message->kind === 'message' || $message->kind === 'pmessage') {
                call_user_func($callback, $message->payload, $message->channel);
            }
        }

        unset($loop);
    }

    /**
     * Subscribe to a set of given channels with wildcards.
     *
     * @param  array|string  $channels
     * @param  \Closure  $callback
     * @param  string  $connection
     * @return void
     */
    public function psubscribe($channels, Closure $callback, $connection = null)
    {
        return $this->subscribe($channels, $callback, $connection, __FUNCTION__);
    }

    /**
     * Dynamically make a Redis command.
     * 举例：Redis::set('string:user:name', 'wshuo');
     * 此处完成set('string:user:name', 'wshuo');部分
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->command($method, $parameters);  //////
    }
}
