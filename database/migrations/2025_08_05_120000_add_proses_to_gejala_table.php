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
        Schema::table('gejala', function (Blueprint $table) {
            $table->string('proses')->nullable()->after('nama_gejala');
            $table->index(['tipe_pengguna', 'proses']); // Index untuk performa query filter
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gejala', function (Blueprint $table) {
            $table->dropIndex(['tipe_pengguna', 'proses']);
            $table->dropColumn('proses');
        });
    }
};
