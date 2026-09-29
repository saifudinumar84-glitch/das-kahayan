<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Pemeriksaan — {{ $inspection->inspection_number }}</title>
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
            color: #1e3a8a;
            text-transform: uppercase;
        }
        .header-title p {
            margin: 0;
            font-size: 7.5pt;
            color: #475569;
        }
        .bap-title {
            text-align: center;
            margin: 15px 0 10px 0;
        }
        .bap-title h4 {
            margin: 0;
            font-size: 12pt;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .bap-title p {
            margin: 2px 0 0 0;
            font-size: 9pt;
            color: #334155;
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
            width: 25%;
            color: #475569;
            font-weight: 500;
        }
        .meta-value {
            width: 75%;
            font-weight: 600;
            color: #0f172a;
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
            color: #1e3a8a;
            text-transform: uppercase;
            margin-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
        }
        .table-findings {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 8.5pt;
        }
        .table-findings th {
            background-color: #1e3a8a;
            color: #ffffff;
            padding: 5px 6px;
            border: 1px solid #1e3a8a;
            text-align: left;
        }
        .table-findings td {
            padding: 5px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        .table-findings tr:nth-child(even) {
            background: #ffffff;
        }
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
        .qr-box {
            display: inline-block;
            border: 1px dashed #94a3b8;
            padding: 6px 12px;
            background: #ffffff;
            font-size: 8pt;
            color: #475569;
            margin-top: 10px;
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

    <div class="bap-title">
        <h4>BERITA ACARA PEMERIKSAAN (BAP)</h4>
        <p>Nomor: {{ $inspection->bapDocument?->document_number ?? 'BAP/'.date('Ymd', strtotime($inspection->inspection_date)).'/'.substr($inspection->id, 0, 8) }}</p>
    </div>

    <p style="text-align: justify; margin-bottom: 12px;">
        Pada hari ini <strong>{{ $inspection->inspection_date?->translatedFormat('l') ?? '...' }}</strong>, tanggal <strong>{{ $inspection->inspection_date?->translatedFormat('d F Y') ?? '...' }}</strong>, petugas Balai Besar Pengawas Obat dan Makanan di Palangka Raya telah melakukan pemeriksaan terhadap sarana:
    </p>

    <!-- DATA SARANA -->
    <div class="section-box">
        <div class="section-title">I. Identitas Sarana yang Diperiksa</div>
        <table class="meta-table">
            <tr>
                <td class="meta-label">Nama Sarana</td>
                <td class="meta-value">: {{ $inspection->facility?->name }}</td>
            </tr>
            <tr>
                <td class="meta-label">Jenis Sarana</td>
                <td class="meta-value">: {{ $inspection->facility?->facility_type === 'production' ? 'Sarana Produksi Pangan Olahan' : 'Sarana Distribusi / Ritel Pangan' }}</td>
            </tr>
            <tr>
                <td class="meta-label">Jenis Komoditas</td>
                <td class="meta-value">: {{ $inspection->facility?->commodity_type }}</td>
            </tr>
            <tr>
                <td class="meta-label">Alamat Lengkap</td>
                <td class="meta-value">: {{ $inspection->facility?->address }}, {{ $inspection->facility?->regency }}</td>
            </tr>
            <tr>
                <td class="meta-label">Penanggung Jawab</td>
                <td class="meta-value">: {{ $inspection->facility?->pic_name }} (Telp: {{ $inspection->facility?->phone }})</td>
            </tr>
            <tr>
                <td class="meta-label">Nomor Induk Berusaha (NIB)</td>
                <td class="meta-value">: {{ $inspection->facility?->nib ? 'Terdaftar (*** Terenkripsi ***)' : '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- HASIL PEMERIKSAAN -->
    <div class="section-box">
        <div class="section-title">II. Ringkasan Hasil Pemeriksaan</div>
        <table class="meta-table">
            <tr>
                <td class="meta-label">Grade / Nilai Sarana</td>
                <td class="meta-value">: <span style="font-size: 11pt; color: #1e3a8a;"><strong>{{ $inspection->grade ?? '-' }}</strong></span></td>
            </tr>
            <tr>
                <td class="meta-label">Kesimpulan Pemeriksaan</td>
                <td class="meta-value">: <strong>{{ $inspection->conclusion ?? 'Memenuhi Ketentuan' }}</strong></td>
            </tr>
            <tr>
                <td class="meta-label">Jumlah Ketidaksesuaian</td>
                <td class="meta-value">: {{ $inspection->findings->count() }} Temuan</td>
            </tr>
            <tr>
                <td class="meta-label">Status Tindak Lanjut</td>
                <td class="meta-value">: {{ $inspection->status?->getLabel() }}</td>
            </tr>
        </table>
    </div>

    <!-- RINCIAN TEMUAN -->
    <div class="section-title">III. Rincian Temuan Ketidaksesuaian & Rekomendasi Tindakan Koreksi (CAPA)</div>
    @if($inspection->findings->count() > 0)
        <table class="table-findings">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Klausul Standar</th>
                    <th style="width: 40%;">Uraian Ketidaksesuaian</th>
                    <th style="width: 25%;">Rekomendasi Perbaikan</th>
                    <th style="width: 10%;">Batas Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inspection->findings as $idx => $finding)
                    <tr>
                        <td style="text-align: center;">{{ $idx + 1 }}</td>
                        <td>
                            <strong>{{ $finding->standard?->value }}</strong><br>
                            <small>{{ $finding->requirement?->code }} - {{ $finding->requirement?->clause_title }}</small>
                        </td>
                        <td>{{ $finding->description }}</td>
                        <td>{{ $finding->recommendation ?? '-' }}</td>
                        <td>{{ $finding->due_date?->format('d/m/Y') ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="font-style: italic; color: #166534; background: #dcfce7; padding: 8px; border-radius: 4px;">
            &check; Tidak ditemukan ketidaksesuaian kritis, mayor, maupun minor pada saat pemeriksaan sarana berlangsung.
        </p>
    @endif

    <div style="margin-top: 15px; font-size: 8pt; color: #475569;">
        Dokumen ini diterbitkan secara sah dan tervalidasi secara digital melalui Sistem Informasi Si Kahayan.<br>
        Token Validasi: <code>{{ $inspection->bapDocument?->qr_token ?? $inspection->id }}</code>
    </div>

    <!-- TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td>
                Mengetahui & Menyetujui,<br>
                <strong>Penanggung Jawab Sarana</strong>
                <div style="height: 60px;"></div>
                <strong>( {{ $inspection->facility?->pic_name ?? '....................................' }} )</strong>
            </td>
            <td>
                Palangka Raya, {{ $inspection->inspection_date?->translatedFormat('d F Y') }}<br>
                <strong>Petugas Pemeriksa (Inspektur BBPOM)</strong>
                <div style="height: 60px;"></div>
                <strong>( {{ $inspection->inspector?->name ?? 'Tim Pemeriksa BBPOM' }} )</strong>
            </td>
        </tr>
    </table>
</body>
</html>
