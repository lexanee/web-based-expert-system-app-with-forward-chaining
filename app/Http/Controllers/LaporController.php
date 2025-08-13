<?php

namespace App\Http\Controllers;

use App\Models\RiwayatLaporMasalah;
use Illuminate\Http\Request;

class LaporController extends Controller
{
    public function create()
    {
        return view('lapor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|in:Issue Teknis,Bug,Saran',
            'deskripsi' => 'required|string|min:10',
            'tipe_pengguna' => 'required|in:Vendor,Internal',
            'kontak' => 'nullable|string|max:255',
            'lampiran' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:10240', // 10MB max
        ]);

        $data = [
            'jenis_laporan' => $request->jenis_laporan,
            'deskripsi' => $request->deskripsi,
            'tipe_pengguna' => $request->tipe_pengguna,
            'kontak' => $request->kontak,
            'status' => 'Baru',
        ];

        // Handle file upload
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $path = $file->storeAs('laporan_attachments', $filename, 'public');
            $data['lampiran'] = $path;
        }

        $lapor_masalah = RiwayatLaporMasalah::create($data);

        return view('lapor.success', [
            'laporan' => $lapor_masalah
        ]);
    }

    public function show($id)
    {
        $lapor_masalah = RiwayatLaporMasalah::findOrFail($id);
        return view('lapor.show', compact('lapor_masalah'));
    }
}