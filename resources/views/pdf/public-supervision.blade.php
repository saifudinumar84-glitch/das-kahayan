<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pengawasan Pangan Terbuka — BBPOM Palangka Raya</title>
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
            color: #0284c7;
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
            font-size: 11.5pt;
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
            background-color: #0284c7;
            color: #ffffff;
            padding: 6px 5px;
            border: 1px solid #0284c7;
            text-align: left;
        }
        .data-table td {
            padding: 6px 5px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) {
            background: #f0f9ff;
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
        <h4>INFORMASI PUBLIK HASIL PENGAWASAN PANGAN OLAHAN</h4>
        <p>Data Terpublikasi Resmi &bull; Diunduh pada: {{ now()->translatedFormat('d F Y H:i') }} WIB</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 15%;">Jenis</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 25%;">Produk / Sarana</th>
                <th style="width: 18%;">Kategori</th>
                <th style="width: 14%;">Lokasi / Kab</th>
                <th style="width: 12%;">Kesimpulan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $idx => $item)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td><small>{{ $item['type'] }}</small></td>
                    <td>{{ $item['date'] }}</td>
                    <td><strong>{{ $item['subject'] }}</strong></td>
                    <td>{{ $item['category'] }}</td>
                    <td>{{ $item['location'] }}</td>
                    <td>
                        @if(str_contains(strtolower($item['conclusion']), 'tidak') || $item['conclusion'] === 'TMS')
                            <span class="badge badge-danger">{{ $item['conclusion'] }}</span>
                        @else
                            <span class="badge badge-success">{{ $item['conclusion'] }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #64748b; padding: 12px;">Tidak ada data pengawasan yang dipublikasikan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="font-size: 7.5pt; color: #64748b; margin-top: 15px;">
        * Data ini dipublikasikan untuk transparansi publik dan kepatuhan standar keamanan pangan BBPOM Palangka Raya.
    </p>
</body>
</html>
