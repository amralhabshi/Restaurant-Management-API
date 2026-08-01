<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRefundRequest;
use App\Http\Requests\UpdateRefundRequest;
use App\Http\Resources\RefundResource;
use App\Models\Invoice;
use App\Models\Refund;
use App\Support\Http\ApiResponse;

class RefundController extends Controller
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
        $refunds = $invoice->refunds()
            ->with([
                'employee',
                'customer',
            ])
            ->paginate(10);

        return RefundResource::collection($refunds);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreRefundRequest $request,
        Invoice $invoice
    ) {
        $refund = $invoice->refunds()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new RefundResource($refund),
            message: 'Refund created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Invoice $invoice,
        Refund $refund
    ) {
        $refund->load([
            'invoice',
            'employee',
            'customer',
        ]);

        return $this->response->success(
            data: new RefundResource($refund)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateRefundRequest $request,
        Invoice $invoice,
        Refund $refund
    ) {
        $refund->update(
            $request->validated()
        );

        return $this->response->success(
            data: new RefundResource($refund),
            message: 'Refund updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Invoice $invoice,
        Refund $refund
    ) {
        $refund->delete();

        return $this->response->noContent();
    }
}