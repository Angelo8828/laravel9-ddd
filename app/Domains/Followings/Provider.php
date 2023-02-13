<?php

namespace App\Domains\Followings;

use App\Models\PDOProvider;

use Illuminate\Support\ServiceProvider;
use PDO;

class Provider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RepositoryInterface::class, function ($app) {
            return new Repository(
                $app->make(PDOProvider::class)
            );
        });

        $this->app->singleton(ServiceInterface::class, function ($app) {
            return new Service(
                $app->make(RepositoryInterface::class)
            );
        });
    }
}
