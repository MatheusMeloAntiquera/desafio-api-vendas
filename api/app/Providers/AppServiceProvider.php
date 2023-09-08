<?php

namespace App\Providers;

use App\Domain\Vendedor\VendedorRepositoryInterface;
use App\Infra\VendedorQueryBuilderRepository;
use App\UseCases\VendedorService;
use Illuminate\Support\ServiceProvider;
use App\Domain\Vendedor\VendedorServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VendedorServiceInterface::class, VendedorService::class);
        $this->app->bind(VendedorRepositoryInterface::class, VendedorQueryBuilderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
