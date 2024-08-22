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
        Schema::create('request_reads', function (Blueprint $table) {
            $table->id();
            $table->string('readable_type');
            $table->unsignedBigInteger('readable_id');
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_reads');
    }
};
