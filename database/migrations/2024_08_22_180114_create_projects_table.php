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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete()->comment('Ambil dari table, field ini untuk project manager');
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'on_hold', 'cancelled'])->default('not_started');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
