<x-landing-layout>
    <x-slot name="title">Sistem Pakar IOTACE | Diagnosis Masalah Teknis E-Procurement</x-slot>

    <!-- Hero Section -->
    <div class="bg-slate-800 text-white h-screen flex items-center justify-center relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 text-center z-20">
            <!-- Main Heading -->
            <div class="mb-8">
                <div class="text-6xl mb-4">🔧</div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                    Sistem Pakar Diagnosis
                    <span class="text-blue-300">E-Procurement</span>
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Solusi untuk mendiagnosis masalah teknis e-procurement
                    secara cepat.
                </p>
            </div>

            <!-- Action Cards -->
            <div class="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                <!-- Diagnosis Card -->
                <div class="bg-white rounded-2xl p-6 text-slate-800">
                    <div class="text-4xl mb-4">🚀</div>
                    <h3 class="text-xl font-bold mb-3">Mulai Diagnosis</h3>
                    <p class="text-gray-600 mb-6 text-sm">
                        Jawab beberapa pertanyaan sederhana untuk mendapatkan solusi yang tepat.
                    </p>
                    <a href="{{ route('diagnosis.form') }}"
                        class="inline-block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors">
                        Mulai Sekarang
                    </a>
                </div>

                <!-- Report Card -->
                <div class="bg-gray-100 rounded-2xl p-6 text-slate-800">
                    <div class="text-4xl mb-4">📝</div>
                    <h3 class="text-xl font-bold mb-3">Laporkan Masalah</h3>
                    <p class="text-gray-600 mb-6 text-sm">
                        Sampaikan masalah yang tidak dapat terdiagnosis otomatis kepada tim teknis.
                    </p>
                    <a href="{{ route('lapor.create') }}"
                        class="inline-block w-full bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-6 rounded-xl transition-colors">
                        Laporkan Masalah
                    </a>
                </div>
            </div>

            <!-- Simple Info -->
            <div class="mt-8 text-gray-300 text-sm">
                <p>✨ Proses diagnosis hanya membutuhkan 3 langkah sederhana.</p>
            </div>
        </div>
    </div>

</x-landing-layout>
