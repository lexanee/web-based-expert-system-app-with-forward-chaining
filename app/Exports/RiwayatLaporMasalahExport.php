<?php

namespace App\Exports;

use App\Models\RiwayatLaporMasalah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RiwayatLaporMasalahExport implements FromCollection, WithHeadings, WithMapping
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
            'Jenis Laporan',
            'Tipe Pengguna',
            'Kontak',
            'Deskripsi',
            'Lampiran',
            'Status'
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
            $row->jenis_laporan,
            $row->tipe_pengguna,
            $row->kontak ?? '-',
            $row->deskripsi,
            $row->lampiran ? 'Ada lampiran' : '-',
            $row->status
        ];
    }
}
