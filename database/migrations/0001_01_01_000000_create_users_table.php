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
        Schema::disableForeignKeyConstraints();
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            /**
             * الموظف المرتبط بالحساب
             */
            $table->foreignId('employee_id')
                ->unique()
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();

            /**
             * اسم المستخدم
             */
            $table->string('username')
                ->unique();

            /**
             * كلمة المرور
             */
            $table->string('password');

            /**
             * هل الحساب مفعل
             */
            $table->boolean('is_active')
                ->default(true);

            /**
             * آخر تسجيل دخول
             */
            $table->timestamp('last_login_at')
                ->nullable();

            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();

    }

    /**
     * التراجع عن migration
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
    }
};