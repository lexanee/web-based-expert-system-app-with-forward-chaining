<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    protected $table = 'aturan';

    protected $fillable = [
        'kode_aturan',
        'masalah_id',
        'gejala_ids'
    ];

    protected $casts = [
        'gejala_ids' => 'array'
    ];

    public function masalah()
    {
        return $this->belongsTo(Masalah::class);
    }

    // Accessor untuk mendapatkan gejala sebagai collection
    public function getGejalaAttribute()
    {
        if (!$this->gejala_ids) {
            return collect();
        }

        return Gejala::whereIn('id', $this->gejala_ids)->get();
    }

    // Method untuk mendapatkan gejala (untuk compatibility)
    public function getGejalaDetails()
    {
        if (!$this->gejala_ids) {
            return collect();
        }

        return Gejala::whereIn('id', $this->gejala_ids)->get();
    }

    public function hasGejala($gejalaIds)
    {
        if (!$this->gejala_ids || !$gejalaIds) {
            return false;
        }

        $ruleGejalaIds = collect($this->gejala_ids);
        $selectedGejalaIds = collect($gejalaIds);

        // Check if all rule symptoms are selected
        return $ruleGejalaIds->diff($selectedGejalaIds)->isEmpty();
    }
}
