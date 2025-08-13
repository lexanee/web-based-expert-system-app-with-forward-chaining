<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Laporan Daftar Masalah</title>
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
            margin: 0;
            font-size: 12pt;
            color: #333;
        }

        .header p {
            margin: 5px 0 0 0;
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
            background-color: #f5f5f5;
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
    <div style="margin-bottom: 20px">
        <table width="100%" style="border: none; border-collapse: collapse">
            <tr>
                <td
                    style="
                            width: 50%;
                            text-align: left;
                            vertical-align: middle;
                            border: none;
                        ">
                    <img src="{{ public_path('images/kop-logo.png') }}" style="max-width: 230px" alt="Logo" />
                </td>
                <td
                    style="
                            width: 50%;
                            text-align: right;
                            vertical-align: middle;
                            border: none;
                        ">
                    <h2 style="margin: 0; font-size: 8pt">
                        PT IOTACE SOLUSI INDONESIA
                    </h2>
                    <p style="margin: 0; font-size: 8pt">
                        Jl. Duren No. 9, RT 001 RW 009, Utan Kayu Utara,<br />
                        Kec. Matraman, Jakarta Timur, DKI Jakarta, 13120<br />
                        <b>Telepon:</b> 08119008089 &bull; <b>Email:</b>
                        <a href="mailto:contact@iotace.co.id">contact@iotace.co.id</a>
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <!-- Title and Info -->
    <div class="header">
        <h1>Laporan Daftar Masalah</h1>
        <p>
            Basis Pengetahuan Sistem Pakar
        </p>
    </div>

    <div class="info">
        @php
            $filterParams = request()->only(['tanggal_mulai', 'tanggal_selesai']);
            $filterParams = array_filter($filterParams);
        @endphp
        @if ($filterParams && count($filterParams))
            <p>
                Filter: @foreach ($filterParams as $key => $value)
                    {{ ucwords(str_replace('_', ' ', $key)) }}: {{ $value }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </p>
        @endif
        <p><strong>Total Data:</strong> {{ $masalah->count() }} record</p>
        <p>
            <strong>Periode:</strong> {{ $masalah->first()?->created_at?->format('d/m/Y') ?? 'N/A' }} -
            {{ $masalah->last()?->created_at?->format('d/m/Y') ?? 'N/A' }}
        </p>
    </div>

    @if ($masalah->count() > 0)
        <table>
            <thead>
                <tr>
                    <th
                        style="
                            width: 5%;
                            text-align: center;
                            vertical-align: middle;
                        ">
                        No
                    </th>
                    <th
                        style="
                            width: 15%;
                            text-align: center;
                            vertical-align: middle;
                        ">
                        Kode Masalah
                    </th>
                    <th
                        style="
                            width: 30%;
                            text-align: center;
                            vertical-align: middle;
                        ">
                        Nama Masalah
                    </th>
                    <th
                        style="
                            width: 35%;
                            text-align: center;
                            vertical-align: middle;
                        ">
                        Solusi
                    </th>
                    <th
                        style="
                            width: 15%;
                            text-align: center;
                            vertical-align: middle;
                        ">
                        Tanggal Dibuat
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($masalah as $index => $item)
                    <tr>
                        <td style="text-align: center">{{ $index + 1 }}</td>
                        <td style="text-align: center;">
                            <span class="badge">{{ $item->kode_masalah }}</span>
                        </td>
                        <td>{{ $item->nama_masalah }}</td>
                        <td>{{ Str::limit($item->solusi, 100) }}</td>
                        <td style="text-align: center;">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="page-break"></div>
        <div
            style="
                margin-top: 30px;
                padding: 15px;
                background-color: #f9f9f9;
                border: 1px solid #ddd;
            ">
            <h3 style="margin-top: 0">Ringkasan</h3>
            <div style="display: flex; justify-content: space-between">
                <div>
                    <p><strong>Statistik Masalah:</strong></p>
                    <ul style="margin: 5px 0; padding-left: 20px">
                        <li>Total Masalah: {{ $masalah->count() }} masalah</li>
                        <li>Dengan Solusi: {{ $masalah->whereNotNull('solusi')->where('solusi', '!=', '')->count() }}
                            masalah</li>
                        <li>Tanpa Solusi:
                            {{ $masalah->filter(function ($item) {return empty($item->solusi);})->count() }}
                        </li>
                        <li>Rata-rata Panjang Solusi:
                            {{ number_format($masalah->where('solusi', '!=', '')->avg(function ($item) {return strlen($item->solusi ?? '');})) }}
                            karakter</li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <div class="no-data">
            <p>Tidak ada data masalah untuk ditampilkan.</p>
        </div>
    @endif

    <!-- Sign Box -->
    <div style="text-align: right; margin-top: 30px">
        <div style="display: inline-block; text-align: center">
            <p style="font-size: 10pt; margin: 0px">Mengetahui,</p>
            <p style="font-size: 10pt; margin: 0px">
                {{ 'Jakarta, ' . now()->locale('id')->translatedFormat('l, j F Y') }}
            </p>
            <p style="font-size: 10pt; font-weight: bold; margin: 0px">
                PT IOTACE SOLUSI INDONESIA
            </p>
            <div
                style="
                        width: 200px;
                        border-top: 1px solid #000;
                        margin-top: 120px;
                    ">
                <span style="font-size: 10pt">Rasyid</span>
            </div>
            <p style="font-size: 10pt; font-weight: bold; margin: 0px">
                IT Operation
            </p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <table width="100%" style="border: none; border-collapse: collapse">
            <tr>
                <td
                    style="
                            width: 50%;
                            text-align: left;
                            vertical-align: middle;
                            border: none;
                        ">
                    <p style="margin: 0; font-size: 8pt">
                        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
                    </p>
                </td>
                <td
                    style="
                            width: 50%;
                            text-align: right;
                            vertical-align: middle;
                            border: none;
                        ">
                    <p style="margin: 0; font-size: 8pt">
                        PT IOTACE SOLUSI INDONESIA
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
