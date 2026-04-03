<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Contracts\Repositories\Auth\UserRepositoryInterface;

use App\Services\Auth\AuthService;
use App\Repositories\Auth\UserRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    $this->app->bind(AuthServiceInterface::class, AuthService::class);
    $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
