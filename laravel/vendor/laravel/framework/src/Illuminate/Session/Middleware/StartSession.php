<?php

namespace Illuminate\Session\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Session\CookieSessionHandler;
use Symfony\Component\HttpFoundation\Response;

class StartSession
{
    /**
     * The session manager.
     *
     * @var \Illuminate\Session\SessionManager
     */
    protected $manager;

    /**
     * Indicates if the session was handled for the current request.
     *
     * @var bool
     */
    protected $sessionHandled = false;

    /**
     * Create a new session middleware.
     *
     * @param  \Illuminate\Session\SessionManager  $manager
     * @return void
     */
    public function __construct(SessionManager $manager)  //依赖注入
    {
        $this->manager = $manager;
    }

    /**
     * Handle an incoming request.
     * 开启会话中间件
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->sessionHandled = true;

        // If a session driver has been configured, we will need to start the session here
        // so that the data is ready for an application. Note that the Laravel sessions
        // do not make use of PHP "native" sessions in any way since they are crappy.
        if ($this->sessionConfigured()) {  // return ! is_null(Arr::get($this->app['config']['session'], 'driver'));    return ! is_null('file');
            $session = $this->startSession($request);  //////

            $request->setSession($session);  //可以通过请求实例获取session：$session = $request->session();
        }

        $response = $next($request);

        // Again, if the session has been configured we will need to close out the session
        // so that the attributes may be persisted to some storage medium. We will also
        // add the session identifier cookie to the application response headers now.
        if ($this->sessionConfigured()) {
            $this->storeCurrentUrl($request, $session);  //存储当前的URL

            $this->collectGarbage($session);  //垃圾回收

            $this->addCookieToResponse($response, $session);  //添加响应首部和存储Session数据
        }

        return $response;
    }

    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        if ($this->sessionHandled && $this->sessionConfigured() && ! $this->usingCookieSessions()) {
            $this->manager->driver()->save();
        }
    }

    /**
     * Start the session for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Session\SessionInterface
     */
    protected function startSession(Request $request)
    {
        $session = $this->getSession($request);  //////

        $session->setRequestOnHandler($request);

        $session->start();  //session开启工作，调用Illuminate\Session\Store类的start()函数完成。

        return $session;
    }

    /**
     * Get the session implementation from the manager.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Session\SessionInterface
     */
    public function getSession(Request $request)
    {
        $session = $this->manager->driver();  //得到Illuminate\Session\Store类的一个实例

        $session->setId($request->cookies->get($session->getName()));  // $session->getName()  ===  return $this->name;
                                                                       // $session->setId()  ===  $this->id = $id;

        return $session;
    }

    /**
     * Store the current URL for the request if necessary.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Session\SessionInterface  $session
     * @return void
     */
    protected function storeCurrentUrl(Request $request, $session)
    {
        if ($request->method() === 'GET' && $request->route() && ! $request->ajax()) {
            $session->setPreviousUrl($request->fullUrl());  // $session->put('_previous.url', $url);
        }
    }

    /**
     * Remove the garbage from the session if necessary.
     *
     * @param  \Illuminate\Session\SessionInterface  $session
     * @return void
     */
    protected function collectGarbage(SessionInterface $session)
    {
        $config = $this->manager->getSessionConfig();  // $this->app['config']['session'];

        // Here we will see if this request hits the garbage collection lottery by hitting
        // the odds needed to perform garbage collection on any given request. If we do
        // hit it, we'll call this handler to let it delete all the expired sessions.
        if ($this->configHitsLottery($config)) {
            $session->getHandler()->gc($this->getSessionLifetimeInSeconds());  //////
        }
    }

    /**
     * Determine if the configuration odds hit the lottery.
     *
     * @param  array  $config
     * @return bool
     */
    protected function configHitsLottery(array $config)
    {
        return random_int(1, $config['lottery'][1]) <= $config['lottery'][0];  // return random_int(1,100) <= 2;
    }

    /**
     * Add the session cookie to the application response.
     *
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @param  \Illuminate\Session\SessionInterface  $session
     * @return void
     */
    protected function addCookieToResponse(Response $response, SessionInterface $session)
    {
        if ($this->usingCookieSessions()) {
            $this->manager->driver()->save();  //////
        }

        if ($this->sessionIsPersistent($config = $this->manager->getSessionConfig())) {  //判断session的驱动存储是否是持久存储，默认情况下为'file'，所以为持久存储。
            $response->headers->setCookie(new Cookie(
                $session->getName(), $session->getId(), $this->getCookieExpirationDate(),
                $config['path'], $config['domain'], Arr::get($config, 'secure', false)
            ));
        }
    }

    /**
     * Get the session lifetime in seconds.
     *
     * @return int
     */
    protected function getSessionLifetimeInSeconds()
    {
        return Arr::get($this->manager->getSessionConfig(), 'lifetime') * 60;
    }

    /**
     * Get the cookie lifetime in seconds.
     *
     * @return int
     */
    protected function getCookieExpirationDate()
    {
        $config = $this->manager->getSessionConfig();

        return $config['expire_on_close'] ? 0 : Carbon::now()->addMinutes($config['lifetime']);
    }

    /**
     * Determine if a session driver has been configured.
     *
     * @return bool
     */
    protected function sessionConfigured()
    {
        return ! is_null(Arr::get($this->manager->getSessionConfig(), 'driver'));  //return ! is_null(Arr::get($this->app['config']['session'], 'driver'));
    }

    /**
     * Determine if the configured session driver is persistent.
     *
     * @param  array|null  $config
     * @return bool
     */
    protected function sessionIsPersistent(array $config = null)
    {
        $config = $config ?: $this->manager->getSessionConfig();

        return ! in_array($config['driver'], [null, 'array']);
    }

    /**
     * Determine if the session is using cookie sessions.
     *
     * @return bool
     */
    protected function usingCookieSessions()
    {
        if (! $this->sessionConfigured()) {
            return false;
        }

        return $this->manager->driver()->getHandler() instanceof CookieSessionHandler;
    }
}
