<?php

namespace App\Providers;

use App\Repositories\CardProductRepository;
use App\Repositories\Interfaces\CardProduct;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Repositories binding
        $this->app->bind(CardProduct::class, CardProductRepository::class);

        // Services binding
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
