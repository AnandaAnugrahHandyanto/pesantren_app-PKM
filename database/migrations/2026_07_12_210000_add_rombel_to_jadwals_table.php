<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('jadwals', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwals', 'rombel')) {
                $table->string('rombel', 5)->after('kelas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('jadwals', function (Blueprint $table) {
            if (Schema::hasColumn('jadwals', 'rombel')) {
                $table->dropColumn('rombel');
            }
        });
    }
};
