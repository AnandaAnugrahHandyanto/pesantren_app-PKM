<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->string('kategori')->default('sekolah')->after('status');

            // Replace the (santri_id, tanggal) unique with (santri_id, tanggal, kategori)
            $table->dropUnique(['santri_id', 'tanggal']);
            $table->unique(['santri_id', 'tanggal', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropUnique(['santri_id', 'tanggal', 'kategori']);
            $table->dropColumn('kategori');
            $table->unique(['santri_id', 'tanggal']);
        });
    }
};
