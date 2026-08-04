<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Http\Resources\DeliveryResource;
use App\Models\Delivery;
use App\Models\Order;
use App\Support\Http\ApiResponse;

class DeliveryController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveries = Delivery::query()
            ->with([
                'order',
                'employee',
                'deliveryZone',
            ])
            ->paginate(10);

        return DeliveryResource::collection($deliveries);
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreDeliveryRequest $request,Order $order) 
    {
        $delivery = $order->delivery()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new DeliveryResource($delivery),
            message: 'Delivery created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
        $delivery->load([
            'order',
            'employee',
            'deliveryZone',
            'statusHistories',
        ]);

        return $this->response->success(
            data: new DeliveryResource($delivery)
        );
    }

    public function assignEmployee(Delivery $delivery)
    {
        //
    }

    public function changeStatus(Delivery $delivery)
    {
        //
    }
}