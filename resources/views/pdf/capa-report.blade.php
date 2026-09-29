<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan CAPA — BBPOM Palangka Raya</title>
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
            color: #6b21a8;
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
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 8.5pt;
        }
        .data-table th {
            background-color: #6b21a8;
            color: #ffffff;
            padding: 6px 5px;
            border: 1px solid #6b21a8;
            text-align: left;
        }
        .data-table td {
            padding: 6px 5px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) {
            background: #fdf4ff;
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
        .signature-table {
            width: 100%;
            margin-top: 30px;
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
        <h4>LAPORAN TINDAK LANJUT PERBAIKAN DAN PENCEGAHAN (CAPA)</h4>
        <p>Sarana: {{ $facilityName ?? 'Pelaku Usaha' }} &bull; Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 15%;">No. Pemeriksaan</th>
                <th style="width: 18%;">Klausul Standar</th>
                <th style="width: 25%;">Temuan Ketidaksesuaian</th>
                <th style="width: 20%;">Rencana Tindakan Koreksi</th>
                <th style="width: 10%;">Batas Waktu</th>
                <th style="width: 8%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($findings as $idx => $finding)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td style="font-weight: 600;">{{ $finding->inspection?->inspection_number }}</td>
                    <td>
                        <strong>{{ $finding->standard?->value }}</strong><br>
                        <small>{{ $finding->requirement?->code }}</small>
                    </td>
                    <td>
                        {{ $finding->description }}
                        @if($finding->recommendation)
                            <br><small style="color: #64748b;"><strong>Rekomendasi:</strong> {{ $finding->recommendation }}</small>
                        @endif
                    </td>
                    <td>
                        @php
                            $latestCapa = $finding->capaSubmissions->last();
                        @endphp
                        @if($latestCapa)
                            <strong>Koreksi:</strong> {{ Str::limit($latestCapa->corrective_action, 80) }}<br>
                            <small style="color: #15803d;">Terkirim: {{ $latestCapa->submitted_at?->format('d/m/Y') }}</small>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">Belum ada kiriman tindakan</span>
                        @endif
                    </td>
                    <td>{{ $finding->due_date?->format('d/m/Y') ?? '-' }}</td>
                    <td>
                        @if($finding->status?->value === 'closed')
                            <span class="badge badge-success">Closed</span>
                        @elseif($finding->status?->value === 'submitted')
                            <span class="badge badge-warning">Review</span>
                        @else
                            <span class="badge badge-danger">Open</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #64748b; padding: 12px;">Tidak ada temuan atau riwayat CAPA yang tercatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td>
                Penanggung Jawab Sarana,<br>
                <strong>Pelaku Usaha</strong>
                <div style="height: 60px;"></div>
                <strong>( {{ $picName ?? '....................................' }} )</strong>
            </td>
            <td>
                Mengetahui,<br>
                <strong>Ketua Tim Pengawasan Pangan BBPOM</strong>
                <div style="height: 60px;"></div>
                <strong>( Tim Verifikator CAPA BBPOM )</strong>
            </td>
        </tr>
    </table>
</body>
</html>
