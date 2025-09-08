<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('citizen_id')->nullable();
            $table->integer('leave_remaining')->nullable(false)->default(0);
            $table->date('join_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('marital_status')->nullable();
            $table->string('religion')->nullable();
            $table->foreignId('position_id')->nullable();
            $table->string('whatsapp_number')->nullable();

            // Salary Components
            $table->decimal('basic_salary', 15, 2)->nullable();
            $table->decimal('allowance_pulsa', 15, 2)->nullable();
            $table->decimal('allowance_position', 15, 2)->nullable();
            $table->decimal('allowance_transport', 15, 2)->nullable();
            $table->decimal('allowance_meal', 15, 2)->nullable();
            $table->decimal('allowance_others', 15, 2)->nullable();
            $table->decimal('allowance_overtime', 15, 2)->nullable();
            $table->decimal('salary_per_day', 15, 2)->nullable();

            // Deductions
            $table->decimal('deduction_daily_report', 15, 2)->nullable()->default(25000);
            $table->decimal('deduction_late', 15, 2)->nullable()->default(50000);

            // Custom rates (can be null for default)
            $table->decimal('bpjs_kesehatan_rate', 5, 2)->nullable(); // Default: 1.00 (%)
            $table->decimal('bpjs_tk_rate', 5, 2)->nullable();        // Default: 2.00 (%)
            $table->decimal('pension_rate', 5, 2)->nullable();        // Default: 1.00 (%)
            $table->decimal('pph21_rate', 5, 2)->nullable();          // Optional override

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
