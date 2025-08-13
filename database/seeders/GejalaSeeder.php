<?php

namespace Database\Seeders;

use App\Models\Gejala;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class GejalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/gejala.json');
        if (!File::exists($path)) {
            $this->command?->warn("File gejala.json tidak ditemukan: {$path}");
            return;
        }

        $json = File::get($path);
        $items = json_decode($json, true);
        if (!is_array($items)) {
            $this->command?->warn('Format JSON gejala.json tidak valid');
            return;
        }

        foreach ($items as $row) {
            $kode = $row['Kode'] ?? null;
            if (!$kode) continue;

            Gejala::updateOrCreate(
                ['kode_gejala' => $kode],
                [
                    'kode_gejala' => $kode,
                    'nama_gejala' => $row['Nama Gejala'] ?? '',
                    'tipe_pengguna' => $row['Tipe Pengguna'] ?? 'Vendor',
                    'proses' => $row['Proses'] ?? null,
                ]
            );
        }

        $this->command?->info('Gejala seeded.');
    }
}
