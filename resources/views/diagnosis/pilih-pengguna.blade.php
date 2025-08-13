<x-landing-layout>
    <x-slot name="title">Mulai Diagnosis | Sistem Pakar IOTACE</x-slot>

    <div class="min-h-screen flex items-center justify-center px-6">
        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-4xl">
            <!-- Progress Component -->
            <x-diagnosis-progress :currentStep="1" />

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">👤</div>
                <h1 class="text-3xl md:text-4xl font-bold mb-4 text-slate-800">Siapa Anda?</h1>
                <p class="text-lg text-gray-600">
                    Pilih tipe pengguna untuk mendapatkan diagnosis yang tepat
                </p>
            </div>

            <!-- User Type Cards -->
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <!-- Vendor Card -->
                <div class="user-type-card cursor-pointer" data-type="Vendor">
                    <div
                        class="bg-gray-50 border border-gray-200 rounded-xl p-8 text-center hover:bg-gray-100 hover:border-gray-300 transition-all duration-300 min-h-[200px] flex flex-col justify-between">
                        <div class="flex-grow flex flex-col justify-center">
                            <div class="text-5xl mb-4">🏢</div>
                            <h3 class="text-2xl font-bold mb-3 text-slate-800">Vendor</h3>
                            <p class="text-gray-600 mb-4 text-base">Penyedia barang/jasa</p>
                        </div>
                        <div class="text-sm text-slate-700 bg-gray-100 rounded-lg p-3 mt-auto">
                            Registrasi, prakualifikasi, quotation, ...
                        </div>
                    </div>
                </div>

                <!-- Internal Card -->
                <div class="user-type-card cursor-pointer" data-type="Internal">
                    <div
                        class="bg-gray-50 border border-gray-200 rounded-xl p-8 text-center hover:bg-gray-100 hover:border-gray-300 transition-all duration-300 min-h-[200px] flex flex-col justify-between">
                        <div class="flex-grow flex flex-col justify-center">
                            <div class="text-5xl mb-4">👨‍💼</div>
                            <h3 class="text-2xl font-bold mb-3 text-slate-800">Internal</h3>
                            <p class="text-gray-600 mb-4 text-base">Tim Procurement</p>
                        </div>
                        <div class="text-sm text-slate-700 bg-gray-100 rounded-lg p-3 mt-auto">
                            Receive RFM/S, setup PQ & RFQ, evaluation, ...
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selected Display -->
            <div id="selectedDisplay" class="hidden mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl text-center">
                <p class="text-slate-800">
                    <span class="font-medium">Terpilih:</span>
                    <span id="selectedType" class="font-bold text-blue-600 ml-1"></span>
                </p>
            </div>

            <!-- Navigation -->
            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                <a href="/" class="text-gray-600 hover:text-slate-800 text-sm transition-colors">
                    ← Kembali ke Beranda
                </a>
                <button id="nextButton" disabled
                    class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        let selectedUserType = null;

        document.addEventListener('DOMContentLoaded', function() {
            const userTypeCards = document.querySelectorAll('.user-type-card');
            const nextButton = document.getElementById('nextButton');
            const selectedDisplay = document.getElementById('selectedDisplay');
            const selectedType = document.getElementById('selectedType');

            // Load saved selection
            const savedType = localStorage.getItem('diagnosis_tipe_pengguna');
            if (savedType) {
                selectUserType(savedType);
            }

            userTypeCards.forEach(card => {
                card.addEventListener('click', function() {
                    const type = this.getAttribute('data-type');
                    selectUserType(type);
                });
            });

            function selectUserType(type) {
                selectedUserType = type;

                // Reset all cards
                userTypeCards.forEach(card => {
                    const cardDiv = card.querySelector('div');
                    cardDiv.classList.remove('border-blue-300', 'bg-blue-50', 'border-2');
                    cardDiv.classList.add('bg-gray-50', 'border', 'border-gray-200');
                });

                // Highlight selected card
                const selectedCard = document.querySelector(`[data-type="${type}"]`);
                const selectedCardDiv = selectedCard.querySelector('div');
                selectedCardDiv.classList.remove('bg-gray-50', 'border-gray-200');
                selectedCardDiv.classList.add('bg-blue-50', 'border-blue-300', 'border-2');

                // Show selection and enable button
                selectedType.textContent = type;
                selectedDisplay.classList.remove('hidden');
                nextButton.disabled = false;

                // Save to localStorage
                localStorage.setItem('diagnosis_tipe_pengguna', type);
            }

            nextButton.addEventListener('click', function() {
                if (selectedUserType) {
                    window.location.href = `/diagnosis/pilih-proses?tipe_pengguna=${selectedUserType}`;
                }
            });
        });
    </script>
</x-landing-layout>
