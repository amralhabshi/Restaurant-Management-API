<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;
use App\Http\Resources\WalletResource;
use App\Models\Customer;
use App\Models\Wallet;
use App\Support\Http\ApiResponse;

class WalletController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display the customer's wallet.
     */
    public function index(Customer $customer)
    {
        $wallet = $customer->wallet()
            ->with('customer')
            ->first();

        return $this->response->success(
            data: $wallet
                ? new WalletResource($wallet)
                : null
        );
    }

    /**
     * Store a newly created wallet.
     */
    public function store(
        StoreWalletRequest $request,
        Customer $customer
    ) {
        $wallet = $customer->wallet()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new WalletResource($wallet),
            message: 'Wallet created successfully.'
        );
    }

    /**
     * Display the specified wallet.
     */
    public function show(
        Customer $customer,
        Wallet $wallet
    ) {
        $wallet->load('customer');

        return $this->response->success(
            data: new WalletResource($wallet)
        );
    }

    /**
     * Update the specified wallet.
     */
    public function update(
        UpdateWalletRequest $request,
        Customer $customer,
        Wallet $wallet
    ) {
        $wallet->update(
            $request->validated()
        );

        return $this->response->success(
            data: new WalletResource($wallet),
            message: 'Wallet updated successfully.'
        );
    }

    /**
     * Remove the specified wallet.
     */
    public function destroy(
        Customer $customer,
        Wallet $wallet
    ) {
        $wallet->delete();

        return $this->response->noContent();
    }
}