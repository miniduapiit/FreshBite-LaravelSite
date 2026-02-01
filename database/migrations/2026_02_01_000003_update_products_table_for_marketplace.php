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
        Schema::table('products', function (Blueprint $table) {
            // Rename vendor_id to supplier_id (references users table with role=supplier)
            $table->dropForeign(['vendor_id']);
            $table->dropIndex(['vendor_id', 'category_id']);
            $table->renameColumn('vendor_id', 'supplier_id');
        });

        Schema::table('products', function (Blueprint $table) {
            // Add foreign key for supplier_id (references users)
            $table->foreign('supplier_id')->references('id')->on('users')->onDelete('restrict');
            
            // Remove restaurant-specific columns and add marketplace fields
            $table->dropColumn(['preparation_time', 'calories', 'allergens']);
            $table->renameColumn('image', 'image_url');
            $table->renameColumn('is_available', 'is_active');
            $table->dropColumn('is_featured');
            
            // Add approval workflow columns
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('is_active');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('approval_status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            
            // Add soft deletes for preserving order history
            $table->softDeletes();
            
            // Update indexes
            $table->index('is_active');
            $table->index('approval_status');
            $table->index(['supplier_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['supplier_id']);
            $table->dropIndex(['supplier_id', 'category_id']);
            $table->dropIndex(['approval_status']);
            $table->dropColumn(['approval_status', 'approved_by', 'approved_at']);
            $table->renameColumn('is_active', 'is_available');
            $table->renameColumn('image_url', 'image');
            $table->boolean('is_featured')->default(false);
            $table->integer('preparation_time')->nullable();
            $table->integer('calories')->nullable();
            $table->text('allergens')->nullable();
            $table->renameColumn('supplier_id', 'vendor_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->index(['vendor_id', 'category_id']);
        });
    }
};
