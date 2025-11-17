<?php

namespace App\Domain\Service\Services;

use App\Domain\Customer\Repositories\CustomerRepositoryInterface;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;
use App\Domain\Service\Entities\Service;
use App\Domain\State\Repositories\StateRepositoryInterface;

class CreateService
{
    public function __construct(
        private ServiceRepositoryInterface $serviceRepository,
        private CustomerRepositoryInterface $customerRepository,
        private StateRepositoryInterface $stateRepository
    )
    {}

    public function execute(array $newService): Service
    {
        $customer = $this->customerRepository->findById($newService['customer_id']);
        $state = $this->stateRepository->findById($newService['state_id']);

        $service = new Service(
            $customer,
            $state,
            $newService['id'] ?? null
        );

        return $this->serviceRepository->save($service);
    }
}