<?php

namespace App\Providers;

use App\UseCases\VendaService;
use App\UseCases\VendedorService;
use Illuminate\Support\ServiceProvider;
use App\Domain\Venda\VendaServiceInterface;
use App\Domain\Venda\VendaRepositoryInterface;
use App\Domain\Vendedor\VendedorServiceInterface;
use App\Domain\Vendedor\VendedorRepositoryInterface;
use App\Infra\Repositories\VendaQueryBuilderRepository;
use App\Infra\Repositories\VendedorQueryBuilderRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VendedorServiceInterface::class, VendedorService::class);
        $this->app->bind(VendedorRepositoryInterface::class, VendedorQueryBuilderRepository::class);

        $this->app->bind(VendaServiceInterface::class, VendaService::class);
        $this->app->bind(VendaRepositoryInterface::class, VendaQueryBuilderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
