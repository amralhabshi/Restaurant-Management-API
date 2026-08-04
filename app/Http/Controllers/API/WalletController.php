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
     * Display the specified wallet.
     */
    public function show(Customer $customer,Wallet $wallet) 
    {
        $wallet->load('customer');

        return $this->response->success(
            data: new WalletResource($wallet)
        );
    }


}