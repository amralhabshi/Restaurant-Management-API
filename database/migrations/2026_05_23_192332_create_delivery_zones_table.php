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
        Schema::create('delivery_zones', function (Blueprint $table) {

            $table->id();

            /**
             * الفرع التابع له المنطقة
             */
            $table->foreignId('branch_id')
            ->constrained('branches')
            ->cascadeOnDelete();

            /**
             * اسم المنطقة
             */
            $table->string('name');

            /**
             * وصف المنطقة
             */
            $table->text('description')
                ->nullable();

            /**
             * رسوم التوصيل
             */
            $table->decimal('delivery_fee', 10, 2)
                ->default(0);

            $table->timestamps();
        });
    }

    /**
     * التراجع عن migration
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_zones');
    }
};