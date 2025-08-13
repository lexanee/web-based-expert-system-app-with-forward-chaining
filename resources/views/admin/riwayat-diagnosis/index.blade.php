<x-app-layout>
    <x-slot name="title">
        Riwayat Diagnosis | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Diagnosis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header dengan filter dan export buttons -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Data Riwayat Diagnosis</h3>
                        <div class="flex space-x-2">
                            <x-success-link :href="route('admin.riwayat-diagnosis.export.excel', request()->query())">
                                📊 Export Excel
                            </x-success-link>
                            <x-warning-link :href="route('admin.riwayat-diagnosis.export.pdf', request()->query())">
                                📄 Export PDF
                            </x-warning-link>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <form method="GET" action="{{ route('admin.riwayat-diagnosis.index') }}"
                            class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Pengguna</label>
                                <select name="tipe_pengguna"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua</option>
                                    <option value="Vendor" {{ request('tipe_pengguna') == 'Vendor' ? 'selected' : '' }}>
                                        Vendor</option>
                                    <option value="Internal"
                                        {{ request('tipe_pengguna') == 'Internal' ? 'selected' : '' }}>Internal</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Proses</label>
                                <select name="proses"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua</option>
                                    <!-- Vendor Processes -->
                                    <optgroup label="Vendor">
                                        @foreach ($prosesVendor as $proses)
                                            <option value="{{ $proses }}"
                                                {{ request('proses') == $proses ? 'selected' : '' }}>
                                                {{ $proses }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <!-- Internal Processes -->
                                    <optgroup label="Internal">
                                        @foreach ($prosesInternal as $proses)
                                            <option value="{{ $proses }}"
                                                {{ request('proses') == $proses ? 'selected' : '' }}>
                                                {{ $proses }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="flex items-end space-x-2">
                                <x-primary-button type="submit">
                                    Filter
                                </x-primary-button>
                                <x-secondary-link :href="route('admin.riwayat-diagnosis.index')">
                                    Reset
                                </x-secondary-link>
                            </div>
                        </form>
                    </div>

                    <!-- Alert untuk notifikasi -->
                    @if (session('success'))
                        <x-alert type="success">
                            {{ session('success') }}
                        </x-alert>
                    @endif

                    <!-- Tabel Riwayat Diagnosis -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipe Pengguna</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Proses</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah Gejala</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Masalah Terdeteksi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($riwayat as $index => $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $item->tipe_pengguna == 'Vendor' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $item->tipe_pengguna }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if ($item->proses)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    {{ $item->proses }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $item->jumlah_gejala ?? 0 }}
                                                Gejala
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if ($item->masalah)
                                                <div>
                                                    <span class="font-medium">{{ $item->masalah->kode_masalah }}</span>
                                                    <p class="text-xs text-gray-500">
                                                        {{ Str::limit($item->masalah->nama_masalah, 50) }}</p>
                                                </div>
                                            @else
                                                <span class="text-red-500 text-xs">Tidak ada masalah terdeteksi</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <x-secondary-link :href="route('admin.riwayat-diagnosis.show', $item)">
                                                Detail
                                            </x-secondary-link>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Tidak ada data riwayat diagnosis.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $riwayat->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
