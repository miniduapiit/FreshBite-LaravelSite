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
        Schema::table('orders', function (Blueprint $table) {
            // Drop vendor_id as orders can have items from multiple suppliers
            $table->dropForeign(['vendor_id']);
            $table->dropIndex(['vendor_id', 'status']);
            $table->dropColumn('vendor_id');
            
            // Remove payment fields (will have separate payments table)
            $table->dropColumn(['payment_method', 'payment_status']);
            
            // Remove redundant amount columns
            $table->dropColumn(['subtotal', 'tax_amount', 'delivery_fee', 'discount_amount']);
            
            // Rename and update status values
            $table->dropColumn('status');
            $table->enum('status', ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'])->default('pending')->after('order_number');
            
            // Rename ordered_at to order_date and make it fillable
            $table->renameColumn('ordered_at', 'order_date');
            
            // Remove unnecessary columns
            $table->dropColumn(['delivery_phone', 'special_instructions', 'delivered_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('vendor_id')->after('user_id')->constrained()->onDelete('restrict');
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->dropColumn('status');
            $table->string('status')->default('pending');
            $table->renameColumn('order_date', 'ordered_at');
            $table->string('delivery_phone')->nullable();
            $table->text('special_instructions')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->index(['vendor_id', 'status']);
        });
    }
};
