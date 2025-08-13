<x-landing-layout>
    <x-slot name="title">Pilih Gejala | Sistem Pakar IOTACE</x-slot>

    <div class="min-h-screen flex items-center justify-center px-6 py-8">
        <!-- Main Card -->
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg p-8">
            <!-- Progress Component -->
            <x-diagnosis-progress :currentStep="3" />

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">📋</div>
                <h1 class="text-3xl md:text-4xl font-bold mb-4 text-slate-800">Pilih Gejala</h1>
                <p class="text-lg text-gray-600 mb-4">
                    Centang semua masalah yang sesuai dengan kondisi Anda
                </p>

                <!-- User Type & Process Display -->
                <div class="flex flex-wrap justify-center gap-2 mb-4">
                    <div
                        class="inline-flex items-center px-3 py-1 bg-blue-50 border border-blue-200 text-slate-800 rounded-full text-sm">
                        Tipe: <span class="ml-1 font-bold text-blue-600">{{ $tipePengguna }}</span>
                    </div>
                    <div
                        class="inline-flex items-center px-3 py-1 bg-green-50 border border-green-200 text-slate-800 rounded-full text-sm">
                        Proses: <span class="ml-1 font-bold text-green-600">{{ $proses }}</span>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <form id="diagnosisForm" method="POST" action="{{ route('diagnosis.hasil-diagnosa') }}">
                @csrf
                <input type="hidden" name="tipe_pengguna" value="{{ $tipePengguna }}">
                <input type="hidden" name="proses" value="{{ $proses }}">

                <!-- Loading State -->
                <div id="loadingState" class="hidden text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-3"></div>
                    <p class="text-gray-600">Memuat gejala...</p>
                </div>

                <!-- Gejala Grid -->
                <div id="gejalaGrid">
                    @if ($gejala->isNotEmpty())
                        <div class="mb-6">
                            <div class="grid md:grid-cols-2 gap-3 text-left" id="gejalaContainer">
                                @foreach ($gejala as $item)
                                    <div class="gejala-card h-full">
                                        <label
                                            class="flex items-start space-x-3 p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 hover:border-gray-300 transition-all duration-200 h-full">
                                            <input type="checkbox" name="gejala_ids[]" value="{{ $item->id }}"
                                                class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded bg-gray-100 flex-shrink-0">
                                            <div class="flex-1 min-w-0">
                                                <div class="font-medium text-slate-800 text-sm leading-tight">
                                                    {{ $item->nama_gejala }}</div>
                                                <div class="text-xs text-gray-500 mt-1">{{ $item->kode_gejala }}</div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Selected Count -->
                        <div class="mb-6 p-3 bg-blue-50 border border-blue-200 rounded-xl text-center">
                            <p class="text-sm text-slate-800">
                                Dipilih: <span id="selectedCount" class="font-bold text-blue-600">0</span> gejala
                            </p>
                        </div>

                        <!-- Navigation -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                            <a href="/diagnosis/pilih-proses?tipe_pengguna={{ $tipePengguna }}"
                                class="text-gray-600 hover:text-slate-800 text-sm transition-colors">
                                ← Kembali ke Pilih Proses
                            </a>
                            <button type="submit" id="processButton" disabled
                                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                                Proses Diagnosis
                            </button>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-8">
                            <div class="text-gray-400 text-4xl mb-3">📋</div>
                            <h3 class="text-lg font-semibold text-slate-800 mb-2">Tidak ada gejala tersedia</h3>
                            <p class="text-gray-600 mb-4">Tidak ada gejala yang terdaftar untuk proses ini.</p>
                            <a href="/diagnosis/pilih-proses?tipe_pengguna={{ $tipePengguna }}"
                                class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition border border-blue-300">
                                Pilih Proses Lain
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedGejala = [];

        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="gejala_ids[]"]');

            checkboxes.forEach(checkbox => {
                const label = checkbox.closest('label');

                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        selectedGejala.push(parseInt(this.value));
                        label.classList.add('bg-blue-50', 'border-blue-300');
                        label.classList.remove('bg-gray-50', 'border-gray-200');
                    } else {
                        selectedGejala = selectedGejala.filter(id => id !== parseInt(this.value));
                        label.classList.remove('bg-blue-50', 'border-blue-300');
                        label.classList.add('bg-gray-50', 'border-gray-200');
                    }

                    updateSelectedCount();
                });
            });

            function updateSelectedCount() {
                const selectedCount = document.getElementById('selectedCount');
                const processButton = document.getElementById('processButton');

                if (selectedCount) {
                    selectedCount.textContent = selectedGejala.length;
                }

                if (processButton) {
                    processButton.disabled = selectedGejala.length === 0;
                }
            }

            // Form submission validation
            const form = document.getElementById('diagnosisForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (selectedGejala.length === 0) {
                        e.preventDefault();
                        alert('Silakan pilih minimal 1 gejala untuk melanjutkan diagnosis.');
                        return;
                    }
                });
            }
        });
    </script>
</x-landing-layout>
