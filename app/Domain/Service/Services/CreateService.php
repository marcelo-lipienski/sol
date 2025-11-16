<?php

namespace App\Domain\Service\Services;

use App\Domain\Customer\Repositories\CustomerRepositoryInterface;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Domain\Service\Entities\Service;

class CreateService
{
    public function __construct(
        private ServiceRepositoryInterface $serviceRepository,
        private CustomerRepositoryInterface $customerRepository)
    {
    }

    public function execute(array $newService): Service
    {
        $customer = $this->customerRepository->findById($newService['customer_id']);

        $service = new Service($customer, $newService['id'] ?? null);

        return $this->serviceRepository->save($service);
    }
}