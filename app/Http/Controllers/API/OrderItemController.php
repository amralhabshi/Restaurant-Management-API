<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Support\Http\ApiResponse;

class OrderItemController extends Controller
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
        $orderItems = $order->orderItems()
            ->with('menuItem')
            ->paginate(10);

        return OrderItemResource::collection($orderItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderItemRequest $request,Order $order) 
    {
        $orderItem = $order->orderItems()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new OrderItemResource($orderItem),
            message: 'Order item created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order,OrderItem $orderItem) 
    {
        $orderItem->load([
            'order',
            'menuItem',
            'statusHistories',
        ]);

        return $this->response->success(
            data: new OrderItemResource($orderItem)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemRequest $request,Order $order,OrderItem $orderItem) 
    {
        $orderItem->update(
            $request->validated()
        );

        return $this->response->success(
            data: new OrderItemResource($orderItem),
            message: 'Order item updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order,OrderItem $orderItem) 
    {
        $orderItem->delete();

        return $this->response->noContent();
    }

    public function changeStatus(Order $order)
    {
        //
    }
}