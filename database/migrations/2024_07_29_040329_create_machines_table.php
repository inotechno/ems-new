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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('machine_type_id')->nullable()->nullOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('ip_address');
            $table->string('port')->nullable();
            $table->string('comkey')->nullable();
            $table->string('password')->nullable();
            $table->string('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
