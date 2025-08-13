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
        Schema::create('riwayat_diagnosis', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe_pengguna', ['Vendor', 'Internal']);
            $table->json('gejala_dipilih'); // Menyimpan ID gejala dalam format JSON
            $table->foreignId('masalah_id')->nullable()->constrained('masalah'); // Hasil
            $table->text('solusi_diberikan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_diagnosis');
    }
};
