<?php

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('invoice_id')
            ->constrained('invoices')
            ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);

            $table->enum('method',PaymentMethod::values())
            ->default(PaymentMethod::CASH->value);
            
            $table->enum('status',PaymentStatus::values())
            ->default(PaymentStatus::PENDING->value);

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};