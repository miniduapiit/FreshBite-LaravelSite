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
        Schema::table('order_items', function (Blueprint $table) {
            // product_id already exists, just update constraint
            $table->dropForeign(['product_id']);
            
            // Make product_id NOT nullable and use restrict instead of set null
            // This preserves order history by preventing product deletion if referenced
            $table->foreignId('product_id')->nullable(false)->change();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            
            // Rename product_price to unit_price for clarity
            $table->renameColumn('product_price', 'unit_price');
            
            // Add supplier_id for analytics and multi-supplier support
            $table->foreignId('supplier_id')->after('product_id')->constrained('users')->onDelete('restrict');
            
            // Remove special_instructions (moved to order level if needed)
            $table->dropColumn('special_instructions');
            
            // Add index for supplier queries
            $table->index('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropIndex(['supplier_id']);
            $table->dropColumn('supplier_id');
            $table->renameColumn('unit_price', 'product_price');
            $table->text('special_instructions')->nullable();
            
            $table->dropForeign(['product_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreignId('product_id')->nullable()->change();
        });
    }
};
