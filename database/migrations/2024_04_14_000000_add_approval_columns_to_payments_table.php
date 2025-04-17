<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop the existing enum constraint for payment_method
            $table->string('payment_method')->change();
            
            // Add new columns
            $table->string('payment_proof')->after('notes');
            $table->string('status')->default('pending')->after('payment_proof');
            $table->timestamp('approved_at')->nullable()->after('status');
            $table->foreignId('approved_by')->nullable()->after('approved_at')
                  ->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable()->after('approved_by');
            
            // Remove the soft delete column if not needed
            $table->dropSoftDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Restore the enum constraint
            $table->enum('payment_method', ['cash', 'bank_transfer', 'mobile_money'])->change();
            
            // Remove the new columns
            $table->dropColumn([
                'payment_proof',
                'status',
                'approved_at',
                'approved_by',
                'rejection_reason'
            ]);
            
            // Restore soft deletes if you want to roll back
            $table->softDeletes();
        });
    }
};