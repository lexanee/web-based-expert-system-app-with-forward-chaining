<x-app-layout>
    <x-slot name="title">
        Edit Aturan | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Aturan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.aturan.index') }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            ← Kembali ke Daftar Aturan
                        </a>
                    </div>

                    <form action="{{ route('admin.aturan.update', $aturan) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Kode Aturan -->
                        <div>
                            <label for="kode_aturan" class="block text-sm font-medium text-gray-700">
                                Kode Aturan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kode_aturan" id="kode_aturan"
                                value="{{ old('kode_aturan', $aturan->kode_aturan) }}" placeholder="Contoh: R1, R2, R3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('kode_aturan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pilih Masalah -->
                        <div>
                            <label for="masalah_id" class="block text-sm font-medium text-gray-700">
                                Masalah <span class="text-red-500">*</span>
                            </label>
                            <select name="masalah_id" id="masalah_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Pilih Masalah --</option>
                                @foreach ($masalah as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('masalah_id', $aturan->masalah_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->kode_masalah }} - {{ $item->nama_masalah }}
                                    </option>
                                @endforeach
                            </select>
                            @error('masalah_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pilih Gejala -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Gejala <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2 max-h-60 overflow-y-auto border border-gray-200 rounded-md p-4">
                                @foreach ($gejala as $item)
                                    <div class="flex items-start space-x-3">
                                        <input type="checkbox" name="gejala[]" value="{{ $item->id }}"
                                            id="gejala_{{ $item->id }}"
                                            {{ in_array($item->id, old('gejala', $aturan->gejala->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="gejala_{{ $item->id }}" class="flex-1 text-sm text-gray-900">
                                            <span class="font-medium">{{ $item->kode_gejala }}</span> -
                                            {{ $item->nama_gejala }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('gejala')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('gejala.*')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <x-secondary-link :href="route('admin.aturan.index')">
                                Batal
                            </x-secondary-link>
                            <x-primary-button type="submit">
                                Update Aturan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script untuk memudahkan seleksi gejala
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="gejala[]"]');

            // Tambahkan tombol select all/none
            const gejalaContainer = document.querySelector('.space-y-2');
            const buttonContainer = document.createElement('div');
            buttonContainer.className = 'flex space-x-2 mb-3 pb-3 border-b border-gray-200';

            const selectAllBtn = document.createElement('button');
            selectAllBtn.type = 'button';
            selectAllBtn.className = 'text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded';
            selectAllBtn.textContent = 'Pilih Semua';
            selectAllBtn.onclick = function() {
                checkboxes.forEach(cb => cb.checked = true);
            };

            const selectNoneBtn = document.createElement('button');
            selectNoneBtn.type = 'button';
            selectNoneBtn.className = 'text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded';
            selectNoneBtn.textContent = 'Hapus Semua';
            selectNoneBtn.onclick = function() {
                checkboxes.forEach(cb => cb.checked = false);
            };

            buttonContainer.appendChild(selectAllBtn);
            buttonContainer.appendChild(selectNoneBtn);
            gejalaContainer.insertBefore(buttonContainer, gejalaContainer.firstChild);
        });
    </script>
</x-app-layout>
