<x-landing-layout>
    <x-slot name="title">Pilih Tahapan Proses | Sistem Pakar IOTACE</x-slot>

    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-4xl mx-auto">
            <!-- Progress Component -->
            <x-diagnosis-progress :currentStep="2" />

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">🔄</div>
                <h1 class="text-3xl md:text-4xl font-bold mb-4 text-slate-800">Pilih Tahapan Proses</h1>
                <p class="text-lg text-gray-600 mb-4">
                    Pilih tahapan proses e-procurement yang sedang Anda alami
                </p>

                <!-- User Type Display -->
                <div
                    class="inline-flex items-center px-4 py-2 bg-blue-50 border border-blue-200 text-slate-800 rounded-full text-sm">
                    Tipe: <span class="ml-1 font-bold text-blue-600">{{ $tipePengguna }}</span>
                </div>
            </div>

            <!-- Process Selection Form -->
            <form id="prosesForm">
                <div class="mb-8">
                    <div class="grid gap-3 max-h-96 overflow-y-auto">
                        @foreach ($prosesList as $index => $proses)
                            <label class="proses-option cursor-pointer block">
                                <div
                                    class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:bg-gray-100 hover:border-gray-300 transition-all duration-200 min-h-[60px] flex items-center">
                                    <div class="flex items-center space-x-3 w-full">
                                        <input type="radio" name="proses" value="{{ $proses }}"
                                            id="proses-{{ $index }}"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 bg-gray-100 flex-shrink-0">
                                        <div class="flex-1 flex items-center">
                                            <div class="font-medium text-slate-800 text-sm">{{ $proses }}</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Selected Display -->
                <div id="selectedDisplay"
                    class="hidden mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl text-center">
                    <p class="text-slate-800">
                        <span class="font-medium">Proses Terpilih:</span>
                        <span id="selectedProses" class="font-bold text-blue-600 ml-1"></span>
                    </p>
                </div>
            </form>

            <!-- Navigation -->
            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                <a href="/diagnosis/pilih-pengguna"
                    class="text-gray-600 hover:text-slate-800 text-sm transition-colors">
                    ← Kembali ke Pilih Tipe
                </a>
                <button id="nextButton" disabled
                    class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                    Lanjutkan ke Pilih Gejala
                </button>
            </div>
        </div>
    </div>

    <script>
        const tipePengguna = '{{ $tipePengguna }}';
        let selectedProses = null;

        document.addEventListener('DOMContentLoaded', function() {
            const radios = document.querySelectorAll('input[name="proses"]');
            const nextButton = document.getElementById('nextButton');
            const selectedDisplay = document.getElementById('selectedDisplay');
            const selectedProsesSpan = document.getElementById('selectedProses');

            console.log('Page loaded. Found', radios.length, 'radio buttons');

            radios.forEach((radio, index) => {
                console.log('Radio', index, ':', radio.value);

                radio.addEventListener('change', function() {
                    if (this.checked) {
                        console.log('Radio selected:', this.value);
                        selectedProses = this.value;

                        // Update UI
                        updateSelection();
                    }
                });

                // Also handle label click
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function() {
                        radio.checked = true;
                        console.log('Label clicked, radio value:', radio.value);
                        selectedProses = radio.value;
                        updateSelection();
                    });
                }
            });

            function updateSelection() {
                console.log('Updating selection to:', selectedProses);

                // Reset all styles
                radios.forEach(radio => {
                    const label = radio.closest('label');
                    const div = label.querySelector('div');
                    div.classList.remove('border-blue-300', 'bg-blue-50', 'border-2');
                    div.classList.add('bg-gray-50', 'border', 'border-gray-200');
                });

                // Highlight selected
                const selectedRadio = document.querySelector(`input[name="proses"]:checked`);
                if (selectedRadio) {
                    const selectedLabel = selectedRadio.closest('label');
                    const selectedDiv = selectedLabel.querySelector('div');
                    selectedDiv.classList.remove('bg-gray-50', 'border-gray-200');
                    selectedDiv.classList.add('bg-blue-50', 'border-blue-300', 'border-2');
                }

                // Show selection
                selectedProsesSpan.textContent = selectedProses;
                selectedDisplay.classList.remove('hidden');
                nextButton.disabled = false;

                // Save to localStorage
                localStorage.setItem('diagnosis_proses', selectedProses);
            }

            nextButton.addEventListener('click', function() {
                if (selectedProses) {
                    console.log('Navigating to pilih-gejala with:', selectedProses);
                    window.location.href =
                        `/diagnosis/pilih-gejala?tipe_pengguna=${tipePengguna}&proses=${encodeURIComponent(selectedProses)}`;
                }
            });

            // Load saved selection
            const savedProses = localStorage.getItem('diagnosis_proses');
            if (savedProses) {
                console.log('Loading saved selection:', savedProses);
                const savedRadio = document.querySelector(`input[value="${savedProses}"]`);
                if (savedRadio) {
                    savedRadio.checked = true;
                    selectedProses = savedProses;
                    updateSelection();
                }
            }
        });
    </script>
</x-landing-layout>
