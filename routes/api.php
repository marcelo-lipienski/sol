<?php

use App\Domain\Customer\Application\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/customer', CustomerController::class)->middleware('api');