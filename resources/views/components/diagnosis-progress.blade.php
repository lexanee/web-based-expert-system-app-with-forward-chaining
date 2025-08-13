@props(['currentStep' => 1])

<div class="mb-8">
    <!-- Progress Card -->
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-800">Progress Diagnosis</h3>
            <span class="text-sm text-gray-600">{{ $currentStep }}/4</span>
        </div>

        <!-- Progress Steps -->
        <div class="relative">
            <!-- Progress Line -->
            <div class="absolute top-3 left-0 w-full h-1 bg-gray-200 rounded-full">
                <div class="h-full bg-blue-500 rounded-full transition-all duration-500"
                    style="width: {{ ($currentStep - 1) * 33.33 }}%"></div>
            </div>

            <!-- Steps -->
            <div class="relative flex justify-between">
                <!-- Step 1: Select User Type -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 {{ $currentStep >= 1 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                        @if ($currentStep > 1)
                            ✓
                        @else
                            1
                        @endif
                    </div>
                    <div class="mt-2 text-xs text-center">
                        <div class="font-medium {{ $currentStep >= 1 ? 'text-blue-600' : 'text-gray-500' }}">
                            Tipe
                        </div>
                    </div>
                </div>

                <!-- Step 2: Select Procurement Process -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 {{ $currentStep >= 2 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                        @if ($currentStep > 2)
                            ✓
                        @else
                            2
                        @endif
                    </div>
                    <div class="mt-2 text-xs text-center">
                        <div class="font-medium {{ $currentStep >= 2 ? 'text-blue-600' : 'text-gray-500' }}">
                            Proses
                        </div>
                    </div>
                </div>

                <!-- Step 3: Select Symptoms -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 {{ $currentStep >= 3 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                        @if ($currentStep > 3)
                            ✓
                        @else
                            3
                        @endif
                    </div>
                    <div class="mt-2 text-xs text-center">
                        <div class="font-medium {{ $currentStep >= 3 ? 'text-blue-600' : 'text-gray-500' }}">
                            Gejala
                        </div>
                    </div>
                </div>

                <!-- Step 4: Results -->
                <div class="flex flex-col items-center">
                    <div
                        class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 {{ $currentStep >= 4 ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                        @if ($currentStep >= 4)
                            ✓
                        @else
                            4
                        @endif
                    </div>
                    <div class="mt-2 text-xs text-center">
                        <div class="font-medium {{ $currentStep >= 4 ? 'text-green-600' : 'text-gray-500' }}">
                            Hasil
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Step Info -->
        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center text-slate-800 text-sm">
                <div class="text-yellow-500 mr-2">💡</div>
                <span class="font-medium">
                    @switch($currentStep)
                        @case(1)
                            Pilih tipe pengguna (Vendor/Internal)
                        @break

                        @case(2)
                            Pilih tahapan proses E-procurement
                        @break

                        @case(3)
                            Centang gejala yang sesuai dengan proses
                        @break

                        @case(4)
                            Lihat hasil dan solusi
                        @break

                        @default
                            Memproses...
                    @endswitch
                </span>
            </div>
        </div>
    </div>
</div>
