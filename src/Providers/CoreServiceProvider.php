<?php

namespace Txsoura\Core\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Txsoura\Core\Http\Middleware\CheckLocale;
use Txsoura\Core\Http\Middleware\ResponseJson;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'core');

        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(ResponseJson::class);
        $kernel->pushMiddleware(CheckLocale::class);
    }
}
