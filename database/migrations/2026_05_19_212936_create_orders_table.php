<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
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
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            // الموظف
            $table->foreignId('employee_id')
            ->constrained('employees')
            ->cascadeOnDelete();

            // الزبون
            $table->foreignId('customer_id')->nullable()
            ->constrained('customers')
            ->nullOnDelete();

            // الطلبات تتبع الفرع
            $table->foreignId('branch_id')
            ->constrained('branches')
            ->restrictOnDelete();

            // الطاولات 
            $table->foreignId('table_id')->nullable()
            ->constrained('tables')
            ->nullOnDelete();

            // حجوزات الطاولات
            $table->foreignId('reservation_id')
            ->nullable()
            ->constrained('reservations')
            ->nullOnDelete();

            $table->string('order_number')->unique();

            $table->enum('type', OrderType::cases())
            ->default(OrderType::DINE_IN->value);

            $table->enum('status',OrderStatus::cases())
            ->default(OrderStatus::PENDING->value);

            $table->decimal('total_price', 10, 2)->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};