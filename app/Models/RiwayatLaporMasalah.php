<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatLaporMasalah extends Model
{
    protected $table = 'riwayat_lapor_masalah';

    protected $fillable = [
        'jenis_laporan',
        'deskripsi',
        'tipe_pengguna',
        'kontak',
        'lampiran',
        'status'
    ];

    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            'Baru' => 'bg-blue-100 text-blue-800',
            'Diproses' => 'bg-yellow-100 text-yellow-800',
            'Selesai' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getJenisLaporanBadgeClass()
    {
        return match ($this->jenis_laporan) {
            'Issue Teknis' => 'bg-red-100 text-red-800',
            'Bug' => 'bg-orange-100 text-orange-800',
            'Saran' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
