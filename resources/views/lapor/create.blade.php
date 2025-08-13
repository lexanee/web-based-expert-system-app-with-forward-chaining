<x-landing-layout>
    <x-slot name="title">Laporkan Masalah | Sistem Pakar IOTACE</x-slot>

    <!-- Full viewport container with flex centering -->
    <div class="min-h-screen flex items-center justify-center px-6 py-8">
        <div class="w-full max-w-3xl">
            <!-- Main Card with consistent sizing -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="text-6xl mb-4">📋</div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-4 text-slate-800">Laporkan Masalah</h1>
                    <p class="text-lg text-gray-600">Sampaikan masalah teknis yang Anda alami</p>
                </div>

                <!-- Navigation Back -->
                <div class="mb-6">
                    <a href="{{ url()->previous() }}"
                        class="text-gray-600 hover:text-slate-800 text-sm transition-colors">
                        ← Kembali
                    </a>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('lapor.store') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <!-- Error Display -->
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-300 rounded-lg p-4">
                            <strong class="text-red-700">Terjadi kesalahan:</strong>
                            <ul class="mt-2 ml-4 list-disc text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Basic Information -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="jenis_laporan" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Laporan <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_laporan" id="jenis_laporan" required
                                class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-slate-800 placeholder-gray-500 focus:ring-blue-500 focus:border-blue-500">
                                <option value="" class="bg-white">-- Pilih Jenis --</option>
                                <option value="Issue Teknis" class="bg-white"
                                    {{ old('jenis_laporan') == 'Issue Teknis' ? 'selected' : '' }}>
                                    Issue Teknis</option>
                                <option value="Bug" class="bg-white"
                                    {{ old('jenis_laporan') == 'Bug' ? 'selected' : '' }}>Bug</option>
                                <option value="Saran" class="bg-white"
                                    {{ old('jenis_laporan') == 'Saran' ? 'selected' : '' }}>Saran
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="tipe_pengguna" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Pengguna <span class="text-red-500">*</span>
                            </label>
                            <select name="tipe_pengguna" id="tipe_pengguna" required
                                class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-slate-800 placeholder-gray-500 focus:ring-blue-500 focus:border-blue-500">
                                <option value="" class="bg-white">-- Pilih Tipe --</option>
                                <option value="Vendor" class="bg-white"
                                    {{ old('tipe_pengguna') == 'Vendor' ? 'selected' : '' }}>Vendor
                                </option>
                                <option value="Internal" class="bg-white"
                                    {{ old('tipe_pengguna') == 'Internal' ? 'selected' : '' }}>Internal
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div>
                        <label for="kontak" class="block text-sm font-medium text-gray-700 mb-2">
                            Kontak (Email/Telepon)
                        </label>
                        <input type="text" name="kontak" id="kontak" value="{{ old('kontak') }}"
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-slate-800 placeholder-gray-500 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="email@example.com atau 08xxxxxxxxxx">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Masalah <span class="text-red-500">*</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="5" required
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-slate-800 placeholder-gray-500 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Jelaskan masalah secara detail...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-2">
                            Lampiran (Opsional)
                        </label>
                        <input type="file" name="lampiran" accept="image/*,.pdf,.doc,.docx" id="lampiran"
                            class="block w-full text-sm text-gray-600
                                   file:mr-4 file:py-2 file:px-4 
                                   file:rounded file:border-0 
                                   file:text-sm file:font-medium
                                   file:bg-blue-50 file:text-blue-700
                                   hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF, DOC, DOCX (Max: 10MB)</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-xl font-semibold transition-colors">
                            📤 Kirim Laporan
                        </button>
                    </div>
                </form>

                <!-- Help Section -->
                {{-- <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mt-6">
                    <div class="flex items-start space-x-3">
                        <div class="text-yellow-600 text-lg">💡</div>
                        <div class="flex-1">
                            <h3 class="font-medium text-slate-800 mb-2">Tips Laporan yang Efektif</h3>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Jelaskan masalah secara detail dan spesifik</li>
                                <li>• Sertakan langkah-langkah yang menyebabkan masalah</li>
                                <li>• Lampirkan screenshot jika memungkinkan</li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</x-landing-layout>
