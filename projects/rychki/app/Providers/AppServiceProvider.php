<?php

namespace App\Providers;

use Libs\Handler\Contracts\HandlerContract;
use Libs\Handler\Repositories\RedisRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(HandlerContract::class, RedisRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
