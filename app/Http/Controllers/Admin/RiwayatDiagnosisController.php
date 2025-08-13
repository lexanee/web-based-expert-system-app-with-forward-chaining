<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RiwayatDiagnosisExport;
use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\RiwayatDiagnosis;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RiwayatDiagnosisController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatDiagnosis::with(['masalah'])->latest();

        // Filter berdasarkan tipe pengguna
        if ($request->filled('tipe_pengguna')) {
            $query->where('tipe_pengguna', $request->tipe_pengguna);
        }

        // Filter berdasarkan proses
        if ($request->filled('proses')) {
            $query->where('proses', $request->proses);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $riwayat = $query->paginate(10);

        // Ambil data proses dari model Gejala
        $prosesVendor = Gejala::PROSES_VENDOR;
        $prosesInternal = Gejala::PROSES_INTERNAL;

        return view('admin.riwayat-diagnosis.index', compact('riwayat', 'prosesVendor', 'prosesInternal'));
    }

    public function show(RiwayatDiagnosis $riwayat_diagnosi)
    {
        $riwayat_diagnosi->load(['masalah']);
        $gejalaDetails = $riwayat_diagnosi->getGejalaDetails();

        return view('admin.riwayat-diagnosis.show', compact('riwayat_diagnosi', 'gejalaDetails'));
    }

    public function exportExcel(Request $request)
    {
        $query = RiwayatDiagnosis::with(['masalah'])->latest();

        // Terapkan filter yang sama seperti index
        if ($request->filled('tipe_pengguna')) {
            $query->where('tipe_pengguna', $request->tipe_pengguna);
        }

        if ($request->filled('proses')) {
            $query->where('proses', $request->proses);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        return Excel::download(new RiwayatDiagnosisExport($query->get()), 'riwayat-diagnosis-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = RiwayatDiagnosis::with(['masalah'])->latest();

        // Terapkan filter yang sama seperti index
        if ($request->filled('tipe_pengguna')) {
            $query->where('tipe_pengguna', $request->tipe_pengguna);
        }

        if ($request->filled('proses')) {
            $query->where('proses', $request->proses);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $riwayat = $query->get();

        $pdf = Pdf::loadView('admin.riwayat-diagnosis.pdf', compact('riwayat'));

        return $pdf->download('riwayat-diagnosis-' . date('Y-m-d') . '.pdf');
    }
}
