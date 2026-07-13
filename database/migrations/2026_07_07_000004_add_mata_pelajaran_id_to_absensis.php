<?php

use App\Models\MataPelajaran;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom mata_pelajaran_id (nullable dulu)
        if (!Schema::hasColumn('absensis', 'mata_pelajaran_id')) {
            Schema::table('absensis', function (Blueprint $table) {
                $table->foreignId('mata_pelajaran_id')
                    ->nullable()
                    ->after('kategori')
                    ->constrained('mata_pelajarans')
                    ->cascadeOnDelete();
            });
        }

        // 2. Migrasi data lama: ubah kategori string jadi mata_pelajaran records
        $this->migrateLegacyCategories();

        // 3. Drop FK siswa_id dulu (agar bisa drop unique index)
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
        });

        // 4. Hapus unique constraint lama
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropUnique(['siswa_id', 'tanggal', 'kategori']);
        });

        // 5. Hapus kolom kategori
        if (Schema::hasColumn('absensis', 'kategori')) {
            Schema::table('absensis', function (Blueprint $table) {
                $table->dropColumn('kategori');
            });
        }

        // 6. Force mata_pelajaran_id jadi NOT NULL setelah migrasi
        DB::statement('ALTER TABLE absensis MODIFY mata_pelajaran_id BIGINT UNSIGNED NOT NULL');

        // 7. Tambah unique constraint baru
        Schema::table('absensis', function (Blueprint $table) {
            $table->unique(['siswa_id', 'tanggal', 'mata_pelajaran_id']);
        });

        // 8. Kembalikan FK siswa_id — auto-create index
        Schema::table('absensis', function (Blueprint $table) {
            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswas')
                ->cascadeOnDelete();
        });
    }

    private function migrateLegacyCategories(): void
    {
        $map = [
            'pelajaran'          => 'Pelajaran',
            'ekstrakurikuler'    => 'Ekstrakurikuler',
            'upacara'            => 'Upacara',
            'kegiatan_khusus'    => 'Kegiatan Khusus',
            'sekolah'            => 'Sekolah',
        ];

        $legacyAbsensis = DB::table('absensis')
            ->join('siswas', 'absensis.siswa_id', '=', 'siswas.id')
            ->whereNull('absensis.mata_pelajaran_id')
            ->select('absensis.id as absensi_id', 'absensis.kategori', 'siswas.kelas')
            ->get();

        $groups = [];
        foreach ($legacyAbsensis as $row) {
            $key = $row->kategori . '|' . $row->kelas;
            if (!isset($groups[$key])) {
                $groups[$key] = [
                    'kategori' => $row->kategori,
                    'kelas' => $row->kelas,
                ];
            }
        }

        foreach ($groups as $key => $group) {
            $nama = $map[$group['kategori']] ?? ucfirst(str_replace('_', ' ', $group['kategori']));

            $mp = MataPelajaran::firstOrCreate([
                'nama' => $nama,
                'kelas' => $group['kelas'],
            ]);

            DB::table('absensis')
                ->join('siswas', 'absensis.siswa_id', '=', 'siswas.id')
                ->where('absensis.kategori', $group['kategori'])
                ->where('siswas.kelas', $group['kelas'])
                ->whereNull('absensis.mata_pelajaran_id')
                ->update(['absensis.mata_pelajaran_id' => $mp->id]);
        }
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropUnique(['siswa_id', 'tanggal', 'mata_pelajaran_id']);
        });

        if (!Schema::hasColumn('absensis', 'kategori')) {
            Schema::table('absensis', function (Blueprint $table) {
                $table->string('kategori')->default('pelajaran')->after('status');
            });
        }

        $allMp = MataPelajaran::all();
        foreach ($allMp as $mp) {
            $reverseMap = [
                'Pelajaran' => 'pelajaran',
                'Ekstrakurikuler' => 'ekstrakurikuler',
                'Upacara' => 'upacara',
                'Kegiatan Khusus' => 'kegiatan_khusus',
                'Sekolah' => 'sekolah',
            ];
            $kategori = $reverseMap[$mp->nama] ?? strtolower(str_replace(' ', '_', $mp->nama));

            DB::table('absensis')
                ->where('mata_pelajaran_id', $mp->id)
                ->update(['kategori' => $kategori]);
        }

        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['mata_pelajaran_id']);
            $table->dropColumn('mata_pelajaran_id');
            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswas')
                ->cascadeOnDelete();
            $table->unique(['siswa_id', 'tanggal', 'kategori']);
        });
    }
};
