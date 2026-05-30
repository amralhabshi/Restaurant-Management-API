<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();

            $table->foreignId('order_id')
            ->constrained('orders')
            ->cascadeOnDelete();

            $table->string('invoice_number')->unique();

            $table->decimal('subtotal', 10, 2);

            $table->decimal('tax', 10, 2)->default(0);

            $table->decimal('discount', 10, 2)->default(0);

            $table->decimal('total', 10, 2);

            /**
             * إجمالي المبالغ المسترجعة
             */
            $table->decimal('refunded_total', 10, 2)->default(0);

            $table->timestamp('issued_at')->nullable();

             /**
             * رسوم التوصيل
             */
            $table->decimal('delivery_fee', 10, 2)
            ->default(0)
            ->after('discount');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};