<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        $database = DB::getDatabaseName();

        $oldIndexExists = DB::table('information_schema.statistics')
            ->where('table_schema', $database)
            ->where('table_name', 'absensis')
            ->where('index_name', 'absensis_santri_id_tanggal_unique')
            ->exists();

        if ($oldIndexExists) {
            Schema::table('absensis', function (Blueprint $table): void {
                $table->dropUnique('absensis_santri_id_tanggal_unique');
            });
        }

        $newIndexExists = DB::table('information_schema.statistics')
            ->where('table_schema', $database)
            ->where('table_name', 'absensis')
            ->where('index_name', 'absensis_santri_id_tanggal_kategori_unique')
            ->exists();

        if (! $newIndexExists) {
            Schema::table('absensis', function (Blueprint $table): void {
                $table->unique(['santri_id', 'tanggal', 'kategori'], 'absensis_santri_id_tanggal_kategori_unique');
            });
        }
    }

    public function down(): void
    {
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        $database = DB::getDatabaseName();

        $newIndexExists = DB::table('information_schema.statistics')
            ->where('table_schema', $database)
            ->where('table_name', 'absensis')
            ->where('index_name', 'absensis_santri_id_tanggal_kategori_unique')
            ->exists();

        if ($newIndexExists) {
            Schema::table('absensis', function (Blueprint $table): void {
                $table->dropUnique('absensis_santri_id_tanggal_kategori_unique');
            });
        }

        $oldIndexExists = DB::table('information_schema.statistics')
            ->where('table_schema', $database)
            ->where('table_name', 'absensis')
            ->where('index_name', 'absensis_santri_id_tanggal_unique')
            ->exists();

        if (! $oldIndexExists) {
            Schema::table('absensis', function (Blueprint $table): void {
                $table->unique(['santri_id', 'tanggal'], 'absensis_santri_id_tanggal_unique');
            });
        }
    }
};
