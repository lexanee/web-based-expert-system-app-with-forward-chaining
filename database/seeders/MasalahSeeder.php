<?php

namespace Database\Seeders;

use App\Models\Masalah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MasalahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/masalah.json');
        if (!File::exists($path)) {
            $this->command?->warn("File masalah.json tidak ditemukan: {$path}");
            return;
        }

        $json = File::get($path);
        $items = json_decode($json, true);
        if (!is_array($items)) {
            $this->command?->warn('Format JSON masalah.json tidak valid');
            return;
        }

        foreach ($items as $row) {
            $kode = $row['Kode'] ?? null;
            if (!$kode) continue;

            Masalah::updateOrCreate(
                ['kode_masalah' => $kode],
                [
                    'kode_masalah' => $kode,
                    'nama_masalah' => $row['Nama Masalah'] ?? '',
                    'solusi' => $row['Solusi'] ?? '',
                ]
            );
        }

        $this->command?->info('Masalah seeded.');
    }
}
