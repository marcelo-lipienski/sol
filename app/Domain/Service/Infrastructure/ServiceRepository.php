<?php

namespace App\Domain\Service\Infrastructure;

use App\Domain\Customer\Entities\Customer;
use App\Domain\Customer\ValueObjects\DocumentValueObject;
use App\Domain\Customer\ValueObjects\EmailValueObject;
use App\Domain\Customer\ValueObjects\NameValueObject;
use App\Domain\Customer\ValueObjects\PhoneNumberValueObject;
use App\Models\Service as EloquentService;
use App\Domain\Service\Entities\Service;
use App\Domain\Service\Repositories\ServiceRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * @return array<\App\Domain\Service\Entities\Service>
     */
    public function fetchAll(): array
    {
        $services = array_map(function ($service) {
            $customer = new Customer(
                new EmailValueObject($service['customer']['email']),
                new NameValueObject($service['customer']['name']),
                new PhoneNumberValueObject($service['customer']['phone_number']),
                new DocumentValueObject($service['customer']['document']),
                $service['customer']['id']
            );

            return new Service(
                $customer,
                $service['id']
            );
        }, EloquentService::with('customer')->get()->toArray());

        return $services;
    }

    public function save(Service $service): Service
    {
        $storedService = EloquentService::updateOrCreate(
            ['id' => $service->id],
            ['customer_id' => $service->customer->id]
        );

        return new Service($service->customer, $storedService->id);
    }
}