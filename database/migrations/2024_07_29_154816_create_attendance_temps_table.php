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
        Schema::create('attendance_temps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid')->nullable();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('attendance_method_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('site_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->timestamp('timestamp');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('distance')->nullable();
            $table->string('notes')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_temps');
    }
};
