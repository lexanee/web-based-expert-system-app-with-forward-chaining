<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    /**
     * Menampilkan daftar resource.
     */
    public function index()
    {
        $gejala = Gejala::latest()->paginate(10);
        return view('admin.gejala.index', compact('gejala'));
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     */
    public function create()
    {
        $prosesVendor = Gejala::PROSES_VENDOR;
        $prosesInternal = Gejala::PROSES_INTERNAL;
        return view('admin.gejala.create', compact('prosesVendor', 'prosesInternal'));
    }

    /**
     * Menyimpan resource yang baru dibuat ke dalam storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_gejala' => 'required|string|unique:gejala,kode_gejala',
            'nama_gejala' => 'required|string',
            'tipe_pengguna' => 'required|in:Vendor,Internal',
            'proses' => 'required|string',
        ]);
        Gejala::create($request->all());
        return redirect()->route('admin.gejala.index')->with('success', 'Gejala berhasil ditambahkan.');
    }

    /**
     * Menampilkan resource yang spesifik.
     */
    public function show(Gejala $gejala)
    {
        return view('admin.gejala.show', compact('gejala'));
    }

    /**
     * Menampilkan form untuk mengedit resource yang spesifik.
     */
    public function edit(Gejala $gejala)
    {
        $prosesVendor = Gejala::PROSES_VENDOR;
        $prosesInternal = Gejala::PROSES_INTERNAL;
        return view('admin.gejala.edit', compact('gejala', 'prosesVendor', 'prosesInternal'));
    }

    /**
     * Memperbarui resource yang spesifik di storage.
     */
    public function update(Request $request, Gejala $gejala)
    {
        $request->validate([
            'kode_gejala' => 'required|string|unique:gejala,kode_gejala,' . $gejala->id,
            'nama_gejala' => 'required|string',
            'tipe_pengguna' => 'required|in:Vendor,Internal',
            'proses' => 'required|string',
        ]);
        $gejala->update($request->all());
        return redirect()->route('admin.gejala.index')->with('success', 'Gejala berhasil diperbarui.');
    }

    /**
     * Menghapus resource yang spesifik dari storage.
     */
    public function destroy(Gejala $gejala)
    {
        $gejala->delete();
        return redirect()->route('admin.gejala.index')->with('success', 'Gejala berhasil dihapus.');
    }
}
