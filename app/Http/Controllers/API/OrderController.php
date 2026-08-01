<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Branch;
use App\Models\Order;
use App\Support\Http\ApiResponse;

class OrderController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Branch $branch)
    {
        $orders = $branch->orders()
            ->with([
                'employee',
                'customer',
                'table',
            ])
            ->paginate(10);

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreOrderRequest $request, Branch $branch)
    {
        $order = $branch->orders()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new OrderResource($order),
            message: 'Order created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch, Order $order)
    {
        $order->load([
            'branch',
            'employee',
            'customer',
            'table',
            'reservation',
            'orderItems',
            'invoice',
            'delivery',
        ]);

        return $this->response->success(
            data: new OrderResource($order)
        );
    }

    /**
     * Update the specified resource.
     */
    public function update(
        UpdateOrderRequest $request,
        Branch $branch,
        Order $order
    ) {
        $order->update(
            $request->validated()
        );

        return $this->response->success(
            data: new OrderResource($order),
            message: 'Order updated successfully.'
        );
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Branch $branch, Order $order)
    {
        $order->delete();

        return $this->response->noContent();
    }
}