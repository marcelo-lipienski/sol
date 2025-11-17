<?php

namespace App\Domain\Service\Infrastructure;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Repositories\CustomerRepositoryInterface;
use App\Domain\Installation\Entities\Installation;
use App\Domain\Installation\Repositories\InstallationRepositoryInterface;
use App\Models\Service as EloquentService;
use App\Domain\Service\Entities\Service;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Domain\State\Entities\State;
use App\Domain\State\Repositories\StateRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private StateRepositoryInterface $stateRepository,
        private InstallationRepositoryInterface $installationRepository
    )
    {}

    /**
     * @return array<\App\Domain\Service\Entities\Service>
     */
    public function fetchAll(): array
    {
        $services = array_map(function ($service) {
            return new Service(
                $this->findCustomerById($service['customer']['id']),
                $this->stateRepository->findById($service['state']['id']),
                $this->installationRepository->findById($service['installation']['id']),
                $service['id']
            );
        }, EloquentService::with(['customer', 'state', 'installation'])->get()->toArray());

        return $services;
    }

    public function findById(int $id): Service
    {
        $service = EloquentService::with(['customer', 'state', 'installation'])->find($id);

        // Bad design shortcut - should not fetch again from the database
        return new Service(
            $this->findCustomerById($service->customer->id),
            $this->findStateById($service->state->id),
            $this->findInstallationById($service->installation->id),
            $service->id
        );
    }

    public function save(Service $service): Service
    {
        $storedService = EloquentService::updateOrCreate(
            ['id' => $service->id],
            [
                'customer_id' => $service->customer->id,
                'state_id' => $service->state->id,
                'installation_id' => $service->installation->id
            ]
        );

        return new Service(
            $service->customer,
            $service->state,
            $service->installation,
            $storedService->id,
        );
    }

    public function delete(int $id): void
    {
        EloquentService::destroy($id);
    }

    private function findCustomerById(int $id): Customer
    {
        return $this->customerRepository->findById($id);
    }

    private function findStateById(int $id): State
    {
        return $this->stateRepository->findById($id);
    }

    private function findInstallationById(int $id): Installation
    {
        return $this->installationRepository->findById($id);
    }
}