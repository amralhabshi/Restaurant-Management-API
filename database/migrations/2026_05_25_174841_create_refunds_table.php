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
        Schema::create('refunds', function (Blueprint $table) {

            $table->id();

            /**
             * الفاتورة المرتبط بها الاسترجاع
             */
            $table->foreignId('invoice_id')
                ->constrained('invoices')
                ->cascadeOnDelete();

            /**
             * الموظف الذي قام بالاسترجاع
             */
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            /**
             * العميل (اختياري)
             */
            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('customers')
                ->nullOnDelete();

            /**
             * رقم عملية الاسترجاع
             */
            $table->string('refund_number')
                ->unique();

            /**
             * المبلغ المسترجع
             */
            $table->decimal('amount', 10, 2);

            /**
             * سبب الاسترجاع
             */
            $table->string('reason');

            /**
             * ملاحظات إضافية
             */
            $table->text('notes')
                ->nullable();

            /**
             * وقت تنفيذ الاسترجاع
             */
            $table->timestamp('refunded_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};