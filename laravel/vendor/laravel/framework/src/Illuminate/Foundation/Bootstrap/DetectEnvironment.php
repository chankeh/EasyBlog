<?php

namespace Illuminate\Foundation\Bootstrap;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Illuminate\Contracts\Foundation\Application;

class DetectEnvironment
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        if (! $app->configurationIsCached()) {   // file_exists($this->basePath().'/bootstrap/cache/config.php')
            $this->checkForSpecificEnvironmentFile($app);  //是否有特定的环境文件

            try {
                             // $this->basePath     //$this->environmentFile
                (new Dotenv($app->environmentPath(), $app->environmentFile()))->load();  // .env文件的配置加载
            } catch (InvalidPathException $e) {
                //
            }
        }
    }

    /**
     * Detect if a custom environment file matching the APP_ENV exists.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    protected function checkForSpecificEnvironmentFile($app)
    {
        if (! env('APP_ENV')) {  // getenv('APP_ENV') 第一次其实应该是直接返回了吧，毕竟没有putenv
            return;
        }

        $file = $app->environmentFile().'.'.env('APP_ENV');  //空.env('APP_ENV')  APP_ENV=local在根目录.env文件中

        if (file_exists($app->environmentPath().'/'.$file)) {   // $this->basePath
            $app->loadEnvironmentFrom($file);  // $this->environmentFile = $file;
        }
    }
}
