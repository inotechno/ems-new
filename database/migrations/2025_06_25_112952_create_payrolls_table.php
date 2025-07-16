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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('payroll_period_id')->constrained()->onDelete('cascade');

            // Salary Components
            $table->decimal('basic_salary', 15, 2)->default(0);
            $table->decimal('allowance_pulsa', 15, 2)->default(0);
            $table->decimal('allowance_position', 15, 2)->default(0);
            $table->decimal('allowance_transport', 15, 2)->default(0);
            $table->decimal('allowance_meal', 15, 2)->default(0);
            $table->decimal('allowance_others', 15, 2)->default(0);

            // Deduction Components
            $table->decimal('deduction_pph21', 15, 2)->default(0);
            $table->decimal('deduction_bpjs_tk', 15, 2)->default(0);
            $table->decimal('deduction_bpjs_kesehatan', 15, 2)->default(0);
            $table->decimal('deduction_pension', 15, 2)->default(0);
            $table->decimal('deduction_loan', 15, 2)->default(0);
            $table->decimal('deduction_late', 15, 2)->default(0);
            $table->decimal('deduction_daily_report', 15, 2)->default(0);

            // Total
            $table->decimal('total_allowance', 15, 2)->default(0);
            $table->decimal('total_deduction', 15, 2)->default(0);
            $table->decimal('net_salary', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
