<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if santris table exists (from old schema)
        if (Schema::hasTable('santris')) {
            // Rename table from santris to siswas
            Schema::rename('santris', 'siswas');
            
            // Rename foreign key constraint in absensis table
            try {
                Schema::table('absensis', function (Blueprint $table) {
                    // Drop old FK if exists
                    $table->dropForeign(['santri_id']);
                });
            } catch (\Exception $e) {
                // FK might not exist, ignore
            }
            
            // Rename column
            Schema::table('absensis', function (Blueprint $table) {
                $table->renameColumn('santri_id', 'siswa_id');
            });
            
            // Re-add FK with new name
            Schema::table('absensis', function (Blueprint $table) {
                $table->foreign('siswa_id')->references('id')->on('siswas')->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse FK
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
        });
        
        // Rename column back
        Schema::table('absensis', function (Blueprint $table) {
            $table->renameColumn('siswa_id', 'santri_id');
        });
        
        // Re-add old FK
        Schema::table('absensis', function (Blueprint $table) {
            $table->foreign('santri_id')->references('id')->on('santris')->cascadeOnDelete();
        });
        
        // Rename table back
        Schema::rename('siswas', 'santris');
    }
};
