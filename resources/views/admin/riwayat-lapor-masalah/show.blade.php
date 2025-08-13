<x-app-layout>
    <x-slot name="title">
        Detail Riwayat Lapor Masalah | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Riwayat Lapor Masalah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Detail Laporan #{{ $laporan->id }}</h3>
                        <div class="flex space-x-2">
                            <x-warning-link :href="route('admin.riwayat-lapor-masalah.export.single-pdf', $laporan)">
                                📄 Export PDF
                            </x-warning-link>
                            <x-secondary-link :href="route('admin.riwayat-lapor-masalah.index')">
                                ← Kembali
                            </x-secondary-link>
                        </div>
                    </div>

                    <!-- Alert untuk notifikasi -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Informasi Laporan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">Informasi Dasar</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">ID Laporan:</span>
                                    <span class="font-medium">#{{ $laporan->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tanggal Dibuat:</span>
                                    <span class="font-medium">{{ $laporan->created_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Terakhir Update:</span>
                                    <span class="font-medium">{{ $laporan->updated_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">Status & Kategori</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Jenis Laporan:</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $laporan->getJenisLaporanBadgeClass() }}">
                                        {{ $laporan->jenis_laporan }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Tipe Pengguna:</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $laporan->tipe_pengguna == 'Vendor' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $laporan->tipe_pengguna }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Status:</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $laporan->getStatusBadgeClass() }}">
                                        {{ $laporan->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pengguna -->
                    @if ($laporan->kontak)
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h4 class="font-medium text-gray-900 mb-3">Informasi Kontak</h4>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <span class="text-gray-600">Kontak:</span>
                                    <span class="font-medium ml-2">{{ $laporan->kontak }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Detail Laporan -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h4 class="font-medium text-gray-900 mb-3">Detail Laporan</h4>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $laporan->deskripsi }}</p>
                        </div>
                    </div>

                    <!-- Screenshot/Lampiran (jika ada) -->
                    @if ($laporan->lampiran)
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h4 class="font-medium text-gray-900 mb-3">Lampiran</h4>
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ basename($laporan->lampiran) }}</p>
                                    <p class="text-sm text-gray-500">File lampiran</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ asset('storage/' . $laporan->lampiran) }}" target="_blank"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Update Status -->
                    @if ($laporan->status != 'Selesai')
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">Update Status Laporan</h4>
                            <form action="{{ route('admin.riwayat-lapor-masalah.update-status', $laporan) }}"
                                method="POST" class="space-y-4">
                                @csrf
                                @method('PATCH')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select name="status"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="Baru" {{ $laporan->status == 'Baru' ? 'selected' : '' }}>
                                                Baru</option>
                                            <option value="Diproses"
                                                {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>Diproses
                                            </option>
                                            <option value="Selesai"
                                                {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <x-primary-button type="submit">
                                        Update Status
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
