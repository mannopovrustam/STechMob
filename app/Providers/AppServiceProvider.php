<?php

namespace App\Providers;

use App\Contracts\Repositories\CardProductInterface;
use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Repositories\MarkRepositoryInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Contracts\Services\MarkServiceInterface;
use App\Repositories\CardProductRepository;
use App\Repositories\ClientRepository;
use App\Repositories\MarkRepository;
use App\Services\ClientService\ClientService;
use App\Services\MarkService\MarkService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CardProductInterface::class, CardProductRepository::class);
        $this->app->bind(ClientServiceInterface::class, ClientService::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(MarkRepositoryInterface::class, MarkRepository::class);
        $this->app->bind(MarkServiceInterface::class, MarkService::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(199);
    }
}
