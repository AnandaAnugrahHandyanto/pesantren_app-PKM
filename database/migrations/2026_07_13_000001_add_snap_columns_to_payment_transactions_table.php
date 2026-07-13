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
        Schema::table('payment_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('payment_transactions', 'snap_token')) {
                $table->string('snap_token')->after('external_id')->nullable();
            }
            if (!Schema::hasColumn('payment_transactions', 'currency')) {
                $table->string('currency', 3)->after('amount')->default('IDR');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('payment_transactions', 'snap_token')) {
                $table->dropColumn('snap_token');
            }
            if (Schema::hasColumn('payment_transactions', 'currency')) {
                $table->dropColumn('currency');
            }
        });
    }
};
