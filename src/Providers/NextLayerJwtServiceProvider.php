<?php
namespace Davidkiarie\NextLayerJwtPackage\Providers;

use Davidkiarie\NextLayerJwtPackage\Http\Middleware\CheckJwtPresence;
use Davidkiarie\NextLayerJwtPackage\Http\Middleware\CheckRefreshJwtPresence;
use Illuminate\Support\ServiceProvider;

class NextLayerJwtServiceProvider extends ServiceProvider{
    public function boot(){
        $this->app['router']->middleware('refreshJwt', 'your\namespace\MiddlewareClass');

        $this->loadRoutesFrom(dirname(__DIR__, 1).'/Routes/api.php');

    }
    public function register()
    {
        
        $this->app['router']->aliasMiddleware('refreshJwt', CheckRefreshJwtPresence::class);
        $this->app['router']->aliasMiddleware('checkJwt', CheckJwtPresence::class);


        //$this->app['router']->middleware('refreshJwt', 'your\namespace\MiddlewareClass');
 
    }
}