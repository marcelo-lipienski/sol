<?php

namespace App\Domain\Customer\Application\Http\Controllers;

use App\Domain\Customer\Application\Http\Resources\CustomerResource;
use App\Http\Controllers\Controller;
use App\Domain\Customer\Services\CreateCustomer;
use App\Domain\Customer\Services\DeleteCustomer;
use App\Domain\Customer\Services\FetchAllCustomers;
use App\Domain\Customer\Services\FetchCustomer;
use App\Domain\Customer\ValueObjects\DocumentValueObject;
use App\Http\Requests\StoreCustomerRequest;

class CustomerController extends Controller
{
    public function index(FetchAllCustomers $fetchAllCustomers)
    {
        $customers = $fetchAllCustomers->execute();

        return CustomerResource::collection($customers);
    }

    /**
     * @param string $document Accept only digits
     */
    public function show(string $document, FetchCustomer $fetchCustomer)
    {
        if (!is_numeric($document)) {
            return response()->json([], 400);
        }

        $customer = $fetchCustomer->execute(
            new DocumentValueObject($document)
        );

        return new CustomerResource($customer);
    }

    public function store(StoreCustomerRequest $request, CreateCustomer $createCustomer)
    {
        $customer = $createCustomer->execute($request->validated());

        return new CustomerResource($customer);
    }

    public function destroy(string $document, DeleteCustomer $deleteCustomer)
    {
        if (!is_numeric($document)) {
            return response()->json([], 400);
        }

        $deleteCustomer->execute(
            new DocumentValueObject($document)
        );

        return response()->json([], 204);
    }
}
