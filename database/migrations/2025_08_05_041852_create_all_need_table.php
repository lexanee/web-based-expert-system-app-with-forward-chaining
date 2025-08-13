<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create gejala table
        Schema::create('gejala', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe_pengguna', ['Vendor', 'Internal', 'Both']);
            $table->string('kode_gejala')->unique(); // G1, G2, ...
            $table->text('nama_gejala');
            $table->timestamps();
        });

        // Create masalah table
        Schema::create('masalah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_masalah')->unique(); // M1, M2, ...
            $table->string('nama_masalah');
            $table->text('solusi');
            $table->timestamps();
        });

        // Create aturan table
        Schema::create('aturan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aturan')->unique(); // R1, R2, ...
            $table->foreignId('masalah_id')->constrained('masalah')->onDelete('cascade');
            $table->json('gejala_ids'); // Store array of gejala IDs as JSON
            $table->timestamps();
        });

        // Create riwayat_diagnosis table
        Schema::create('riwayat_diagnosis', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe_pengguna', ['Vendor', 'Internal', 'Both']);
            $table->json('gejala_terpilih'); // Menyimpan ID gejala dalam format JSON
            $table->integer('jumlah_gejala'); // Jumlah gejala yang dipilih
            $table->foreignId('masalah_id')->nullable()->constrained('masalah'); // Hasil
            $table->text('solusi_diberikan');
            $table->timestamps();
        });

        // Create laporan_pengguna table
        Schema::create('laporan_pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_laporan');
            $table->text('deskripsi');
            $table->enum('tipe_pengguna', ['Vendor', 'Internal', 'Both']);
            $table->string('kontak')->nullable();
            $table->string('lampiran')->nullable(); // Path ke file yang diupload
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pengguna');
        Schema::dropIfExists('riwayat_diagnosis');
        Schema::dropIfExists('aturan');
        Schema::dropIfExists('masalah');
        Schema::dropIfExists('gejala');
    }
};