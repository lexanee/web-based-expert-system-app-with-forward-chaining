<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\RiwayatDiagnosis;
use App\Services\ForwardChainingEngine;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class DiagnosisController extends Controller
{
    protected ForwardChainingEngine $engine;

    public function __construct(ForwardChainingEngine $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Step 1: Menampilkan pilihan tipe pengguna
     */
    public function showUserSelection(): View
    {
        // Tampilkan halaman pemilihan tipe pengguna
        return view('diagnosis.pilih-pengguna');
    }

    /**
     * Step 2: Menampilkan pilihan proses berdasarkan tipe pengguna
     */
    public function showProcessSelection(Request $request): View|RedirectResponse
    {
        $tipePengguna = $request->input('tipe_pengguna');

        // Pengecekan tipe pengguna
        if (!$this->isValidUserType($tipePengguna)) {
            return $this->redirectWithError('diagnosis.pilih-pengguna', 'Silakan pilih tipe pengguna terlebih dahulu.');
        }

        // Mendapatkan daftar proses berdasarkan tipe pengguna
        $prosesList = Gejala::getProsesByTipe($tipePengguna);

        // Tampilkan halaman pemilihan proses
        return view('diagnosis.pilih-proses', compact('tipePengguna', 'prosesList'));
    }

    /**
     * Step 3: Menampilkan pilihan gejala yang di filter berdasarkan tipe pengguna dan proses yang dipilih
     */
    public function showSymptomSelection(Request $request): View|RedirectResponse
    {
        $tipePengguna = $request->input('tipe_pengguna');
        $proses = $request->input('proses');

        // Pengecekan tipe pengguna
        if (!$this->isValidUserType($tipePengguna)) {
            return $this->redirectWithError('diagnosis.pilih-pengguna', 'Silakan pilih tipe pengguna terlebih dahulu.');
        }

        // Pengecekan proses
        if (!$proses) {
            return $this->redirectWithError(
                'diagnosis.pilih-proses',
                'Silakan pilih tahapan proses terlebih dahulu.',
                ['tipe_pengguna' => $tipePengguna]
            );
        }

        // Mengambil gejala yang sudah di filter
        $gejala = $this->getFilteredSymptoms($tipePengguna, $proses);

        // Pengecekan apakah gejala ada untuk proses ini
        if ($gejala->isEmpty()) {
            return $this->redirectWithError(
                'diagnosis.pilih-proses',
                'Tidak ada gejala yang terdaftar untuk proses ini. Pastikan Anda memilih proses yang sesuai.',
                ['tipe_pengguna' => $tipePengguna]
            );
        }
        // Tampilkan halaman pemilihan gejala
        return view('diagnosis.pilih-gejala', compact('gejala', 'tipePengguna', 'proses'));
    }

    /**
     * Step 4: Proses diagnosa menggunakan Forward Chaining Engine dan menampilkan hasil diagnosa
     */
    public function showDiagnoseResult(Request $request): View
    {
        $validatedData = $this->validateDiagnosisRequest($request);

        $selectedGejalaIds = $validatedData['gejala_ids'];
        $tipePengguna = $validatedData['tipe_pengguna'];
        $proses = $validatedData['proses'];

        // Simpan konteks diagnosis dalam session
        $this->storeDiagnosisContext($tipePengguna, $proses);

        // Menjalankan inferensi Forward Chaining
        $result = $this->engine->diagnose($selectedGejalaIds, $tipePengguna);

        // Simpan riwayat diagnosis
        $riwayat = $this->saveDiagnosisHistory($tipePengguna, $proses, $selectedGejalaIds, $result);

        // Ambil detail gejala yang dipilih
        $selectedGejala = Gejala::whereIn('id', $selectedGejalaIds)->get();

        // Tampilkan hasil diagnosa
        return view('diagnosis.hasil-diagnosa', [
            'result' => $result['found'] ? $result : null,
            'selected_gejala' => $selectedGejala,
            'tipe_pengguna' => $tipePengguna,
            'proses' => $proses,
            'riwayat_id' => $riwayat->id,
        ]);
    }

    /**
     * API: Get symptoms by user type and process
     */
    public function getGejalaByTipeAndProses(string $tipe_pengguna, ?string $proses = null): JsonResponse
    {
        try {
            if (!$this->isValidUserType($tipe_pengguna)) {
                return response()->json(['error' => 'Invalid user type'], 400);
            }

            $gejala = $this->getFilteredSymptoms($tipe_pengguna, $proses);

            return response()->json($gejala);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch gejala: ' . $e->getMessage()], 500);
        }
    }

    /**
     * API: Get process list by user type
     */
    public function getProsesByTipe(string $tipe_pengguna): JsonResponse
    {
        try {
            if (!$this->isValidUserType($tipe_pengguna)) {
                return response()->json(['error' => 'Invalid user type'], 400);
            }

            $prosesList = Gejala::getProsesByTipe($tipe_pengguna);

            return response()->json($prosesList);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch proses: ' . $e->getMessage()], 500);
        }
    }

    // ================================
    // PRIVATE HELPER METHODS
    // ================================

    /**
     * Validate if user type is valid
     */
    private function isValidUserType(?string $tipePengguna): bool
    {
        return in_array($tipePengguna, ['Vendor', 'Internal']);
    }

    /**
     * Get filtered symptoms based on user type and process
     */
    private function getFilteredSymptoms(string $tipePengguna, ?string $proses = null)
    {
        $query = Gejala::where('tipe_pengguna', $tipePengguna);

        if ($proses) {
            $query->where('proses', $proses);
        }

        return $query->orderBy('kode_gejala')->get();
    }

    /**
     * Redirect with error message
     */
    private function redirectWithError(string $route, string $message, array $params = []): RedirectResponse
    {
        return redirect()->route($route, $params)->with('error', $message);
    }

    /**
     * Validate diagnosis request data
     */
    private function validateDiagnosisRequest(Request $request): array
    {
        return $request->validate([
            'gejala_ids' => 'required|array|min:1',
            'tipe_pengguna' => 'required|string|in:Vendor,Internal',
            'proses' => 'required|string|max:255',
        ]);
    }

    /**
     * Store diagnosis context in session
     */
    private function storeDiagnosisContext(string $tipePengguna, string $proses): void
    {
        session([
            'diagnosis_tipe_pengguna' => $tipePengguna,
            'diagnosis_proses' => $proses
        ]);
    }

    /**
     * Save diagnosis history to database
     */
    private function saveDiagnosisHistory(string $tipePengguna, string $proses, array $selectedGejalaIds, array $result): RiwayatDiagnosis
    {
        return RiwayatDiagnosis::create([
            'tipe_pengguna' => $tipePengguna,
            'proses' => $proses,
            'gejala_terpilih' => json_encode($selectedGejalaIds),
            'jumlah_gejala' => count($selectedGejalaIds),
            'masalah_id' => $result['found'] ? $result['masalah']->id : null,
            'solusi_diberikan' => $result['found'] ? $result['masalah']->solusi : 'Masalah tidak teridentifikasi',
        ]);
    }
}
