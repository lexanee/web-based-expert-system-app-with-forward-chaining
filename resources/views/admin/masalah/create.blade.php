<x-app-layout>
    <x-slot name="title">
        Tambah Masalah | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Masalah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.masalah.index') }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            ← Kembali ke Daftar Masalah
                        </a>
                    </div>

                    <form action="{{ route('admin.masalah.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Kode Masalah -->
                        <div>
                            <label for="kode_masalah" class="block text-sm font-medium text-gray-700">
                                Kode Masalah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kode_masalah" id="kode_masalah"
                                value="{{ old('kode_masalah') }}" placeholder="Contoh: M1, M2, M3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('kode_masalah')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Masalah -->
                        <div>
                            <label for="nama_masalah" class="block text-sm font-medium text-gray-700">
                                Nama Masalah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_masalah" id="nama_masalah"
                                value="{{ old('nama_masalah') }}" placeholder="Masukkan nama masalah..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('nama_masalah')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Solusi -->
                        <div>
                            <label for="solusi" class="block text-sm font-medium text-gray-700">
                                Solusi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="solusi" id="solusi" rows="5" placeholder="Masukkan solusi untuk masalah ini..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('solusi') }}</textarea>
                            @error('solusi')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-3">
                            <x-secondary-link :href="route('admin.masalah.index')">
                                Batal
                            </x-secondary-link>
                            <x-primary-button type="submit">
                                Simpan Masalah
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
