<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->tinyInteger('tingkat')->nullable()->after('kelas');
            $table->char('jurusan', 1)->nullable()->after('tingkat');
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn(['tingkat', 'jurusan']);
        });
    }
};