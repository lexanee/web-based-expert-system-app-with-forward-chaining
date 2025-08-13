<x-app-layout>
    <x-slot name="title">
        Detail Masalah | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Masalah') }}
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

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Masalah</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kode Masalah</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $masalah->kode_masalah }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $masalah->created_at->format('d/m/Y H:i:s') }}
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Nama Masalah</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $masalah->nama_masalah }}
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Solusi</label>
                                <div class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $masalah->solusi }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Terakhir Diperbarui</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $masalah->updated_at->format('d/m/Y H:i:s') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <x-secondary-link :href="route('admin.masalah.edit', $masalah)">
                            Edit Masalah
                        </x-secondary-link>
                        <form action="{{ route('admin.masalah.destroy', $masalah) }}" method="POST" class="inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus masalah ini?')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">
                                Hapus Masalah
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
