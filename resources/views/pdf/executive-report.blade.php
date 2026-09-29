<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Pengawasan Pangan — BBPOM Palangka Raya</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
            size: a4 landscape;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
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
            width: 70px;
            text-align: center;
            vertical-align: middle;
        }
        .header-title {
            text-align: center;
            vertical-align: middle;
        }
        .header-title h2 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header-title h3 {
            margin: 2px 0;
            font-size: 11pt;
            color: #1e3a8a;
            text-transform: uppercase;
        }
        .header-title p {
            margin: 0;
            font-size: 8pt;
            color: #475569;
        }
        .report-meta {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .report-meta td {
            font-size: 9pt;
            padding: 3px 6px;
        }
        .stats-grid {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .stats-box {
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            padding: 8px;
            text-align: center;
            width: 16.6%;
        }
        .stats-number {
            font-size: 14pt;
            font-weight: bold;
            color: #1e40af;
            display: block;
        }
        .stats-label {
            font-size: 7.5pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
        }
        .section-heading {
            font-size: 10.5pt;
            font-weight: bold;
            color: #0f172a;
            border-left: 4px solid #1e40af;
            padding-left: 8px;
            margin: 14px 0 6px 0;
            text-transform: uppercase;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 8.5pt;
        }
        .data-table th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: 600;
            padding: 6px 5px;
            text-align: left;
            border: 1px solid #1e3a8a;
        }
        .data-table td {
            padding: 5px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
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
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-info { background: #e0f2fe; color: #075985; }
        .signature-table {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .signature-table td {
            vertical-align: top;
            font-size: 9pt;
        }
        .footer {
            position: fixed;
            bottom: -15mm;
            left: 0;
            right: 0;
            height: 10mm;
            font-size: 7.5pt;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 4px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="footer">
        <span>Sistem Informasi Kawal Hasil Pengawasan (Si Kahayan) &bull; BBPOM di Palangka Raya</span>
        <span style="float: right;">Dicetak otomatis pada: {{ now()->translatedFormat('d F Y H:i') }} WIB</span>
    </div>

    <!-- KOP SURAT -->
    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="{{ public_path('images/logo-bpom.png') }}" alt="BPOM" style="width: 60px; height: auto;" onerror="this.style.display='none'">
            </td>
            <td class="header-title">
                <h2>BADAN PENGAWAS OBAT DAN MAKANAN</h2>
                <h3>BALAI BESAR PENGAWAS OBAT DAN MAKANAN DI PALANGKA RAYA</h3>
                <p>Jl. Tjilik Riwut Km. 2,5 Palangka Raya, Kalimantan Tengah &bull; Telp: (0536) 3221704 &bull; Email: bpom_palangkaraya@pom.go.id</p>
            </td>
        </tr>
    </table>

    <table class="report-meta">
        <tr>
            <td style="width: 15%; font-weight: bold;">Dokumen</td>
            <td style="width: 35%;">: Laporan Rekapitulasi Pengawasan Pangan</td>
            <td style="width: 15%; font-weight: bold;">Periode Data</td>
            <td style="width: 35%;">: {{ $startDate ? date('d/m/Y', strtotime($startDate)) : 'Awal' }} s/d {{ $endDate ? date('d/m/Y', strtotime($endDate)) : 'Sekarang' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Wilayah Kerja</td>
            <td>: {{ $regency ?: 'Seluruh Wilayah (Provinsi Kalimantan Tengah)' }}</td>
            <td style="font-weight: bold;">Filter Status</td>
            <td>: {{ $conclusion ?: 'Semua Status (MS & TMS)' }}</td>
        </tr>
    </table>

    <!-- RINGKASAN EKSEKUTIF -->
    <div class="section-heading">I. Ringkasan Eksekutif Indikator Pengawasan</div>
    <table class="stats-grid">
        <tr>
            <td class="stats-box">
                <span class="stats-number">{{ $stats['total_inspections'] }}</span>
                <span class="stats-label">Pemeriksaan Sarana</span>
            </td>
            <td class="stats-box">
                <span class="stats-number" style="color: #166534;">{{ $stats['inspections_ms'] }}</span>
                <span class="stats-label">Sarana MS</span>
            </td>
            <td class="stats-box">
                <span class="stats-number" style="color: #991b1b;">{{ $stats['inspections_tms'] }}</span>
                <span class="stats-label">Sarana TMS</span>
            </td>
            <td class="stats-box">
                <span class="stats-number" style="color: #0891b2;">{{ $stats['total_samplings'] }}</span>
                <span class="stats-label">Sampel Pangan Diuji</span>
            </td>
            <td class="stats-box">
                <span class="stats-number" style="color: #16a34a;">{{ $stats['samplings_ms'] }}</span>
                <span class="stats-label">Sampel MS</span>
            </td>
            <td class="stats-box">
                <span class="stats-number" style="color: #dc2626;">{{ $stats['samplings_tms'] }}</span>
                <span class="stats-label">Sampel TMS</span>
            </td>
        </tr>
    </table>

    <!-- TABEL INSPEKSI SARANA -->
    <div class="section-heading">II. Data Hasil Pemeriksaan Sarana Produksi & Distribusi</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 14%;">No. Pemeriksaan</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 20%;">Nama Sarana</th>
                <th style="width: 15%;">Kabupaten / Kota</th>
                <th style="width: 8%; text-align: center;">Grade</th>
                <th style="width: 14%;">Kesimpulan</th>
                <th style="width: 7%; text-align: center;">Temuan</th>
                <th style="width: 8%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inspections as $index => $insp)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-weight: 600;">{{ $insp->inspection_number }}</td>
                    <td>{{ $insp->inspection_date?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $insp->facility?->name ?? '-' }}</td>
                    <td>{{ $insp->facility?->regency ?? '-' }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $insp->grade ?? '-' }}</td>
                    <td>
                        @if(str_contains(strtolower($insp->conclusion ?? ''), 'tidak'))
                            <span class="badge badge-danger">TMS</span>
                        @else
                            <span class="badge badge-success">MS</span>
                        @endif
                        <span style="font-size: 7.5pt; color: #475569;">{{ Str::limit($insp->conclusion, 30) }}</span>
                    </td>
                    <td style="text-align: center;">
                        <span class="badge {{ $insp->findings->count() > 0 ? 'badge-danger' : 'badge-success' }}">
                            {{ $insp->findings->count() }}
                        </span>
                    </td>
                    <td>{{ $insp->status?->getLabel() ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: #64748b; padding: 12px;">Tidak ada data pemeriksaan sarana pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TABEL SAMPLING PANGAN -->
    <div class="section-heading">III. Data Hasil Pengambilan Sampel & Pengujian Pangan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 14%;">No. Sampling</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 22%;">Nama Produk & Merk</th>
                <th style="width: 14%;">Jenis Pangan</th>
                <th style="width: 18%;">Lokasi Sampling</th>
                <th style="width: 10%;">Kesimpulan Uji</th>
                <th style="width: 8%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($samplings as $index => $smp)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-weight: 600;">{{ $smp->sampling_number }}</td>
                    <td>{{ $smp->sampling_date?->format('d/m/Y') ?? '-' }}</td>
                    <td>
                        <strong>{{ $smp->product_name }}</strong>
                        @if($smp->brand)<br><small style="color: #64748b;">Merk: {{ $smp->brand }}</small>@endif
                    </td>
                    <td>{{ $smp->foodType?->name ?? '-' }}</td>
                    <td>{{ $smp->sampling_location ?? '-' }}</td>
                    <td>
                        @if(in_array($smp->conclusion?->value, ['compliant', 'ms'], true))
                            <span class="badge badge-success">MS</span>
                        @elseif(in_array($smp->conclusion?->value, ['non_compliant', 'tms'], true))
                            <span class="badge badge-danger">TMS</span>
                        @else
                            <span class="badge badge-warning">Proses</span>
                        @endif
                    </td>
                    <td>{{ $smp->status?->getLabel() ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #64748b; padding: 12px;">Tidak ada data sampling pangan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN RESMI -->
    <table class="signature-table">
        <tr>
            <td style="width: 60%;">
                <p style="margin: 0; font-size: 8pt; color: #64748b;">
                    Catatan:<br>
                    1. Laporan ini merupakan dokumen resmi Balai Besar POM di Palangka Raya.<br>
                    2. Data yang dimuat diintegrasikan langsung dari Sistem Informasi Kawal Hasil Pengawasan (Si Kahayan).
                </p>
            </td>
            <td style="width: 40%; text-align: center;">
                <p style="margin: 0 0 50px 0;">
                    Palangka Raya, {{ now()->translatedFormat('d F Y') }}<br>
                    <strong>Kepala Balai Besar POM di Palangka Raya</strong>
                </p>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">
                    {{ $headUser?->name ?? 'Dr. Ahmad Fauzi, Apt.' }}
                </p>
                <p style="margin: 0; font-size: 8pt; color: #475569;">
                    NIP. 19750815 200212 1 002
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
