<?php

namespace App\Domain\Customer\Application\Http\Controllers;

use App\Domain\Customer\Application\Http\Resources\CustomerResource;
use App\Http\Controllers\Controller;
use App\Domain\Customer\Services\CreateCustomer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request, CreateCustomer $createCustomer)
    {
        $customer = $createCustomer->execute($request->validated());

        return new CustomerResource($customer);
    }
}
