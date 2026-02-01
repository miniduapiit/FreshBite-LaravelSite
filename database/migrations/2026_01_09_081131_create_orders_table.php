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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained()->onDelete('restrict');
            $table->string('order_number')->unique();
            $table->string('status')->default('pending'); // pending, confirmed, preparing, ready, delivered, cancelled
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->nullable(); // cash, card, online
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->text('delivery_address');
            $table->string('delivery_phone')->nullable();
            $table->text('special_instructions')->nullable();
            $table->timestamp('ordered_at');
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('status');
            $table->index(['user_id', 'status']);
            $table->index(['vendor_id', 'status']);
            $table->index('ordered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
