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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_inventory_id')->constrained()->cascadeOnDelete();
            $table->foreignId('status_id')->nullable()->constrained('status_inventories')->nullOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_url')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('qr_code_url')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('price', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
