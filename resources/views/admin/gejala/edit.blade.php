<x-app-layout>
    <x-slot name="title">
        Edit Gejala | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Gejala') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.gejala.index') }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            ← Kembali ke Daftar Gejala
                        </a>
                    </div>

                    <form action="{{ route('admin.gejala.update', $gejala) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Kode Gejala -->
                        <div>
                            <label for="kode_gejala" class="block text-sm font-medium text-gray-700">
                                Kode Gejala <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kode_gejala" id="kode_gejala"
                                value="{{ old('kode_gejala', $gejala->kode_gejala) }}" placeholder="Contoh: G1, G2, G3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('kode_gejala') !border-red-500 @enderror">
                            @error('kode_gejala')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Gejala -->
                        <div>
                            <label for="nama_gejala" class="block text-sm font-medium text-gray-700">
                                Nama Gejala <span class="text-red-500">*</span>
                            </label>
                            <textarea name="nama_gejala" id="nama_gejala" rows="3" placeholder="Masukkan deskripsi gejala..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama_gejala') !border-red-500 @enderror">{{ old('nama_gejala', $gejala->nama_gejala) }}</textarea>
                            @error('nama_gejala')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipe Pengguna -->
                        <div>
                            <label for="tipe_pengguna" class="block text-sm font-medium text-gray-700">
                                Tipe Pengguna <span class="text-red-500">*</span>
                            </label>
                            <select name="tipe_pengguna" id="tipe_pengguna"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipe_pengguna') !border-red-500 @enderror">
                                <option value="">Pilih Tipe Pengguna</option>
                                <option value="Vendor"
                                    {{ old('tipe_pengguna', $gejala->tipe_pengguna) == 'Vendor' ? 'selected' : '' }}>
                                    Vendor</option>
                                <option value="Internal"
                                    {{ old('tipe_pengguna', $gejala->tipe_pengguna) == 'Internal' ? 'selected' : '' }}>
                                    Internal</option>
                            </select>
                            @error('tipe_pengguna')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Proses -->
                        <div>
                            <label for="proses" class="block text-sm font-medium text-gray-700">
                                Proses <span class="text-red-500">*</span>
                            </label>
                            <select name="proses" id="proses"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('proses') !border-red-500 @enderror">
                                <option value="">Pilih Proses</option>
                                <!-- Vendor Processes -->
                                <optgroup label="Vendor">
                                    @foreach ($prosesVendor as $proses)
                                        <option value="{{ $proses }}"
                                            {{ old('proses', $gejala->proses) == $proses ? 'selected' : '' }}>
                                            {{ $proses }}
                                        </option>
                                    @endforeach
                                </optgroup>
                                <!-- Internal Processes -->
                                <optgroup label="Internal">
                                    @foreach ($prosesInternal as $proses)
                                        <option value="{{ $proses }}"
                                            {{ old('proses', $gejala->proses) == $proses ? 'selected' : '' }}>
                                            {{ $proses }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('proses')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-3">
                            <x-secondary-link :href="route('admin.gejala.index')">
                                Batal
                            </x-secondary-link>
                            <x-primary-button type="submit">
                                Update Gejala
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipePenggunaSelect = document.getElementById('tipe_pengguna');
            const prosesSelect = document.getElementById('proses');

            // Process options grouped by user type
            const prosesOptions = {
                'Vendor': @json($prosesVendor),
                'Internal': @json($prosesInternal)
            };

            // Store current proses value
            const currentProses = prosesSelect.value;

            tipePenggunaSelect.addEventListener('change', function() {
                const selectedTipe = this.value;
                const currentProsesValue = prosesSelect.value;

                // Clear current options except first one
                prosesSelect.innerHTML = '<option value="">Pilih Proses</option>';

                if (selectedTipe && prosesOptions[selectedTipe]) {
                    prosesOptions[selectedTipe].forEach(proses => {
                        const option = document.createElement('option');
                        option.value = proses;
                        option.textContent = proses;
                        // Restore selection if it matches
                        if (proses === currentProsesValue) {
                            option.selected = true;
                        }
                        prosesSelect.appendChild(option);
                    });
                }
            });

            // Initialize on page load
            if (tipePenggunaSelect.value) {
                tipePenggunaSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>
