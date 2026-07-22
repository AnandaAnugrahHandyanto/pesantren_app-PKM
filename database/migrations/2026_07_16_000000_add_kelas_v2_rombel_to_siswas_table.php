<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('siswas', function (Blueprint $table) {
            if (!Schema::hasColumn('siswas', 'kelas_v2')) {
                $table->tinyInteger('kelas_v2')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'rombel')) {
                $table->string('rombel', 5)->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn(['kelas_v2', 'rombel']);
        });
    }
};
