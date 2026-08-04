<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Support\Http\ApiResponse;

class ReservationController extends Controller
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
        $reservations = Reservation::query()
            ->with([
                'employee',
                'customer',
            ])
            ->paginate(10);

        return ReservationResource::collection($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $reservation = Reservation::create(
            $request->validated()
        );

        return $this->response->created(
            data: new ReservationResource($reservation),
            message: 'Reservation created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load([
            'employee',
            'customer',
            'tables',
            'order',
        ]);

        return $this->response->success(
            data: new ReservationResource($reservation)
        );
    }

    public function confirm(Reservation $reservation)
    {
        //
    }

    public function cancel(Reservation $reservation)
    {
        //
    }

    public function convertToOrder(Reservation $reservation)
    {
        //
    }
}