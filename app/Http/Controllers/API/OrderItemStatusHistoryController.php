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
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem,OrderItemStatusHistory $history) 
    {
        $history->load([
            'orderItem',
            'employee',
        ]);

        return $this->response->success(
            data: new OrderItemStatusHistoryResource($history)
        );
    }
}