<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\ReservationToOrderService;

class ReservationController extends Controller
{
    public function convert($id, ReservationToOrderService $service)
    {
        $reservation = Reservation::with('tables')->findOrFail($id);

        $order = $service->convert($reservation);

        return response()->json([
            'message' => 'Reservation converted successfully',
            'order_id' => $order->id
        ]);
    }
}