<?php


namespace App\Providers;


use App\Repositories\Interfaces\{
    UserRepositoryInterface
};

use App\Repositories\{
    UserRepository
};
use App\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

    }
}
