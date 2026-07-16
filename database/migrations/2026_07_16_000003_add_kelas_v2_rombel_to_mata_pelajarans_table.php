<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->tinyInteger('kelas_v2')->nullable();
            $table->string('rombel', 5)->nullable();
        });
    }

    public function down()
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->dropColumn(['kelas_v2', 'rombel']);
        });
    }
};
