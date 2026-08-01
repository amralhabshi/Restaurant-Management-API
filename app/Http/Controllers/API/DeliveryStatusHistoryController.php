<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryStatusHistoryRequest;
use App\Http\Requests\UpdateDeliveryStatusHistoryRequest;
use App\Http\Resources\DeliveryStatusHistoryResource;
use App\Models\Delivery;
use App\Models\DeliveryStatusHistory;
use App\Support\Http\ApiResponse;

class DeliveryStatusHistoryController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Delivery $delivery)
    {
        $histories = $delivery->statusHistories()
            ->with('employee')
            ->paginate(10);

        return DeliveryStatusHistoryResource::collection($histories);
    }

    /**
     * Store a newly created resource.
     */
    public function store(
        StoreDeliveryStatusHistoryRequest $request,
        Delivery $delivery
    ) {
        $history = $delivery->statusHistories()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new DeliveryStatusHistoryResource($history),
            message: 'Delivery status history created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Delivery $delivery,
        DeliveryStatusHistory $deliveryStatusHistory
    ) {
        $deliveryStatusHistory->load([
            'delivery',
            'employee',
        ]);

        return $this->response->success(
            data: new DeliveryStatusHistoryResource($deliveryStatusHistory)
        );
    }

    /**
     * Update the specified resource.
     */
    public function update(
        UpdateDeliveryStatusHistoryRequest $request,
        Delivery $delivery,
        DeliveryStatusHistory $deliveryStatusHistory
    ) {
        $deliveryStatusHistory->update(
            $request->validated()
        );

        return $this->response->success(
            data: new DeliveryStatusHistoryResource($deliveryStatusHistory),
            message: 'Delivery status history updated successfully.'
        );
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(
        Delivery $delivery,
        DeliveryStatusHistory $deliveryStatusHistory
    ) {
        $deliveryStatusHistory->delete();

        return $this->response->noContent();
    }
}