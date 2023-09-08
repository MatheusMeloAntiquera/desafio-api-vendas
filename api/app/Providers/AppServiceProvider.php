<?php

namespace App\Providers;

use App\UseCases\VendedorService;
use Illuminate\Support\ServiceProvider;
use App\Domain\Vendedor\VendedorServiceInterface;
use App\Domain\Vendedor\VendedorRepositoryInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
