<x-app-layout>
    <x-slot name="title">
        Riwayat Lapor Masalah | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Gejala') }}
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

                    <form action="{{ route('admin.gejala.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Kode Gejala -->
                        <div>
                            <label for="kode_gejala" class="block text-sm font-medium text-gray-700">
                                Kode Gejala <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kode_gejala" id="kode_gejala" value="{{ old('kode_gejala') }}"
                                placeholder="Contoh: G1, G2, G3"
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('kode_gejala') border-red-500 @else border-gray-300 @enderror">
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
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama_gejala') border-red-500 @else border-gray-300 @enderror">{{ old('nama_gejala') }}</textarea>
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
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipe_pengguna') border-red-500 @else border-gray-300 @enderror">
                                <option value="">Pilih Tipe Pengguna</option>
                                <option value="Vendor" {{ old('tipe_pengguna') == 'Vendor' ? 'selected' : '' }}>Vendor
                                </option>
                                <option value="Internal" {{ old('tipe_pengguna') == 'Internal' ? 'selected' : '' }}>
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
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('proses') border-red-500 @else border-gray-300 @enderror">
                                <option value="">Pilih Proses</option>
                                <!-- Vendor Processes -->
                                <optgroup label="Vendor">
                                    @foreach ($prosesVendor as $proses)
                                        <option value="{{ $proses }}"
                                            {{ old('proses') == $proses ? 'selected' : '' }}>
                                            {{ $proses }}
                                        </option>
                                    @endforeach
                                </optgroup>
                                <!-- Internal Processes -->
                                <optgroup label="Internal">
                                    @foreach ($prosesInternal as $proses)
                                        <option value="{{ $proses }}"
                                            {{ old('proses') == $proses ? 'selected' : '' }}>
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
                                Simpan Gejala
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

            tipePenggunaSelect.addEventListener('change', function() {
                const selectedTipe = this.value;
                prosesSelect.innerHTML = '<option value="">Pilih Proses</option>';

                if (selectedTipe && prosesOptions[selectedTipe]) {
                    prosesOptions[selectedTipe].forEach(proses => {
                        const option = document.createElement('option');
                        option.value = proses;
                        option.textContent = proses;
                        prosesSelect.appendChild(option);
                    });
                }
            });

            // Trigger change event if there's an old value
            @if (old('tipe_pengguna'))
                tipePenggunaSelect.dispatchEvent(new Event('change'));
                prosesSelect.value = '{{ old('proses') }}';
            @endif
        });
    </script>
</x-app-layout>
