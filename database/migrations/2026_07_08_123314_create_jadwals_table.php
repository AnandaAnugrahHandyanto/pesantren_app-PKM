<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->foreignId('mata_pelajaran_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guru_id')->nullable()->constrained()->nullOnDelete();
            $table->string('kelas', 10);            // 7A, 7B, 8A, dll.
            $table->timestamps();

            // Cegah bentrok: guru tidak bisa di 2 tempat di jam yang sama
            $table->unique(['hari', 'jam_mulai', 'guru_id'], 'jadwal_guru_bentrok');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
