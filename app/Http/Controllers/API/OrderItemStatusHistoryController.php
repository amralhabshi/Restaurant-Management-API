<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderItemStatusHistoryRequest;
use App\Http\Requests\UpdateOrderItemStatusHistoryRequest;
use App\Http\Resources\OrderItemStatusHistoryResource;
use App\Models\OrderItem;
use App\Models\OrderItemStatusHistory;
use App\Support\Http\ApiResponse;

class OrderItemStatusHistoryController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OrderItem $orderItem)
    {
        $histories = $orderItem->statusHistories()
            ->with('employee')
            ->paginate(10);

        return OrderItemStatusHistoryResource::collection($histories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreOrderItemStatusHistoryRequest $request,
        OrderItem $orderItem
    ) {
        $history = $orderItem->statusHistories()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new OrderItemStatusHistoryResource($history),
            message: 'Order item status history created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(
        OrderItem $orderItem,
        OrderItemStatusHistory $history
    ) {
        $history->load([
            'orderItem',
            'employee',
        ]);

        return $this->response->success(
            data: new OrderItemStatusHistoryResource($history)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateOrderItemStatusHistoryRequest $request,
        OrderItem $orderItem,
        OrderItemStatusHistory $history
    ) {
        $history->update(
            $request->validated()
        );

        return $this->response->success(
            data: new OrderItemStatusHistoryResource($history),
            message: 'Order item status history updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        OrderItem $orderItem,
        OrderItemStatusHistory $history
    ) {
        $history->delete();

        return $this->response->noContent();
    }
}