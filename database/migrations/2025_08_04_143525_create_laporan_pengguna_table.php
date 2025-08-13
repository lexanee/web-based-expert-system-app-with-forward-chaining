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
        Schema::create('laporan_pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_laporan');
            $table->text('deskripsi');
            $table->enum('tipe_pengguna', ['Vendor', 'Internal']);
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
    }
};