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
        Schema::create('financial_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('financial_type_id')->nullable()->nullOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->decimal('amount', 16, 2);
            $table->text('notes')->nullable();
            $table->text('receipt_image_path')->nullable();
            $table->text('receipt_image_url')->nullable();
            $table->boolean('is_approved')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_requests');
    }
};
