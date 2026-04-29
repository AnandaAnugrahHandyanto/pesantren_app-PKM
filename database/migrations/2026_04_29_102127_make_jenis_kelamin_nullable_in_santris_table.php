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
        Schema::table('santris', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->change();
            $table->string('kamar')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable(false)->change();
            $table->string('kamar')->nullable(false)->change();
        });
    }
};
