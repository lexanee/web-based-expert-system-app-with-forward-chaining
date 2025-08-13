<x-app-layout>
    <x-slot name="title">
        Dashboard | Admin Panel Sistem Pakar IOTACE
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Dashboard</h3>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class=" p-6 rounded-lg border">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium">Total Gejala</p>
                                    <p class="text-2xl font-bold">{{ \App\Models\Gejala::count() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 rounded-lg border">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium">Total Masalah</p>
                                    <p class="text-2xl font-bold">{{ \App\Models\Masalah::count() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 rounded-lg border ">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium">Total Aturan</p>
                                    <p class="text-2xl font-bold">{{ \App\Models\Aturan::count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Management Modules -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Manajemen Gejala -->
                        <div class="bg-white border border-gray-200 rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="ml-3 text-lg font-medium text-gray-900">Manajemen Gejala</h4>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">Kelola data gejala dalam sistem pakar</p>
                                <div class="space-y-2">
                                    <x-primary-button onclick="window.location.href='{{ route('admin.gejala.index') }}'"
                                        class="w-full justify-center">
                                        Lihat Semua Gejala
                                    </x-primary-button>
                                    <x-secondary-link :href="route('admin.gejala.create')" class="w-full justify-center">
                                        Tambah Gejala Baru
                                    </x-secondary-link>
                                </div>
                            </div>
                        </div>

                        <!-- Manajemen Masalah -->
                        <div class="bg-white border border-gray-200 rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="p-2 bg-green-100 rounded-lg">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="ml-3 text-lg font-medium text-gray-900">Manajemen Masalah</h4>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">Kelola data masalah dan solusinya</p>
                                <div class="space-y-2">
                                    <x-primary-button
                                        onclick="window.location.href='{{ route('admin.masalah.index') }}'"
                                        class="w-full justify-center">
                                        Lihat Semua Masalah
                                    </x-primary-button>
                                    <x-secondary-link :href="route('admin.masalah.create')" class="w-full justify-center">
                                        Tambah Masalah Baru
                                    </x-secondary-link>
                                </div>
                            </div>
                        </div>

                        <!-- Manajemen Aturan -->
                        <div class="bg-white border border-gray-200 rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="p-2 bg-purple-100 rounded-lg">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="ml-3 text-lg font-medium text-gray-900">Manajemen Aturan</h4>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">Kelola aturan diagnosis sistem pakar</p>
                                <div class="space-y-2">
                                    <x-primary-button onclick="window.location.href='{{ route('admin.aturan.index') }}'"
                                        class="w-full justify-center">
                                        Lihat Semua Aturan
                                    </x-primary-button>
                                    <x-secondary-link :href="route('admin.aturan.create')" class="w-full justify-center">
                                        Tambah Aturan Baru
                                    </x-secondary-link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reporting & Analysis Modules -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Riwayat Diagnosis -->
                        <div class="bg-white border border-gray-200 rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="p-2 bg-yellow-100 rounded-lg">
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="ml-3 text-lg font-medium text-gray-900">Riwayat Diagnosis</h4>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">Lihat dan analisis riwayat diagnosis pengguna</p>
                                <div class="space-y-2">
                                    <x-primary-button
                                        onclick="window.location.href='{{ route('admin.riwayat-diagnosis.index') }}'"
                                        class="w-full justify-center">
                                        Lihat Semua Riwayat
                                    </x-primary-button>
                                    <div class="flex space-x-2">
                                        <x-success-link :href="route('admin.riwayat-diagnosis.export.excel')" class="flex-1 justify-center text-xs">
                                            📊 Excel
                                        </x-success-link>
                                        <x-warning-link :href="route('admin.riwayat-diagnosis.export.pdf')" class="flex-1 justify-center text-xs">
                                            📄 PDF
                                        </x-warning-link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Laporan Pengguna -->
                        <div class="bg-white border border-gray-200 rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="p-2 bg-orange-100 rounded-lg">
                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2v0a2 2 0 01-2-2v-2a2 2 0 00-2-2H8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="ml-3 text-lg font-medium text-gray-900">Riwayat Lapor Masalah</h4>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">Lihat dan analisis laporan masalah dari pengguna
                                </p>
                                </p>
                                <div class="space-y-2">
                                    <x-primary-button
                                        onclick="window.location.href='{{ route('admin.riwayat-lapor-masalah.index') }}'"
                                        class="w-full justify-center">
                                        Lihat Semua Riwayat
                                    </x-primary-button>
                                    <div class="flex space-x-2">
                                        <x-success-link :href="route('admin.riwayat-lapor-masalah.export.excel')" class="flex-1 justify-center text-xs">
                                            📊 Excel
                                        </x-success-link>
                                        <x-warning-link :href="route('admin.riwayat-lapor-masalah.export.pdf')" class="flex-1 justify-center text-xs">
                                            📄 PDF
                                        </x-warning-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity (if needed) -->
                    <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Sistem</h4>
                        <div class="grid grid-cols-2 md:grid-cols-6 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">Total Data:</p>
                                <p class="font-semibold">
                                    {{ \App\Models\Gejala::count() + \App\Models\Masalah::count() + \App\Models\Aturan::count() }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600">Data Gejala:</p>
                                <p class="font-semibold text-blue-600">{{ \App\Models\Gejala::count() }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Data Masalah:</p>
                                <p class="font-semibold text-green-600">{{ \App\Models\Masalah::count() }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Data Aturan:</p>
                                <p class="font-semibold text-purple-600">{{ \App\Models\Aturan::count() }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Total Diagnosis:</p>
                                <p class="font-semibold text-yellow-600">{{ \App\Models\RiwayatDiagnosis::count() }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600">Total Lapor Masalah:</p>
                                <p class="font-semibold text-orange-600">
                                    {{ \App\Models\RiwayatLaporMasalah::count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
