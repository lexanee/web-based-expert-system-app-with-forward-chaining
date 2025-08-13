<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Riwayat Lapor Masalah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 12pt;
            margin: 0;
            color: #333;
        }

        .header p {
            margin: 5px 0 0;
            color: #666;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f5f5f5;
            font-weight: bold;
            font-size: 8pt;
        }

        td {
            font-size: 8pt;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: bold;
        }

        .badge-issue-teknis {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-bug {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-saran {
            background: #dbeafe;
            color: #2563eb;
        }

        .badge-baru {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-diproses {
            background: #dbeafe;
            color: #2563eb;
        }

        .badge-selesai {
            background: #d1fae5;
            color: #059669;
        }

        .badge-vendor {
            background: #dbeafe;
            color: #2563eb;
        }

        .badge-internal {
            background: #dcfce7;
            color: #166534;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .page-break {
            page-break-after: avoid;
        }

        .info-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .info-row {
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
        }

        .info-label {
            font-weight: bold;
            color: #333;
            width: 30%;
        }

        .info-value {
            width: 65%;
        }

        .detail-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .detail-title {
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .detail-content {
            line-height: 1.6;
            color: #555;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>

<body>
    <!-- Letterhead -->
    <div style="margin-bottom:20px;">
        <table width="100%" style="border: none; border-collapse: collapse;">
            <tr>
                <td style="width:50%; text-align:left; vertical-align:middle; border: none;">
                    <img src="{{ public_path('images/kop-logo.png') }}" style="max-width:230px;" alt="Logo" />
                </td>
                <td style="width:50%; text-align:right; vertical-align:middle; border: none;">
                    <h2 style="margin:0; font-size:8pt;">PT IOTACE SOLUSI INDONESIA</h2>
                    <p style="margin:0; font-size:8pt;">
                        Jl. Duren No. 9, RT 001 RW 009, Utan Kayu Utara,<br>
                        Kec. Matraman, Jakarta Timur, DKI Jakarta, 13120<br>
                        <b>Telepon:</b> 08119008089 &bull; <b>Email:</b> <a
                            href="mailto:contact@iotace.co.id">contact@iotace.co.id</a>
                    </p>
                </td>
            </tr>
        </table>
    </div>

    @if (isset($laporan) && $laporan->count() > 0)
        @if (isset($single) && $single)
            <!-- Single Report Detail -->
            <div class="info-section">
                <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 11pt;">Informasi Laporan</h3>
                <div class="info-row">
                    <div class="info-label">ID Laporan:</div>
                    <div class="info-value">#{{ $laporan->first()->id }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal:</div>
                    <div class="info-value">{{ $laporan->first()->created_at->format('d/m/Y H:i:s') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jenis Laporan:</div>
                    <div class="info-value">
                        <span
                            class="badge badge-{{ strtolower(str_replace(' ', '-', $laporan->first()->jenis_laporan)) }}">
                            {{ $laporan->first()->jenis_laporan }}
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tipe Pengguna:</div>
                    <div class="info-value">
                        <span class="badge badge-{{ strtolower($laporan->first()->tipe_pengguna) }}">
                            {{ $laporan->first()->tipe_pengguna }}
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value">
                        <span class="badge badge-{{ strtolower($laporan->first()->status) }}">
                            {{ $laporan->first()->status }}
                        </span>
                    </div>
                </div>
            </div>

            @if ($laporan->first()->kontak)
                <!-- Contact Information -->
                <div class="detail-section">
                    <div class="detail-title">Informasi Kontak</div>
                    <div class="info-row">
                        <div class="info-label">Kontak:</div>
                        <div class="info-value">{{ $laporan->first()->kontak }}</div>
                    </div>
                    @if ($laporan->first()->lampiran)
                        <div class="info-row">
                            <div class="info-label">Lampiran:</div>
                            <div class="info-value">{{ basename($laporan->first()->lampiran) }}</div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Report Description -->
            <div class="detail-section">
                <div class="detail-title">Deskripsi Laporan</div>
                <div class="detail-content">{{ $laporan->first()->deskripsi }}</div>
            </div>
        @else
            <!-- Title and Info -->
            <div class="header">
                <h1>Laporan Riwayat Lapor Masalah</h1>
                <p>Sistem E-Procurement IOTACE</p>
            </div>
            <!-- Info Section -->
            <div class="info">
                @php
                    $filtersData = request()->only([
                        'jenis_laporan',
                        'status',
                        'tipe_pengguna',
                        'tanggal_mulai',
                        'tanggal_selesai',
                    ]);
                    $filtersData = array_filter($filtersData);
                @endphp
                @if (count($filtersData))
                    <p>Filter: @foreach ($filtersData as $key => $value)
                            {{ ucwords(str_replace('_', ' ', $key)) }}:
                            {{ $value }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </p>
                @endif
                <p><strong>Total Data:</strong> {{ $laporan->count() }} record</p>
                <p><strong>Periode:</strong> {{ $laporan->first()?->created_at?->format('d/m/Y') ?? 'N/A' }} -
                    {{ $laporan->last()?->created_at?->format('d/m/Y') ?? 'N/A' }}</p>
            </div>

            <!-- Multiple Reports Table -->
            <table>
                <thead>
                    <tr>
                        <th style="width:5%; text-align:center; vertical-align:middle;">No</th>
                        <th style="width:12%; text-align:center; vertical-align:middle;">Tanggal</th>
                        <th style="width:12%; text-align:center; vertical-align:middle;">Jenis</th>
                        <th style="width:12%; text-align:center; vertical-align:middle;">Tipe Pengguna</th>
                        <th style="width:15%; text-align:center; vertical-align:middle;">Kontak</th>
                        <th style="width:32%; text-align:center; vertical-align:middle;">Deskripsi</th>
                        <th style="width:12%; text-align:center; vertical-align:middle;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $index => $item)
                        <tr>
                            <td style="text-align:center;">{{ $index + 1 }}</td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td style="text-align:center;">
                                <span
                                    class="badge
                                badge-{{ strtolower(str_replace(' ', '-', $item->jenis_laporan)) }}">
                                    {{ $item->jenis_laporan }}</span>
                            </td>
                            <td style="text-align:center;">
                                <span
                                    class="badge
                                badge-{{ strtolower($item->tipe_pengguna) }}">{{ $item->tipe_pengguna }}</span>
                            </td>
                            <td>{{ $item->kontak ?? '-' }}</td>
                            <td>{{ Str::limit($item->deskripsi, 80) }}</td>
                            <td style="text-align:center; vertical-align:top;"><span
                                    class="badge badge-{{ strtolower($item->status) }}">{{ $item->status }}</span>
                            </td>
                        </tr>
                        @if (($index + 1) % 20 == 0 && !$loop->last)
                </tbody>
            </table>

            <table>
                <thead>
                    <tr>
                        <th style="width:5%; text-align:center; vertical-align:middle;">No</th>
                        <th style="width:12%; text-align:center; vertical-align:middle;">Tanggal</th>
                        <th style="width:12%; text-align:center; vertical-align:middle;">Jenis</th>
                        <th style="width:12%; text-align:center; vertical-align:middle;">Tipe Pengguna</th>
                        <th style="width:15%; text-align:center; vertical-align:middle;">Kontak</th>
                        <th style="width:32%; text-align:center; vertical-align:middle;">Deskripsi</th>
                        <th style="width:12%; text-align:center; vertical-align:middle;">Status</th>
                    </tr>
                </thead>
                <tbody>
        @endif
    @endforeach
    </tbody>
    </table>

    <!-- Summary -->
    <div class="page-break"></div>
    <div style="margin-top: 30px; padding: 15px; background-color: #f9f9f9; border: 1px solid #ddd;">
        <h3 style="margin-top: 0;">Ringkasan</h3>
        <div style="display: flex; justify-content: space-between;">
            <div style="width:48%;">
                <p><strong>Berdasarkan Tipe Pengguna:</strong></p>
                <ul style="margin:5px 0; padding-left:20px;">
                    <li>Vendor: {{ $laporan->where('tipe_pengguna', 'Vendor')->count() }} laporan</li>
                    <li>Internal: {{ $laporan->where('tipe_pengguna', 'Internal')->count() }} laporan</li>
                </ul>
            </div>
            <div style="width:48%;">
                <p><strong>Berdasarkan Status:</strong></p>
                <ul style="margin:5px 0; padding-left:20px;">
                    <li>Baru: {{ $laporan->where('status', 'Baru')->count() }} laporan</li>
                    <li>Diproses: {{ $laporan->where('status', 'Diproses')->count() }} laporan</li>
                    <li>Selesai: {{ $laporan->where('status', 'Selesai')->count() }} laporan</li>
                </ul>
            </div>
        </div>
    </div>
    @endif
    <!-- Sign Box -->
    <div style="text-align: right; margin-top: 30px;">
        <div style="display: inline-block; text-align: center;">
            <p style="font-size: 10pt; margin: 0px">Mengetahui,</p>
            <p style="font-size: 10pt; margin: 0px">
                {{ 'Jakarta, ' . now()->locale('id')->translatedFormat('l, j F Y') }}</p>
            <p style="font-size: 10pt; font-weight: bold; margin: 0px">PT IOTACE SOLUSI INDONESIA</p>
            <div style="width: 200px; border-top: 1px solid #000; margin-top: 120px;">
                <span style="font-size: 10pt;">Nadeem</span>
            </div>
            <p style="font-size: 10pt; font-weight: bold; margin: 0px">IT Manager</p>
        </div>
    </div>
@else
    <div class="no-data">
        Tidak ada data riwayat lapor masalah yang ditemukan.
    </div>
    @endif

    <div class="footer">
        <table width="100%" style="border: none; border-collapse: collapse;">
            <tr>
                <td style="width:50%; text-align:left; vertical-align:middle; border: none;">
                    <p style="margin:0; font-size:8pt;">Dicetak pada:
                        {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
                </td>
                <td style="width:50%; text-align:right; vertical-align:middle; border: none;">
                    <p style="margin:0; font-size:8pt;">PT IOTACE SOLUSI INDONESIA</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
