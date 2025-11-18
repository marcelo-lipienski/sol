<?php

namespace App\Providers;

use App\Domain\Customer\Infrastructure\CustomerRepository;
use App\Domain\Customer\Repositories\CustomerRepositoryInterface;
use App\Domain\Equipment\Infrastructure\EquipmentRepository;
use App\Domain\Equipment\Repositories\EquipmentRepositoryInterface;
use App\Domain\Installation\Infrastructure\InstallationRepository;
use App\Domain\Installation\Repositories\InstallationRepositoryInterface;
use App\Domain\Service\Infrastructure\EquipmentServiceRepository;
use App\Domain\Service\Repositories\EquipmentServiceRepositoryInterface;
use App\Domain\Service\Infrastructure\ServiceRepository;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Domain\State\Infrastructure\StateRepository;
use App\Domain\State\Repositories\StateRepositoryInterface;
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
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(InstallationRepositoryInterface::class, InstallationRepository::class);
        $this->app->bind(EquipmentServiceRepositoryInterface::class, EquipmentServiceRepository::class);
        $this->app->bind(EquipmentRepositoryInterface::class, EquipmentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
