<?php

namespace App\Domain\Service\Infrastructure;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Repositories\CustomerRepositoryInterface;
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
                $service['id']
            );
        }, EloquentService::with(['customer', 'state'])->get()->toArray());

        return $services;
    }

    public function findById(int $id): Service
    {
        $service = EloquentService::with(['customer', 'state'])->find($id);

        // Bad design shortcut - should not fetch again from the database
        return new Service(
            $this->findCustomerById($service->customer->id),
            $this->findStateById($service->state->id),
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
            ]
        );

        return new Service(
            $service->customer,
            $service->state,
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
}