<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masalah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MasalahController extends Controller
{
    /**
     * Menampilkan daftar resource.
     */
    public function index(Request $request)
    {
        $query = Masalah::latest();

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $masalah = $query->paginate(10);
        return view('admin.masalah.index', compact('masalah'));
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     */
    public function create()
    {
        return view('admin.masalah.create');
    }

    /**
     * Menyimpan resource yang baru dibuat ke dalam storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_masalah' => 'required|string|unique:masalah,kode_masalah',
            'nama_masalah' => 'required|string',
            'solusi' => 'required|string',
        ]);
        Masalah::create($request->all());
        return redirect()->route('admin.masalah.index')->with('success', 'Masalah berhasil ditambahkan.');
    }

    /**
     * Menampilkan resource yang spesifik.
     */
    public function show(Masalah $masalah)
    {
        return view('admin.masalah.show', compact('masalah'));
    }

    /**
     * Menampilkan form untuk mengedit resource yang spesifik.
     */
    public function edit(Masalah $masalah)
    {
        return view('admin.masalah.edit', compact('masalah'));
    }

    /**
     * Memperbarui resource yang spesifik di dalam storage.
     */
    public function update(Request $request, Masalah $masalah)
    {
        $request->validate([
            'kode_masalah' => 'required|string|unique:masalah,kode_masalah,' . $masalah->id,
            'nama_masalah' => 'required|string',
            'solusi' => 'required|string',
        ]);
        $masalah->update($request->all());
        return redirect()->route('admin.masalah.index')->with('success', 'Masalah berhasil diperbarui.');
    }

    /**
     * Menghapus resource yang spesifik dari storage.
     */
    public function destroy(Masalah $masalah)
    {
        $masalah->delete();
        return redirect()->route('admin.masalah.index')->with('success', 'Masalah berhasil dihapus.');
    }

    /**
     * Export PDF untuk laporan masalah
     */
    public function exportPdf(Request $request)
    {
        $query = Masalah::latest();

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $masalah = $query->get();

        $pdf = Pdf::loadView('admin.masalah.pdf', compact('masalah'));

        return $pdf->download('laporan-daftar-masalah-' . date('Y-m-d') . '.pdf');
    }
}
