<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register interface → implementation bindings.
     *
     * Add new bindings here as the project grows:
     *
     * $this->app->bind(
     *     \App\Interfaces\UserRepositoryInterface::class,
     *     \App\Repositories\UserRepository::class
     * );
     *
     * $this->app->bind(
     *     \App\Interfaces\UserServiceInterface::class,
     *     \App\Services\UserService::class
     * );
     */
    public function register(): void
    {
        //
    }
}
