<?php

namespace App\Exports;

use App\Models\RiwayatDiagnosis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RiwayatDiagnosisExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Tipe Pengguna',
            'Proses',
            'Jumlah Gejala',
            'Kode Masalah',
            'Nama Masalah',
            'Solusi'
        ];
    }

    /**
     * @param mixed $row
     */
    public function map($row): array
    {
        static $no = 1;

        return [
            $no++,
            $row->created_at->format('d/m/Y H:i'),
            $row->tipe_pengguna,
            $row->proses ?? '-',
            $row->jumlah_gejala ?? 0,
            $row->masalah ? $row->masalah->kode_masalah : '-',
            $row->masalah ? $row->masalah->nama_masalah : 'Tidak ada masalah terdeteksi',
            $row->solusi_diberikan ?? '-'
        ];
    }
}
