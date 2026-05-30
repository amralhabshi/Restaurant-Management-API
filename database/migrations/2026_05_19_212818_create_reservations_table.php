<?php

use App\Enums\ReservationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('employee_id')
            ->constrained('employees')
            ->cascadeOnDelete();

            $table->foreignId('customer_id')->nullable()
            ->constrained('customers')
            ->nullOnDelete();

            /**
            * وقت بداية الحجز
            */
            $table->dateTime('start_time');

            /**
            * مدة الحجز بالدقائق
            */
            $table->unsignedInteger('duration_in_minutes');

            /**
            * وقت نهاية الحجز
            */
            $table->dateTime('end_time');

            // اجمالي السعر
            $table->decimal('total_price', 10, 2)->default(0);
            /**
            * عدد الضيوف
            */
            $table->unsignedInteger('guest_count');

            /**
            * حالة الحجز
            */
            $table->enum('status', ReservationStatus::cases())
            ->default(ReservationStatus::PENDING->value);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};