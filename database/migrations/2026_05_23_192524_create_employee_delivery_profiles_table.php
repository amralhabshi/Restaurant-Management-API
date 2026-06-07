<?php

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
        Schema::create('employee_delivery_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
            ->unique()
            ->constrained('employees')
            ->cascadeOnDelete();

            /**
             * عمولة التوصيل الثابتة
             */
            $table->decimal('commission_amount', 10, 2)
                ->default(0);

            /**
             * هل يعمل كمندوب حالياً
             */
            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_delivery_profiles');
    }
};
