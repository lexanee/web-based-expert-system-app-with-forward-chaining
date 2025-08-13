<?php

namespace Database\Seeders;

use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\Masalah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class AturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/aturan.json');
        if (!File::exists($path)) {
            $this->command?->warn("File aturan.json tidak ditemukan: {$path}");
            return;
        }

        $json = File::get($path);
        $items = json_decode($json, true);
        if (!is_array($items)) {
            $this->command?->warn('Format JSON aturan.json tidak valid');
            return;
        }

        foreach ($items as $row) {
            $kodeAturan = $row['Kode'] ?? null;
            $expr = $row['Aturan'] ?? null; // e.g. "IF G3 AND G4 THEN M4"
            if (!$kodeAturan || !$expr) continue;

            // parse expression
            $parts = preg_split('/\\s+THEN\\s+/i', $expr);
            if (count($parts) !== 2) continue;

            [$ifPart, $thenPart] = $parts;
            $ifPart = preg_replace('/^\\s*IF\\s+/i', '', trim($ifPart));
            $thenPart = trim($thenPart);

            // gejala codes split by AND
            $gejalaCodes = array_values(array_filter(array_map('trim', preg_split('/\\s+AND\\s+/i', $ifPart))));
            $masalahCode = $thenPart;

            // map codes to IDs
            $masalah = Masalah::where('kode_masalah', $masalahCode)->first();
            if (!$masalah) {
                $this->command?->warn("Masalah {$masalahCode} tidak ditemukan, lewati aturan {$kodeAturan}");
                continue;
            }

            $gejalaIds = [];
            foreach ($gejalaCodes as $gcode) {
                $g = Gejala::where('kode_gejala', $gcode)->first();
                if ($g) $gejalaIds[] = $g->id;
            }

            // Aturan table may or may not have gejala_ids column
            $data = [
                'kode_aturan' => $kodeAturan,
                'masalah_id' => $masalah->id,
            ];

            $hasGejalaIds = Schema::hasColumn('aturan', 'gejala_ids');
            if ($hasGejalaIds) {
                $data['gejala_ids'] = $gejalaIds;
            }

            // upsert based on kode_aturan
            $existing = Aturan::where('kode_aturan', $kodeAturan)->first();
            if ($existing) {
                $existing->fill($data);
                // assign gejala_ids explicitly if column exists
                if ($hasGejalaIds) {
                    $existing->gejala_ids = $gejalaIds;
                }
                $existing->save();
            } else {
                Aturan::create($data);
            }
        }

        $this->command?->info('Aturan seeded.');
    }
}
