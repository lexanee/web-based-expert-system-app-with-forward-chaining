<x-landing-layout>
    <x-slot name="title">Laporan Berhasil Dikirim | Sistem Pakar IOTACE</x-slot>

    <div class="min-h-screen flex items-center justify-center px-6 py-8">
        <div class="max-w-3xl w-full">
            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <!-- Success Icon & Header -->
                <div class="text-center mb-8">
                    <div class="text-6xl mb-4">✅</div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-4 text-slate-800">Laporan Terkirim!</h1>
                    <p class="text-lg text-gray-600">Terima kasih telah melaporkan masalah teknis</p>
                </div>

                <div class="space-y-6">
                    <!-- Success Message -->
                    <div class="text-center">
                        <h2 class="text-xl font-bold text-slate-800 mb-3">Laporan Anda Telah Diterima</h2>
                        <p class="text-gray-600">
                            Tim support akan meninjau laporan Anda dan memberikan respon dalam waktu 1x24 jam (hari
                            kerja).
                        </p>
                    </div>

                    @if (isset($laporan))
                        <!-- Report Details -->
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                                <span class="mr-2">📋</span> Detail Laporan
                            </h3>
                            <div class="grid md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-600">ID Laporan:</span>
                                    <div class="font-bold text-slate-800">#{{ $laporan->id ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Tanggal:</span>
                                    <div class="font-bold text-slate-800">
                                        {{ isset($laporan->created_at) ? $laporan->created_at->format('d/m/Y H:i') : date('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Jenis:</span>
                                    <div class="font-bold text-slate-800">{{ $laporan->jenis_laporan ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Status:</span>
                                    <div class="font-bold text-green-600">{{ $laporan->status ?? 'Baru' }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Next Steps -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Langkah Selanjutnya</h3>
                        <ul class="space-y-3 text-gray-600 text-sm">
                            <li class="flex items-start">
                                <span
                                    class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-3 mt-0.5 flex items-center justify-center">1</span>
                                <span>Tim support akan meninjau laporan Anda</span>
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-3 mt-0.5 flex items-center justify-center">2</span>
                                <span>Anda akan menerima konfirmasi via email</span>
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-3 mt-0.5 flex items-center justify-center">3</span>
                                <span>Solusi akan diberikan maksimal 1x24 jam</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('home') }}"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-xl font-semibold transition-colors text-center">
                            🏠 Kembali ke Beranda
                        </a>
                        <a href="{{ route('lapor.create') }}"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-6 rounded-xl font-semibold transition-colors text-center border border-gray-300">
                            📝 Laporkan Masalah Lain
                        </a>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <div class="text-orange-500 text-lg">📞</div>
                            <div class="flex-1">
                                <h3 class="font-medium text-slate-800 mb-2">Butuh Bantuan Segera?</h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    Jika masalah sangat mendesak, hubungi:
                                </p>
                                <div class="flex flex-col sm:flex-row gap-2 text-sm">
                                    <a href="tel:+62-21-1234-5678"
                                        class="text-orange-600 hover:text-orange-800 transition-colors">
                                        📞 (021) 1234-5678
                                    </a>
                                    <a href="mailto:eproc-support@iotace.co.id"
                                        class="text-orange-600 hover:text-orange-800 transition-colors">
                                        ✉️ eproc-support@iotace.co.id
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Smooth scroll to top pada load
        document.addEventListener('DOMContentLoaded', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</x-landing-layout>
