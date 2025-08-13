<x-app-layout>
    <x-slot name="title">
        Detail Riwayat Diagnosis | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Riwayat Diagnosis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.riwayat-diagnosis.index') }}"
                            class="text-blue-600 hover:text-blue-900 text-sm">
                            ← Kembali ke Daftar Riwayat Diagnosis
                        </a>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Diagnosis</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Diagnosis</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $riwayat_diagnosi->created_at->format('d/m/Y H:i:s') }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipe Pengguna</label>
                                <p class="mt-1 text-sm bg-white p-3 rounded border">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $riwayat_diagnosi->tipe_pengguna == 'Vendor' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $riwayat_diagnosi->tipe_pengguna }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Proses E-Procurement</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    @if ($riwayat_diagnosi->proses)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $riwayat_diagnosi->proses }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Tidak ada data proses</span>
                                    @endif
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Gejala yang Dipilih ({{ $gejalaDetails->count() }} gejala)
                                </label>
                                <div class="bg-white rounded border">
                                    @if ($gejalaDetails->count() > 0)
                                        <div class="divide-y divide-gray-200">
                                            @foreach ($gejalaDetails as $gejala)
                                                <div class="p-3 flex items-start space-x-3">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $gejala->kode_gejala }}
                                                    </span>
                                                    <p class="text-sm text-gray-900">{{ $gejala->nama_gejala }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="p-3 text-sm text-gray-500">Tidak ada gejala yang dipilih</p>
                                    @endif
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Masalah Terdeteksi</label>
                                <div class="mt-1 bg-white p-3 rounded border">
                                    @if ($riwayat_diagnosi->masalah)
                                        <div class="flex items-start space-x-3">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ $riwayat_diagnosi->masalah->kode_masalah }}
                                            </span>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $riwayat_diagnosi->masalah->nama_masalah }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-sm text-red-500">Tidak ada masalah terdeteksi</p>
                                    @endif
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Solusi yang Diberikan</label>
                                <div class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $riwayat_diagnosi->solusi_diberikan }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
