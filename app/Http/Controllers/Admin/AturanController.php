<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aturan;
use App\Models\Masalah;
use App\Models\Gejala;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AturanController extends Controller
{
    /**
     * Menampilkan daftar resource.
     */
    public function index(Request $request)
    {
        $query = Aturan::with(['masalah'])->latest();

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $aturan = $query->paginate(10);
        return view('admin.aturan.index', compact('aturan'));
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     */
    public function create()
    {
        $masalah = Masalah::all();
        $gejala = Gejala::all();
        return view('admin.aturan.create', compact('masalah', 'gejala'));
    }

    /**
     * Menyimpan resource yang baru dibuat ke storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_aturan' => 'required|string|unique:aturan,kode_aturan',
            'masalah_id' => 'required|exists:masalah,id',
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'exists:gejala,id',
        ]);

        $aturan = Aturan::create([
            'kode_aturan' => $request->kode_aturan,
            'masalah_id' => $request->masalah_id,
            'gejala_ids' => $request->gejala,
        ]);

        return redirect()->route('admin.aturan.index')->with('success', 'Aturan berhasil ditambahkan.');
    }

    /**
     * Menampilkan resource yang spesifik.
     */
    public function show(Aturan $aturan)
    {
        $aturan->load(['masalah']);
        return view('admin.aturan.show', compact('aturan'));
    }

    /**
     * Menampilkan form untuk mengedit resource yang spesifik.
     */
    public function edit(Aturan $aturan)
    {
        $masalah = Masalah::all();
        $gejala = Gejala::all();
        $aturan->load(['masalah']);
        return view('admin.aturan.edit', compact('aturan', 'masalah', 'gejala'));
    }

    /**
     * Memperbarui resource yang spesifik di storage.
     */
    public function update(Request $request, Aturan $aturan)
    {
        $request->validate([
            'kode_aturan' => 'required|string|unique:aturan,kode_aturan,' . $aturan->id,
            'masalah_id' => 'required|exists:masalah,id',
            'gejala' => 'required|array|min:1',
            'gejala.*' => 'exists:gejala,id',
        ]);

        $aturan->update([
            'kode_aturan' => $request->kode_aturan,
            'masalah_id' => $request->masalah_id,
            'gejala_ids' => $request->gejala,
        ]);

        return redirect()->route('admin.aturan.index')->with('success', 'Aturan berhasil diperbarui.');
    }

    /**
     * Menghapus resource yang spesifik dari storage.
     */
    public function destroy(Aturan $aturan)
    {
        $aturan->delete();
        return redirect()->route('admin.aturan.index')->with('success', 'Aturan berhasil dihapus.');
    }

    /**
     * Export PDF untuk laporan aturan
     */
    public function exportPdf(Request $request)
    {
        $query = Aturan::with(['masalah'])->latest();

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $aturan = $query->get();

        $pdf = Pdf::loadView('admin.aturan.pdf', compact('aturan'));

        return $pdf->download('laporan-daftar-aturan-' . date('Y-m-d') . '.pdf');
    }
}
