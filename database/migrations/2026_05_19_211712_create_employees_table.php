<?php

use App\Enums\EmployeeStatus;
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
        Schema::disableForeignKeyConstraints();
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
            ->constrained('restaurants')
            ->cascadeOnDelete();

            $table->string('first_name');

            $table->string('last_name');

            $table->string('phone')->unique();

            $table->string('email')->unique();

            $table->decimal('salary', 10, 2);

            $table->date('hire_date');

            $table->enum('status',EmployeeStatus::values())
            ->default(EmployeeStatus::ACTIVE->value);

            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('employees');
    }
};