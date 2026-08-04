<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Invoice;
use App\Models\Payment;
use App\Support\Http\ApiResponse;

class PaymentController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Invoice $invoice)
    {
        $payments = $invoice->payments()
            ->paginate(10);

        return PaymentResource::collection($payments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request,Invoice $invoice) 
    {
        $payment = $invoice->payments()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new PaymentResource($payment),
            message: 'Payment created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice,Payment $payment) 
    {
        $payment->load('invoice');

        return $this->response->success(
            data: new PaymentResource($payment)
        );
    }
}