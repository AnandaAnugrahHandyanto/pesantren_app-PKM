<?php

namespace App\Console\Commands;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateSiswaUsers extends Command
{
    protected $signature = 'siswa:generate-users {--password=siswa123}';
    protected $description = 'Generate akun user untuk semua siswa yang belum punya akun';

    public function handle(): void
    {
        $password = $this->option('password');
        $siswaWithoutUser = Siswa::whereDoesntHave('user')->get();

        if ($siswaWithoutUser->isEmpty()) {
            $this->info('✅ Semua siswa sudah punya akun user.');
            return;
        }

        $bar = $this->output->createProgressBar($siswaWithoutUser->count());
        $bar->start();

        $created = 0;
        foreach ($siswaWithoutUser as $siswa) {
            $nis = $siswa->nis ?? 'NIS-' . str_pad((string) $siswa->id, 6, '0', STR_PAD_LEFT);

            User::create([
                'name' => $siswa->nama_lengkap,
                'nis' => $nis,
                'email' => null,
                'email_verified_at' => now(),
                'password' => $password,
                'role' => 'siswa',
                'siswa_id' => $siswa->id,
            ]);

            $created++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Berhasil generate {$created} akun siswa.");
        $this->warn("⚠️  Password default: {$password}");
        $this->warn("⚠️  Login menggunakan NIS sebagai username.");
    }
}
