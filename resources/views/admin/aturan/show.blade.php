<x-app-layout>
    <x-slot name="title">
        Detail Aturan | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Aturan') }}
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

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Aturan</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kode Aturan</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $aturan->kode_aturan }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $aturan->created_at->format('d/m/Y H:i:s') }}
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Masalah</label>
                                <div class="mt-1 bg-white p-3 rounded border">
                                    @if ($aturan->masalah)
                                        <div class="flex items-start space-x-3">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $aturan->masalah->kode_masalah }}
                                            </span>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $aturan->masalah->nama_masalah }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ $aturan->masalah->solusi }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-sm text-red-500">Masalah tidak ditemukan</p>
                                    @endif
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Gejala ({{ $aturan->gejala->count() }} gejala)
                                </label>
                                <div class="bg-white rounded border">
                                    @if ($aturan->gejala->count() > 0)
                                        <div class="divide-y divide-gray-200">
                                            @foreach ($aturan->gejala as $gejala)
                                                <div class="p-3 flex items-start space-x-3">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $gejala->kode_gejala }}
                                                    </span>
                                                    <p class="text-sm text-gray-900">{{ $gejala->nama_gejala }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="p-3 text-sm text-gray-500">Tidak ada gejala terkait</p>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Terakhir Diperbarui</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $aturan->updated_at->format('d/m/Y H:i:s') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <x-secondary-link :href="route('admin.aturan.edit', $aturan)">
                            Edit Aturan
                        </x-secondary-link>
                        <form action="{{ route('admin.aturan.destroy', $aturan) }}" method="POST" class="inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus aturan ini?')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">
                                Hapus Aturan
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
