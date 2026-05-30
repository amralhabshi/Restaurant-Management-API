<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderType;
use App\Enums\OrderItemType;
use Illuminate\Support\Facades\DB;

class ReservationToOrderService
{
    public function convert(Reservation $reservation): Order
    {
        return DB::transaction(function () use ($reservation) {

            // 1. منع التحويل المكرر
            if ($reservation->isConverted()) {
                throw new \Exception('Reservation already converted');
            }

            // 2. إنشاء الطلب
            $order = Order::create([
                'employee_id' => $reservation->employee_id,
                'customer_id' => $reservation->customer_id,
                'branch_id' => $reservation->tables->first()->branch_id ?? null,
                'reservation_id' => $reservation->id,
                'order_number' => 'ORD-' . time(),
                'type' => OrderType::DINE_IN,
                'status' => 'pending',
                'total_price' => 0,
            ]);

            // 3. ربط الطاولات (اختياري للعرض)
            foreach ($reservation->tables as $table) {
                $order->table_id = $table->id;
                $order->save();
            }

            // 4. حساب سعر الحجز
            $reservationFee = $this->calculateReservationFee($reservation);

            // 5. إضافة رسوم الحجز كـ OrderItem
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => null,
                'quantity' => 1,
                'unit_price' => $reservationFee,
                'type' => OrderItemType::RESERVATION_FEE,
                'notes' => 'Reservation Fee',
            ]);

            // 6. تحديث إجمالي الطلب
            $order->update([
                'total_price' => $order->orderItems()->sum('unit_price'),
            ]);

            return $order;
        });
    }

    /**
     * حساب رسوم الحجز
     */
    private function calculateReservationFee(Reservation $reservation): float
    {
        $total = 0;

        foreach ($reservation->tables as $table) {
            $total += $table->price;
        }

        $hours = $reservation->duration_in_minutes / 60;

        return $total * $hours;
    }
}