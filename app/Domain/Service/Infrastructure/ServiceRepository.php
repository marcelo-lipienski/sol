<?php

namespace App\Domain\Service\Infrastructure;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\Repositories\CustomerRepositoryInterface;
use App\Models\Service as EloquentService;
use App\Domain\Service\Entities\Service;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function __construct(private CustomerRepositoryInterface $customerRepository)
    {}

    /**
     * @return array<\App\Domain\Service\Entities\Service>
     */
    public function fetchAll(): array
    {
        $services = array_map(function ($service) {
            return new Service(
                $this->findCustomerById($service['customer']['id']),
                $service['id']
            );
        }, EloquentService::with('customer')->get()->toArray());

        return $services;
    }

    public function findById(int $id): Service
    {
        $service = EloquentService::with('customer')->find($id);

        return new Service(
            $this->findCustomerById($service->customer->id),
            $service->id
        );
    }

    public function save(Service $service): Service
    {
        $storedService = EloquentService::updateOrCreate(
            ['id' => $service->id],
            ['customer_id' => $service->customer->id]
        );

        return new Service($service->customer, $storedService->id);
    }

    private function findCustomerById(int $id): Customer
    {
        return $this->customerRepository->findById($id);
    }
}