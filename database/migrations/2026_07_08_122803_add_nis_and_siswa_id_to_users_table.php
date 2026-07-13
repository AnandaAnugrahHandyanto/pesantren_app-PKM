<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nis', 50)->nullable()->unique()->after('name');
            $table->foreignId('siswa_id')->nullable()->constrained('siswas')->nullOnDelete()->after('nis');
        });

        // Make email nullable for siswa
        DB::statement("ALTER TABLE users MODIFY COLUMN email VARCHAR(255) NULL");

        // Extend role enum to include 'siswa'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','guru','siswa') NOT NULL DEFAULT 'guru'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','guru') NOT NULL DEFAULT 'guru'");
        DB::statement("ALTER TABLE users MODIFY COLUMN email VARCHAR(255) NOT NULL");

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['nis', 'siswa_id']);
        });
    }
};
