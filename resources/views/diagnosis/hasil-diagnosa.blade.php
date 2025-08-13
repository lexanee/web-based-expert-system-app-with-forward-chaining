<x-landing-layout>
    <x-slot name="title">Hasil Diagnosis | Sistem Pakar IOTACE</x-slot>

    <!-- Full viewport container with centering -->
    <div class="min-h-screen flex items-center justify-center px-6 py-8">
        <div class="max-w-4xl w-full">
            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <!-- Progress Component -->
                <x-diagnosis-progress :currentStep="4" />

                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4 text-slate-800">Hasil Diagnosis</h1>
                    <p class="text-lg text-gray-600">
                        Analisis masalah berdasarkan gejala yang Anda pilih
                    </p>
                </div>

                <!-- Diagnosis Result -->
                @if (isset($result) && $result)
                    <!-- Result Header -->
                    <div class="text-center mb-6">
                        <div class="text-6xl mb-3">✅</div>
                        <h2 class="text-3xl font-bold text-green-600">Masalah Teridentifikasi</h2>
                    </div>

                    <!-- Problem Details -->
                    <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-6 text-left">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-slate-800">{{ $result['masalah']->nama_masalah }}</h3>
                            <div class="ml-4 text-right">
                                @if (isset($result['score']) && $result['score'] > 0)
                                    <div class="text-sm font-medium text-green-700">
                                        Akurasi: {{ $result['score'] }}%
                                    </div>
                                    @if (isset($result['confidence_level']))
                                        <div class="text-xs text-gray-600">
                                            {{ $result['confidence_level'] }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        @if ($result['masalah']->deskripsi)
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700 mb-2">Deskripsi:</h4>
                                <p class="text-gray-600">{{ $result['masalah']->deskripsi }}</p>
                            </div>
                        @endif

                        @if ($result['masalah']->solusi)
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700 mb-2">Solusi:</h4>
                                <div
                                    class="bg-blue-50 border border-blue-200 rounded-lg p-4 border-l-4 border-l-blue-500">
                                    <p class="text-gray-700">{{ $result['masalah']->solusi }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Matched Symptoms -->
                    @if (isset($result['matched_gejala']) && count($result['matched_gejala']) > 0)
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-700 mb-3 text-left">Gejala yang Cocok:</h4>
                            <div class="grid md:grid-cols-2 gap-3">
                                @foreach ($result['matched_gejala'] as $gejala)
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                        <div class="font-medium text-slate-800 text-sm">{{ $gejala->nama_gejala }}</div>
                                        @if ($gejala->deskripsi)
                                            <div class="text-xs text-gray-600 mt-1">{{ $gejala->deskripsi }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <!-- No Result -->
                    <div class="text-center mb-6">
                        <div class="text-2xl mb-3">❓</div>
                        <h2 class="text-xl font-bold text-orange-600">Tidak Ada Masalah yang Cocok</h2>
                        <p class="text-gray-600 mt-2">
                            Gejala yang Anda pilih tidak cocok dengan masalah yang ada dalam sistem.
                        </p>
                    </div>

                    <!-- Suggestion Box -->
                    <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 mb-6">
                        <h3 class="font-semibold text-slate-800 mb-3">Saran untuk Anda:</h3>
                        <ul class="text-gray-600 text-sm space-y-2">
                            <li>• Coba pilih gejala lain yang lebih spesifik</li>
                            <li>• Periksa kembali apakah ada gejala yang terlewat</li>
                            <li>• Hubungi tim support untuk bantuan langsung</li>
                        </ul>
                    </div>
                @endif

                <!-- Summary -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mb-6">
                    <h3 class="font-semibold text-gray-700 mb-3">Ringkasan Diagnosis</h3>
                    <div class="text-sm space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Tipe Pengguna:</span>
                            <span class="text-slate-800 font-semibold">{{ $tipe_pengguna ?? 'Tidak diketahui' }}</span>
                        </div>
                        @if (isset($proses))
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Tahapan Proses:</span>
                                <span class="text-slate-800 font-semibold">{{ $proses }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Gejala Dipilih:</span>
                            <span class="text-slate-800 font-semibold">{{ count($selected_gejala ?? []) }} gejala</span>
                        </div>
                        @if (isset($result) && $result && isset($result['gejala']))
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Gejala Valid:</span>
                                <span class="text-slate-800 font-semibold">{{ count($result['gejala']) }} gejala</span>
                            </div>
                        @endif
                        @if (isset($result) && $result && isset($result['score']))
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium">Akurasi Diagnosis:</span>
                                <span class="text-slate-800 font-semibold">{{ $result['score'] }}%</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Status:</span>
                            <span class="text-slate-800 font-semibold">
                                @if (isset($result) && $result['found'])
                                    <span class="text-green-600">Berhasil</span>
                                @else
                                    <span class="text-orange-600">Tidak Ditemukan</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Waktu:</span>
                            <span class="text-slate-800 font-semibold">{{ now()->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="space-y-4 pt-6 border-t border-gray-200">
                    <!-- Primary buttons row -->
                    <div class="flex flex-row sm:flex-row gap-4 justify-between items-center">
                        <a href="{{ route('home') }}"
                            class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors text-center border border-gray-300">
                            🏠 Beranda
                        </a>
                        <a href="{{ route('diagnosis.pilih-pengguna') }}"
                            class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors text-center">
                            🔄 Diagnosis Baru
                        </a>
                    </div>
                    <!-- Secondary button row -->
                    <div class="flex justify-center">
                        @if (empty($result))
                            <a href="{{ route('lapor.create') }}"
                                class="flex-1 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition-colors text-center"
                                title="Laporkan masalah secara manual">
                                📝 Laporkan Masalah
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>
