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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('name');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_url')->nullable();
            $table->string('qrcode_path')->nullable();
            $table->string('qrcode_url')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
