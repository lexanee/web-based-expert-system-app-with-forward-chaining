<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RiwayatLaporMasalahExport;
use App\Http\Controllers\Controller;
use App\Models\RiwayatLaporMasalah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RiwayatLaporMasalahController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatLaporMasalah::latest();

        // Filter berdasarkan jenis laporan
        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->jenis_laporan);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tipe pengguna
        if ($request->filled('tipe_pengguna')) {
            $query->where('tipe_pengguna', $request->tipe_pengguna);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $laporan = $query->paginate(10);

        return view('admin.riwayat-lapor-masalah.index', compact('laporan'));
    }

    public function show(RiwayatLaporMasalah $riwayat_lapor_masalah)
    {
        return view('admin.riwayat-lapor-masalah.show', ['laporan' => $riwayat_lapor_masalah]);
    }

    public function updateStatus(Request $request, RiwayatLaporMasalah $riwayatLaporMasalah)
    {
        $request->validate([
            'status' => 'required|in:Baru,Diproses,Selesai'
        ]);

        $riwayatLaporMasalah->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function exportExcel(Request $request)
    {
        $query = RiwayatLaporMasalah::latest();

        // Terapkan filter yang sama seperti di index
        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->jenis_laporan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipe_pengguna')) {
            $query->where('tipe_pengguna', $request->tipe_pengguna);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        return Excel::download(new RiwayatLaporMasalahExport($query->get()), 'riwayat-lapor-masalah-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = RiwayatLaporMasalah::latest();

        // Terapkan filter yang sama seperti di index
        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->jenis_laporan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipe_pengguna')) {
            $query->where('tipe_pengguna', $request->tipe_pengguna);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $laporan = $query->get();

        $pdf = Pdf::loadView('admin.riwayat-lapor-masalah.pdf', compact('laporan'));

        return $pdf->download('riwayat-lapor-masalah-' . date('Y-m-d') . '.pdf');
    }

    public function exportSinglePdf(RiwayatLaporMasalah $riwayatLaporMasalah)
    {
        $laporan = collect([$riwayatLaporMasalah]); // Ubah item tunggal menjadi koleksi
        $single = true; // Flag untuk menandakan laporan tunggal

        $pdf = Pdf::loadView('admin.riwayat-lapor-masalah.pdf', compact('laporan', 'single'));

        return $pdf->download('riwayat-lapor-masalah-detail-' . $riwayatLaporMasalah->id . '-' . date('Y-m-d') . '.pdf');
    }
}
