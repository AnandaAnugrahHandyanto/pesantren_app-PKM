<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spp_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();
            $table->char('bulan', 2);              // 01–12
            $table->year('tahun');
            $table->decimal('jumlah', 12, 2);       // nominal SPP per bulan
            $table->enum('status', ['belum', 'lunas', 'tunggakan'])->default('belum');
            $table->foreignId('keuangan_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['siswa_id', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spp_bills');
    }
};
