<?php

namespace App\Providers;

use App\Contracts\Repositories\CardProductInterface;
use App\Contracts\Repositories\ClientRepositoryInterface;
use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Repositories\MarkRepositoryInterface;
use App\Contracts\Repositories\PriceTypeRepositoryInterface;
use App\Contracts\Repositories\WarehouseRepositoryInterface;
use App\Contracts\Services\ClientServiceInterface;
use App\Contracts\Services\CurrencyServiceInterface;
use App\Contracts\Services\EmployeeServiceInterface;
use App\Contracts\Services\MarkServiceInterface;
use App\Contracts\Services\PriceTypeServiceInterface;
use App\Contracts\Services\WarehouseServiceInterface;
use App\Repositories\CardProductRepository;
use App\Repositories\ClientRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\MarkRepository;
use App\Repositories\PriceTypeRepository;
use App\Repositories\WarehouseRepository;
use App\Services\ClientService\ClientService;
use App\Services\CurrencyService\CurrencyService;
use App\Services\EmployeeService\EmployeeService;
use App\Services\MarkService\MarkService;
use App\Services\PriceTypeService\MoneyService;
use App\Services\WarehouseService\TradeService;
use App\Services\WarehouseService\WarehouseService;
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

        $this->app->bind(WarehouseRepositoryInterface::class, WarehouseRepository::class);
        $this->app->bind(WarehouseServiceInterface::class, WarehouseService::class);

        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(EmployeeServiceInterface::class, EmployeeService::class);

        $this->app->bind(CurrencyServiceInterface::class, CurrencyService::class);

        $this->app->bind(PriceTypeRepositoryInterface::class, PriceTypeRepository::class);
        $this->app->bind(PriceTypeServiceInterface::class, MoneyService::class);

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
