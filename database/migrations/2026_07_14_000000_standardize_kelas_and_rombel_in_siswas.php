<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Data has been manually cleaned to split '7A' -> kelas='7', rombel='A'
        // This migration ensures structure consistency.
        Schema::table('siswas', function (Blueprint $table) {
            // Ensure columns exist and are correct types
            $table->string('kelas')->change();
            $table->string('rombel')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Not easily reversible without data loss (re-merging kelas+rombel)
    }
};
