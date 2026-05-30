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
        Schema::create('reservation_table', function (Blueprint $table) {

            $table->id();

            /**
             * الحجز
             */
            $table->foreignId('reservation_id')
                ->constrained('reservations')
                ->cascadeOnDelete();

            /**
             * الطاولة
             */
            $table->foreignId('table_id')
            ->constrained('tables')
            ->cascadeOnDelete();

            /**
             * منع تكرار نفس الطاولة داخل نفس الحجز
             */
            $table->unique([
                'reservation_id',
                'table_id',
            ]);
        });
    }

    /**
     * التراجع عن migration
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_table');
    }
};