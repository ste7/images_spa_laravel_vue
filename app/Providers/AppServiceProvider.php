<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        Schema::defaultStringLength(191);

//        if(env('APP_ENV') == 'production') {
//            $url->forceScheme('https');
//        }
//
//
//        if(env('FORCE_HTTPS') === 'true') {
//            $url->forceScheme('https');
//        }



//        if(env('APP_ENV') !== 'local') {
//            $url->forceScheme('https');
//        }

//        if (env('REDIRECT_HTTPS')) {
//            $url->forceScheme('https');
//        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        if(env('APP_ENV') !== 'local') {
//            $this->app['request']->server->set('HTTPS', true);
//        }
    }
}
