<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('spp_bill_id')->constrained('spp_bills')->onDelete('cascade');
            $table->string('external_id')->unique()->nullable(); // ID dari Payment Gateway
            $table->decimal('amount', 15, 2);
            $table->string('channel')->nullable(); // VA, E-Wallet, QRIS
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'cancelled', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->json('metadata')->nullable(); // Respon mentah dari gateway
            $table->timestamps();
            
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
