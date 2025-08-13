<?php

use App\Http\Controllers\Admin\AturanController;
use App\Http\Controllers\Admin\GejalaController;
use App\Http\Controllers\Admin\MasalahController;
use App\Http\Controllers\Admin\RiwayatDiagnosisController;
use App\Http\Controllers\Admin\RiwayatLaporMasalahController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\LaporController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Landing Page Route
Route::get('/', function () {
    return view('landing.index');
})->name('home');

// API Routes for Diagnosis (Ambil gejala berdasarkan tipe pengguna dan proses)
Route::prefix('api')->group(function () {
    Route::get('gejala/{tipe_pengguna}', [DiagnosisController::class, 'getGejalaByTipeAndProses']);
    Route::get('gejala/{tipe_pengguna}/{proses}', [DiagnosisController::class, 'getGejalaByTipeAndProses']);
    Route::get('proses/{tipe_pengguna}', [DiagnosisController::class, 'getProsesByTipe']);
});

// Diagnosis Routes - Public Access (4 alur diagnosa)
Route::prefix('diagnosis')->name('diagnosis.')->group(function () {
    Route::get('/', [DiagnosisController::class, 'showUserSelection'])->name('form');
    Route::get('/pilih-pengguna', [DiagnosisController::class, 'showUserSelection'])->name('pilih-pengguna');
    Route::get('/pilih-proses', [DiagnosisController::class, 'showProcessSelection'])->name('pilih-proses');
    Route::get('/pilih-gejala', [DiagnosisController::class, 'showSymptomSelection'])->name('pilih-gejala');
    Route::post('/hasil-diagnosa', [DiagnosisController::class, 'showDiagnoseResult'])->name('hasil-diagnosa');
});

// Lapor Routes - Public Access
Route::prefix('lapor')->name('lapor.')->group(function () {
    Route::get('/', [LaporController::class, 'create'])->name('create');
    Route::post('/', [LaporController::class, 'store'])->name('store');
    Route::get('/{id}', [LaporController::class, 'show'])->name('show');
});

// Authentication Required Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    // Management Routes
    Route::prefix('admin')->name('admin.')->group(function () {

        // Gejala Management
        Route::resource('gejala', GejalaController::class);

        // Masalah Management
        Route::resource('masalah', MasalahController::class);
        Route::get('masalah/export/pdf', [MasalahController::class, 'exportPdf'])->name('masalah.export.pdf');

        // Aturan Management
        Route::resource('aturan', AturanController::class);
        Route::get('aturan/export/pdf', [AturanController::class, 'exportPdf'])->name('aturan.export.pdf');

        // Riwayat Diagnosis
        Route::resource('riwayat-diagnosis', RiwayatDiagnosisController::class);
        Route::get('riwayat-diagnosis/export/excel', [RiwayatDiagnosisController::class, 'exportExcel'])->name('riwayat-diagnosis.export.excel');
        Route::get('riwayat-diagnosis/export/pdf', [RiwayatDiagnosisController::class, 'exportPdf'])->name('riwayat-diagnosis.export.pdf');

        // Riwayat Lapor Masalah
        Route::resource('riwayat-lapor-masalah', RiwayatLaporMasalahController::class);
        Route::patch('riwayat-lapor-masalah/{riwayatLaporMasalah}/update-status', [RiwayatLaporMasalahController::class, 'updateStatus'])->name('riwayat-lapor-masalah.update-status');
        Route::get('riwayat-lapor-masalah/export/excel', [RiwayatLaporMasalahController::class, 'exportExcel'])->name('riwayat-lapor-masalah.export.excel');
        Route::get('riwayat-lapor-masalah/export/pdf', [RiwayatLaporMasalahController::class, 'exportPdf'])->name('riwayat-lapor-masalah.export.pdf');
        Route::get('riwayat-lapor-masalah/{riwayatLaporMasalah}/export/pdf', [RiwayatLaporMasalahController::class, 'exportSinglePdf'])->name('riwayat-lapor-masalah.export.single-pdf');
    });
});

// Include authentication routes
require __DIR__ . '/auth.php';
