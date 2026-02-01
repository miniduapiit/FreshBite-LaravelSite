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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('tracking_number')->unique()->nullable();
            $table->timestamp('estimated_delivery_time')->nullable();
            $table->timestamp('actual_delivery_time')->nullable();
            $table->enum('status', ['unassigned', 'assigned', 'out_for_delivery', 'delivered', 'failed'])->default('unassigned');
            $table->text('delivery_notes')->nullable();
            $table->timestamps();
            
            // One delivery per order
            $table->unique('order_id');
            
            // Indexes for performance
            $table->index('status');
            $table->index('driver_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
