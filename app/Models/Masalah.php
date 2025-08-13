<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masalah extends Model
{
    protected $table = 'masalah';

    protected $fillable = [
        'kode_masalah',
        'nama_masalah',
        'solusi'
    ];

    public function aturan()
    {
        return $this->hasMany(Aturan::class);
    }
}