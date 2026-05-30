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
        Schema::create('delivery_status_histories', function (Blueprint $table) {

            $table->id();

            /**
             * عملية التوصيل
             */
            $table->foreignId('delivery_id')
                ->constrained('deliveries')
                ->cascadeOnDelete();

            /**
             * الموظف الذي غيّر الحالة
             */
            $table->foreignId('employee_id')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();

            /**
             * الحالة القديمة
             */
            $table->string('old_status')
                ->nullable();

            /**
             * الحالة الجديدة
             */
            $table->string('new_status');

            /**
             * ملاحظات
             */
            $table->text('notes')
                ->nullable();

            /**
             * وقت تغيير الحالة
             */
            $table->timestamp('changed_at');

            $table->timestamps();
        });
    }

    /**
     * التراجع عن migration
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_status_histories');
    }
};