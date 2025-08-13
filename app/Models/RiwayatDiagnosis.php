<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatDiagnosis extends Model
{
    protected $table = 'riwayat_diagnosis';

    protected $fillable = [
        'tipe_pengguna',
        'proses',
        'gejala_terpilih',
        'jumlah_gejala',
        'masalah_id',
        'solusi_diberikan'
    ];

    protected $casts = [
        'gejala_terpilih' => 'array'
    ];

    public function masalah()
    {
        return $this->belongsTo(Masalah::class);
    }

    public function getGejalaDetails()
    {
        if (!$this->gejala_terpilih) {
            return collect();
        }

        // Handle both array and JSON string formats
        $gejalaIds = $this->gejala_terpilih;
        if (is_string($gejalaIds)) {
            $gejalaIds = json_decode($gejalaIds, true);
        }

        if (!is_array($gejalaIds) || empty($gejalaIds)) {
            return collect();
        }

        return Gejala::whereIn('id', $gejalaIds)->get();
    }

    // Update jumlah_gejala saat data berubah
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->gejala_terpilih) {
                $gejala = $model->gejala_terpilih;

                // Handle both array and JSON string formats
                if (is_string($gejala)) {
                    $gejala = json_decode($gejala, true);
                }

                $model->jumlah_gejala = is_array($gejala) ? count($gejala) : 0;
            } else {
                $model->jumlah_gejala = 0;
            }
        });
    }
}
