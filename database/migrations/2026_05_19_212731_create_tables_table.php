<?php

use App\Enums\TableStatus;
use App\Enums\TableType;
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
        Schema::create('tables', function (Blueprint $table) {

            $table->id();

            $table->foreignId('branch_id')
            ->constrained('branches')
            ->cascadeOnDelete();

            $table->string('table_number');

            /**
            * نوع الطاولة
            */
            $table->enum('type', TableType::cases())
            ->default(TableType::STANDARD->value);
                
            // عدد الاشخاص
            $table->unsignedInteger('capacity');


            /**
            * سعر الطاولة
            */
            $table->decimal('price', 10, 2)->default(0);

            // حالة الطاولة
            $table->enum('status',TableStatus::cases())
            ->default(TableStatus::ACTIVE->value);
            $table->timestamps();

            $table->unique([
                'branch_id',
                'table_number'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};