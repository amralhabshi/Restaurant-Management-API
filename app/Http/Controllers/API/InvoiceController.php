<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Support\Http\ApiResponse;

class InvoiceController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Order $order)
    {
        $invoice = $order->invoice()
            ->with([
                'payments',
                'refunds',
            ])
            ->first();

        return $this->response->success(
            data: $invoice
                ? new InvoiceResource($invoice)
                : null
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreInvoiceRequest $request,
        Order $order
    ) {
        $invoice = $order->invoice()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new InvoiceResource($invoice),
            message: 'Invoice created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Order $order,
        Invoice $invoice
    ) {
        $invoice->load([
            'order',
            'payments',
            'refunds',
        ]);

        return $this->response->success(
            data: new InvoiceResource($invoice)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateInvoiceRequest $request,
        Order $order,
        Invoice $invoice
    ) {
        $invoice->update(
            $request->validated()
        );

        return $this->response->success(
            data: new InvoiceResource($invoice),
            message: 'Invoice updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Order $order,
        Invoice $invoice
    ) {
        $invoice->delete();

        return $this->response->noContent();
    }
}