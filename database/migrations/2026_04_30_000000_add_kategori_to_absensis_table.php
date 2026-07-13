<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    if (!Schema::hasColumn('absensis', 'kategori')) {
        Schema::table('absensis', function (Blueprint $table) {
            $table->string('kategori')->default('sekolah')->after('status');
        });

        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropUnique(['siswa_id', 'tanggal']);

            $table->unique(['siswa_id', 'tanggal', 'kategori']);

            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswas')
                ->cascadeOnDelete();
        });
    }
}

    public function down(): void
    {
        if (Schema::hasColumn('absensis', 'kategori')) {
            Schema::table('absensis', function (Blueprint $table) {
                $table->dropUnique(['siswa_id', 'tanggal', 'kategori']);
                $table->dropColumn('kategori');
                $table->unique(['siswa_id', 'tanggal']);
            });
        }
    }
};
