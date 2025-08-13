<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    protected $table = 'gejala';

    protected $fillable = [
        'kode_gejala',
        'nama_gejala',
        'tipe_pengguna',
        'proses'
    ];

    /**
     * Konstanta untuk daftar proses berdasarkan tipe pengguna
     */
    public const PROSES_VENDOR = [
        'Registration',
        'Invited/Join',
        'Prequalification',
        'Quotation',
        'Technical Clarification',
        'Negotiation',
        'Awarding'
    ];

    public const PROSES_INTERNAL = [
        'Receive RFM/S',
        'Assign Teams',
        'Setup',
        'Invite Vendor',
        'Setup PQ',
        'PQ Evaluation',
        'Setup RFQ',
        'Bid Opening',
        'Technical Evaluation',
        'Commercial Evaluation',
        'Negotiation',
        'Award Recommendation Approval',
        'Final Evaluation Result',
        'Awarding'
    ];

    /**
     * Mendapatkan daftar proses berdasarkan tipe pengguna
     */
    public static function getProsesByTipe($tipePengguna)
    {
        return match ($tipePengguna) {
            'Vendor' => self::PROSES_VENDOR,
            'Internal' => self::PROSES_INTERNAL,
            default => []
        };
    }

    public function aturan()
    {
        return $this->belongsToMany(Aturan::class, 'gejala_id', 'aturan_id');
    }
}
