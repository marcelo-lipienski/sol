<?php

namespace App\Providers;

use App\Domain\Customer\Infrastructure\CustomerRepository;
use App\Domain\Customer\Repositories\CustomerRepositoryInterface;
use App\Domain\Service\Infrastructure\ServiceRepository;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
