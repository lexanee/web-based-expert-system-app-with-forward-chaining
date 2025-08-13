<x-app-layout>
    <x-slot name="title">
        Detail Gejala | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Gejala') }}
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

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Gejala</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kode Gejala</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $gejala->kode_gejala }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $gejala->created_at->format('d/m/Y H:i:s') }}
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Nama Gejala</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $gejala->nama_gejala }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipe Pengguna</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    @if ($gejala->tipe_pengguna)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gejala->tipe_pengguna == 'Vendor' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $gejala->tipe_pengguna }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Proses</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $gejala->proses ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Dibuat</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $gejala->created_at->format('d/m/Y H:i:s') }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Terakhir Diperbarui</label>
                                <p class="mt-1 text-sm text-gray-900 bg-white p-3 rounded border">
                                    {{ $gejala->updated_at->format('d/m/Y H:i:s') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <x-secondary-link :href="route('admin.gejala.edit', $gejala)">
                            Edit Gejala
                        </x-secondary-link>
                        <form action="{{ route('admin.gejala.destroy', $gejala) }}" method="POST" class="inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus gejala ini?')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">
                                Hapus Gejala
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
