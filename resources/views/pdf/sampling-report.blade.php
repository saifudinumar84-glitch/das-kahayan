<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Pengujian Sampel — {{ $sampling->sampling_number }}</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9.5pt;
            color: #1e293b;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            border-bottom: 3px double #0f172a;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header-logo {
            width: 65px;
            text-align: center;
            vertical-align: middle;
        }
        .header-title {
            text-align: center;
            vertical-align: middle;
        }
        .header-title h2 {
            margin: 0;
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
        }
        .header-title h3 {
            margin: 2px 0;
            font-size: 10.5pt;
            color: #065f46;
            text-transform: uppercase;
        }
        .header-title p {
            margin: 0;
            font-size: 7.5pt;
            color: #475569;
        }
        .title-box {
            text-align: center;
            margin: 15px 0 10px 0;
        }
        .title-box h4 {
            margin: 0;
            font-size: 12pt;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .meta-table td {
            padding: 3px 4px;
            vertical-align: top;
            font-size: 9pt;
        }
        .meta-label {
            width: 28%;
            color: #475569;
        }
        .meta-value {
            width: 72%;
            font-weight: 600;
        }
        .section-box {
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 9.5pt;
            font-weight: bold;
            color: #065f46;
            text-transform: uppercase;
            margin-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 8.5pt;
        }
        .data-table th {
            background-color: #065f46;
            color: #ffffff;
            padding: 5px 6px;
            border: 1px solid #065f46;
            text-align: left;
        }
        .data-table td {
            padding: 5px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) {
            background: #ffffff;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 7.5pt;
            font-weight: bold;
            border-radius: 3px;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .signature-table {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <!-- KOP SURAT -->
    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="{{ public_path('images/logo-bpom.png') }}" alt="BPOM" style="width: 55px; height: auto;" onerror="this.style.display='none'">
            </td>
            <td class="header-title">
                <h2>BADAN PENGAWAS OBAT DAN MAKANAN</h2>
                <h3>BALAI BESAR PENGAWAS OBAT DAN MAKANAN DI PALANGKA RAYA</h3>
                <p>Jl. Tjilik Riwut Km. 2,5 Palangka Raya, Kalimantan Tengah &bull; Telp: (0536) 3221704 &bull; Email: bpom_palangkaraya@pom.go.id</p>
            </td>
        </tr>
    </table>

    <div class="title-box">
        <h4>LAPORAN HASIL PENGUJIAN LABORATORIUM</h4>
        <p>Nomor Sampling: {{ $sampling->sampling_number }}</p>
    </div>

    <!-- IDENTITAS SAMPEL -->
    <div class="section-box">
        <div class="section-title">I. Identitas Sampel Pangan</div>
        <table class="meta-table">
            <tr>
                <td class="meta-label">Nama Produk</td>
                <td class="meta-value">: {{ $sampling->product_name }}</td>
            </tr>
            <tr>
                <td class="meta-label">Merk / Brand</td>
                <td class="meta-value">: {{ $sampling->brand ?: '-' }}</td>
            </tr>
            <tr>
                <td class="meta-label">Jenis Pangan</td>
                <td class="meta-value">: {{ $sampling->foodType?->name }} ({{ $sampling->foodType?->category?->name }})</td>
            </tr>
            <tr>
                <td class="meta-label">Lokasi Pengambilan</td>
                <td class="meta-value">: {{ $sampling->sampling_location }}</td>
            </tr>
            <tr>
                <td class="meta-label">Tanggal Sampling</td>
                <td class="meta-value">: {{ $sampling->sampling_date?->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="meta-label">Tanggal Pengujian</td>
                <td class="meta-value">: {{ $sampling->test_date?->translatedFormat('d F Y') ?? 'Dalam proses' }}</td>
            </tr>
            <tr>
                <td class="meta-label">Petugas Pengambil</td>
                <td class="meta-value">: {{ $sampling->inspector?->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- HASIL PENGUJIAN -->
    <div class="section-title">II. Hasil Pengujian Parameter Mutu & Keamanan Pangan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Parameter Uji</th>
                <th style="width: 15%;">Nilai Hasil</th>
                <th style="width: 10%;">Satuan</th>
                <th style="width: 20%;">Batas Persyaratan</th>
                <th style="width: 15%;">Evaluasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sampling->testResults as $idx => $result)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td><strong>{{ $result->testParameter?->name ?? 'Parameter Uji' }}</strong></td>
                    <td>{{ $result->result_value }}</td>
                    <td>{{ $result->unit ?? '-' }}</td>
                    <td>{{ $result->requirement_limit ?? $result->testParameter?->standard_limit ?? '-' }}</td>
                    <td>
                        @if($result->compliance_status?->value === 'ms')
                            <span class="badge badge-success">Memenuhi Syarat</span>
                        @elseif($result->compliance_status?->value === 'tms')
                            <span class="badge badge-danger">Tidak Memenuhi</span>
                        @else
                            <span class="badge" style="background: #e2e8f0;">{{ $result->compliance_status?->value ?? '-' }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #64748b; padding: 12px;">Belum ada data pengujian parameter lab yang dicatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- KESIMPULAN AKHIR -->
    <div class="section-box" style="margin-top: 15px;">
        <div class="section-title">III. Kesimpulan Akhir & Rekomendasi</div>
        <table class="meta-table">
            <tr>
                <td class="meta-label">Kesimpulan Akhir</td>
                <td class="meta-value">
                    : @if(in_array($sampling->conclusion?->value, ['compliant', 'ms'], true))
                        <span style="color: #166534; font-size: 11pt; font-weight: bold;">MEMENUHI SYARAT (MS)</span>
                    @elseif(in_array($sampling->conclusion?->value, ['non_compliant', 'tms'], true))
                        <span style="color: #991b1b; font-size: 11pt; font-weight: bold;">TIDAK MEMENUHI SYARAT (TMS)</span>
                    @else
                        <span style="color: #92400e; font-size: 11pt; font-weight: bold;">DALAM PROSES PENGUJIAN</span>
                    @endif
                </td>
            </tr>
            @if($sampling->conclusion_notes)
            <tr>
                <td class="meta-label">Catatan Hasil Uji</td>
                <td class="meta-value">: {{ $sampling->conclusion_notes }}</td>
            </tr>
            @endif
            @if($sampling->recommendation)
            <tr>
                <td class="meta-label">Rekomendasi Tindak Lanjut</td>
                <td class="meta-value">: {{ $sampling->recommendation }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Manajer Teknis Laboratorium Pengujian</strong>
                <div style="height: 60px;"></div>
                <strong>( Tim Penguji Laboratorium BBPOM )</strong>
            </td>
            <td>
                Palangka Raya, {{ now()->translatedFormat('d F Y') }}<br>
                <strong>Petugas Pengambil Sampel</strong>
                <div style="height: 60px;"></div>
                <strong>( {{ $sampling->inspector?->name ?? 'Petugas BBPOM' }} )</strong>
            </td>
        </tr>
    </table>
</body>
</html>
