<?php

use App\Enums\DeliveryStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل migration
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('deliveries', function (Blueprint $table) {

            $table->id();

            /**
             * الطلب المرتبط بالتوصيل
             */
            $table->foreignId('order_id')
            ->unique()
            ->constrained('orders')
            ->cascadeOnDelete();

            /**
             * المندوب المسؤول
             */
            $table->foreignId('employee_id')
            ->nullable()
            ->constrained('employees')
            ->nullOnDelete();

            /**
             * منطقة التوصيل
             */
            $table->foreignId('delivery_zone_id')
            ->nullable()
            ->constrained('delivery_zones')
            ->nullOnDelete();

            /**
             * بيانات العميل وقت التوصيل
             */
            $table->string('customer_name');

            $table->string('customer_phone');

            $table->text('customer_address');

            /**
             * عنوان التوصيل النهائي
             */
            $table->text('delivery_address');

            /**
             * حالة التوصيل
             */
            $table->enum('status', DeliveryStatus::values())
            ->default(DeliveryStatus::PENDING->value);

            /**
             * حالة الدفع
             */
            $table->enum('payment_status', PaymentStatus::values())
            ->default(PaymentStatus::PENDING->value);

            /**
             * هل استلم المندوب المبلغ
             */
            $table->boolean('cash_collected')->default(false);

            /**
             * وقت استلام الطلب من المطعم
             */
            $table->timestamp('picked_up_at')->nullable();

            /**
             * وقت تسليم الطلب للعميل
             */
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * التراجع عن migration
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('deliveries');
    }
};