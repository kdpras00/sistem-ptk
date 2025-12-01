<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Dokumen PTK</title>
    <style>
        @media print {
            .no-print {
                display: none;
            }
            @page {
                margin: 1cm;
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #000;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #000;
        }
        
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
        }
        
        .info {
            margin-bottom: 20px;
        }
        
        .info table {
            width: auto;
            margin-bottom: 10px;
        }
        
        .info td {
            padding: 3px 10px 3px 0;
            font-size: 13px;
        }
        
        .info td:first-child {
            width: 150px;
            font-weight: bold;
        }
        
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 12px;
        }
        
        table.data th {
            background-color: #2563eb;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #1d4ed8;
        }
        
        table.data td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        table.data tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        table.data tbody tr:hover {
            background-color: #f3f4f6;
        }
        
        .footer {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        
        .signature {
            float: right;
            width: 250px;
            text-align: center;
        }
        
        .signature p {
            margin: 5px 0;
            font-size: 13px;
        }
        
        .signature .line {
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        
        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        
        .btn-print {
            background-color: #2563eb;
            color: white;
        }
        
        .btn-back {
            background-color: #6b7280;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
        
        .summary {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .summary h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        
        .summary p {
            margin: 5px 0;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <!-- Print/Back Buttons -->
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak Laporan</button>
        <a href="{{ route('staf-tu.documents.index') }}" class="btn btn-back">← Kembali</a>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>LAPORAN DOKUMEN PTK</h1>
        <p>Sistem Pengarsipan Pendidik dan Tenaga Kependidikan</p>
    </div>

    <!-- Report Info -->
    <div class="info">
        <table>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ now()->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Waktu Cetak</td>
                <td>: {{ now()->format('H:i') }} WIB</td>
            </tr>
            <tr>
                <td>Dicetak Oleh</td>
                <td>: {{ auth()->user()->name }}</td>
            </tr>
        </table>
    </div>

    <!-- Summary -->
    <div class="summary">
        <h3>Ringkasan</h3>
        <p><strong>Total Dokumen:</strong> {{ $documents->count() }}</p>
        <p><strong>Total PTK:</strong> {{ $documents->groupBy('ptk_id')->count() }}</p>
        <p><strong>Kategori Terbanyak:</strong> {{ $documents->groupBy('category_id')->sortByDesc(function($item) { return $item->count(); })->first()?->first()->category->nama_kategori ?? '-' }}</p>
    </div>

    <!-- Filter Info -->
    @if(request()->filled('category_id') || request()->filled('start_date') || request()->filled('end_date'))
    <div class="info">
        <p><strong>Filter yang Diterapkan:</strong></p>
        <table>
            @if(request()->filled('category_id'))
                @php
                    $category = \App\Models\Category::find(request('category_id'));
                @endphp
                <tr>
                    <td>Kategori</td>
                    <td>: {{ $category->nama_kategori ?? '-' }}</td>
                </tr>
            @endif
            @if(request()->filled('start_date'))
                <tr>
                    <td>Tanggal Mulai</td>
                    <td>: {{ \Carbon\Carbon::parse(request('start_date'))->format('d F Y') }}</td>
                </tr>
            @endif
            @if(request()->filled('end_date'))
                <tr>
                    <td>Tanggal Akhir</td>
                    <td>: {{ \Carbon\Carbon::parse(request('end_date'))->format('d F Y') }}</td>
                </tr>
            @endif
        </table>
    </div>
    @endif

    <!-- Data Table -->
    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nomor Dokumen</th>
                <th>Nama Dokumen</th>
                <th>PTK</th>
                <th>Kategori</th>
                <th>Tanggal Dokumen</th>
                <th>Tanggal Upload</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $index => $document)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $document->nomor_dokumen }}</td>
                    <td>{{ $document->nama_dokumen }}</td>
                    <td>{{ $document->ptk->nama_lengkap }}<br><small style="color: #666;">{{ $document->ptk->nip }}</small></td>
                    <td>{{ $document->category->nama_kategori }}</td>
                    <td>{{ $document->tanggal_dokumen->format('d/m/Y') }}</td>
                    <td>{{ $document->tanggal_upload->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; color: #999;">
                        Tidak ada data dokumen
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer with Signature -->
    <div class="footer">
        <div class="signature">
            <p>{{ now()->format('d F Y') }}</p>
            <p><strong>Staf Tata Usaha</strong></p>
            <div class="line">
                <strong>{{ auth()->user()->name }}</strong>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>

