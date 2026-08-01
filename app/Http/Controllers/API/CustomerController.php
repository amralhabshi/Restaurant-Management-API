<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\RefundResource;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\WalletResource;
use App\Models\Customer;
use App\Support\Http\ApiResponse;

class CustomerController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::query()
            ->with('wallet')
            ->paginate(10);

        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create(
            $request->validated()
        );

        return $this->response->created(
            data: new CustomerResource($customer),
            message: 'Customer created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load([
            'wallet',
            'orders',
            'reservations',
            'refunds',
        ]);

        return $this->response->success(
            data: new CustomerResource($customer)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateCustomerRequest $request,
        Customer $customer
    ) {
        $customer->update(
            $request->validated()
        );

        return $this->response->success(
            data: new CustomerResource($customer),
            message: 'Customer updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return $this->response->noContent();
    }

    /**
     * Customer Wallet
     */
    public function wallet(Customer $customer)
    {
        $customer->load('wallet');

        return $this->response->success(
            data: new WalletResource($customer->wallet)
        );
    }

    /**
     * Customer Orders
     */
    public function orders(Customer $customer)
    {
        return OrderResource::collection(
            $customer->orders()->paginate(10)
        );
    }

    /**
     * Customer Reservations
     */
    public function reservations(Customer $customer)
    {
        return ReservationResource::collection(
            $customer->reservations()->paginate(10)
        );
    }

    /**
     * Customer Refunds
     */
    public function refunds(Customer $customer)
    {
        return RefundResource::collection(
            $customer->refunds()->paginate(10)
        );
    }
}