<?php

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
        Schema::create('delivery_zone_employee', function (Blueprint $table) {

            /**
             * الموظف (المندوب)
             */
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            /**
             * منطقة التوصيل
             */
            $table->foreignId('delivery_zone_id')
                ->constrained('delivery_zones')
                ->cascadeOnDelete();

            /**
             * مفتاح أساسي مركب
             */
            $table->primary([
                'employee_id',
                'delivery_zone_id',
            ]);
        });
    }

    /**
     * التراجع عن migration
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_zone_employee');
    }
};