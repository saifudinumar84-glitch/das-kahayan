<div class="flex flex-col w-full gap-space-lg">
    <!-- Greeting & Profile Summary Banner -->
    <section class="relative overflow-hidden rounded-xl bg-surface-container-lowest p-space-lg shadow-sm border border-surface-container">
        <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-primary-fixed/20 blur-3xl"></div>
        <div class="pointer-events-none absolute right-1/4 -bottom-16 h-64 w-64 rounded-full bg-secondary-container/20 blur-2xl"></div>

        <!-- Water Ripple Decorative Motifs (Sungai Kahayan) -->
        <div class="pointer-events-none absolute inset-0 opacity-[0.035]">
            <svg class="h-full w-full" preserveAspectRatio="none" viewBox="0 0 1200 400" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,160 C320,280 420,40 760,180 C1020,290 1120,120 1200,160 L1200,400 L0,400 Z" fill="#0f6b4f"></path>
                <path d="M0,230 C280,120 540,320 840,190 C1080,90 1140,240 1200,210 L1200,400 L0,400 Z" fill="#006a6a"></path>
            </svg>
        </div>

        <div class="relative z-10 flex flex-col justify-between gap-space-lg lg:flex-row lg:items-center">
            <div class="flex flex-col gap-space-xs max-w-3xl">
                <div class="inline-flex items-center gap-2 self-start rounded-full bg-surface-container-low px-3 py-1 text-on-surface-variant">
                    <span class="inline-block h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold">Sistem Pengawasan Terintegrasi BBPOM Palangka Raya</span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                    Selamat Datang, <span class="text-primary font-bold">{{ $facility?->name ?? 'Pelaku Usaha Binaan' }}</span>
                </h1>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    Portal Layanan Mandiri Tindak Lanjut Hasil Pengawasan Obat &amp; Makanan Wilayah Kalimantan Tengah. Akses dan evaluasi pelaporan Corrective and Preventive Action (CAPA) terintegrasi.
                </p>

                <!-- Facility Badge Chip -->
                <div class="mt-space-xs flex flex-wrap items-center gap-2 text-on-surface-variant font-label-sm text-label-sm">
                    <div class="inline-flex items-center gap-1.5 rounded-lg bg-surface-container-low px-3 py-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[18px] text-primary">fingerprint</span>
                        <span>NIB: <strong class="text-on-surface font-semibold">{{ $facility?->nib ?? '9120004819284' }}</strong></span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 rounded-lg bg-surface-container-low px-3 py-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[18px] text-primary">verified_user</span>
                        <span>Izin CPPOB: <strong class="text-on-surface font-semibold">{{ $facility?->cppob_certificate_number ?? 'IP-CPPOB/PLK/2026/001' }}</strong></span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 rounded-full bg-primary-fixed px-3 py-1 text-on-primary-fixed-variant font-semibold">
                        <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                        <span>Sarana Terdaftar Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Header Action Buttons -->
            <div class="flex flex-wrap items-center gap-space-sm sm:flex-nowrap">
                <a 
                    href="{{ route('portal.temuan-capa') }}" 
                    class="group inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-space-md py-3 font-label-md text-label-md text-on-primary shadow-sm hover:bg-on-primary-fixed-variant transition-all hover:shadow"
                >
                    <span class="material-symbols-outlined text-[20px] transition-transform group-hover:rotate-45">add</span>
                    <span>Kirim CAPA Baru</span>
                </a>
                <button 
                    onclick="window.print()" 
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-surface-container px-space-md py-3 font-label-md text-label-md text-on-surface shadow-sm hover:bg-surface-container-high transition-all" 
                    type="button"
                >
                    <span class="material-symbols-outlined text-[20px] text-primary">download</span>
                    <span>Cetak Ringkasan</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Alert Banner: High Priority Overdue/Approaching Deadline -->
    @if($overdueCount > 0 || $openFindingsCount > 0)
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-space-md rounded-xl bg-error-container/60 p-space-md text-on-error-container shadow-sm border border-error-container">
        <div class="flex items-start gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-error text-on-error shadow-sm">
                <span class="material-symbols-outlined text-[22px]">notification_important</span>
            </div>
            <div class="flex flex-col">
                <div class="flex items-center gap-2">
                    <span class="font-title-sm text-title-sm font-bold text-error">Tindakan Diperlukan</span>
                    <span class="rounded-full bg-error px-2 py-0.5 font-label-sm text-[11px] text-on-error font-bold tracking-wide uppercase">Batas Waktu Regulasi</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface leading-snug mt-0.5">
                    <strong>Perhatian:</strong> Terdapat {{ $openFindingsCount }} temuan inspeksi aktif (@if($overdueCount > 0) <span class="text-error font-bold">{{ $overdueCount }} temuan melewati tenggat</span> @else mendekati batas waktu @endif). Sampaikan formulir CAPA dan bukti eviden perbaikan sebelum batas waktu maksimal 30 hari kalender.
                </p>
            </div>
        </div>
        <div class="flex shrink-0 items-center gap-3 w-full md:w-auto justify-end">
            <a class="inline-flex items-center gap-1.5 rounded-lg bg-error px-4 py-2 font-label-md text-label-md text-on-error shadow-sm hover:opacity-95 transition-opacity" href="{{ route('portal.temuan-capa') }}">
                <span>Tindak Lanjuti Sekarang</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>
    </div>
    @endif

    <!-- Key Metrics / 4 Stat Cards Grid -->
    <section class="grid grid-cols-1 gap-space-md sm:grid-cols-2 xl:grid-cols-4">
        <!-- Stat 1: Temuan Terbuka -->
        <div class="flex flex-col justify-between rounded-xl bg-surface-container-lowest p-space-md shadow-sm border border-surface-container hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Temuan Terbuka</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-container-high text-on-surface">
                    <span class="material-symbols-outlined text-[20px]">folder_open</span>
                </div>
            </div>
            <div class="mt-space-sm flex items-baseline gap-2">
                <span class="font-headline-xl text-headline-xl text-on-surface font-extrabold tracking-tight">{{ $openFindingsCount }}</span>
                <span class="font-label-sm text-label-sm {{ $openFindingsCount > 0 ? 'text-error' : 'text-primary' }} font-medium flex items-center gap-0.5">
                    <span class="inline-block h-2 w-2 rounded-full {{ $openFindingsCount > 0 ? 'bg-error animate-pulse' : 'bg-primary' }}"></span>
                    {{ $openFindingsCount > 0 ? 'Perlu CAPA' : 'Nihil' }}
                </span>
            </div>
            <div class="mt-space-xs flex items-center justify-between pt-2 bg-surface-container-low/60 px-2.5 py-1.5 rounded-lg text-xs">
                <span class="text-on-surface-variant">Terlambat:</span>
                <span class="font-bold {{ $overdueCount > 0 ? 'text-error' : 'text-on-surface' }}">{{ $overdueCount }} berkas</span>
            </div>
        </div>

        <!-- Stat 2: Menunggu Review -->
        <div class="flex flex-col justify-between rounded-xl bg-surface-container-lowest p-space-md shadow-sm border border-surface-container hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Dalam Evaluasi Balai</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-tertiary-container/20 text-tertiary">
                    <span class="material-symbols-outlined text-[20px]">pending_actions</span>
                </div>
            </div>
            <div class="mt-space-sm flex items-baseline gap-2">
                <span class="font-headline-xl text-headline-xl text-on-surface font-extrabold tracking-tight">
                    {{ $recentFindings->filter(fn($f) => $f->capaSubmissions->first()?->status === 'submitted')->count() }}
                </span>
                <span class="font-label-sm text-label-sm text-tertiary font-medium">Pengajuan</span>
            </div>
            <div class="mt-space-xs flex items-center justify-between pt-2 bg-surface-container-low/60 px-2.5 py-1.5 rounded-lg text-xs">
                <span class="text-on-surface-variant">SLA Review:</span>
                <span class="font-bold text-on-surface">5 Hari Kerja</span>
            </div>
        </div>

        <!-- Stat 3: Closed CAPA -->
        <div class="flex flex-col justify-between rounded-xl bg-surface-container-lowest p-space-md shadow-sm border border-surface-container hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">CAPA Selesai (Closed)</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-fixed text-primary">
                    <span class="material-symbols-outlined text-[20px]">task_alt</span>
                </div>
            </div>
            <div class="mt-space-sm flex items-baseline gap-2">
                <span class="font-headline-xl text-headline-xl text-on-surface font-extrabold tracking-tight">{{ $closedFindingsCount }}</span>
                <span class="font-label-sm text-label-sm text-primary font-medium flex items-center gap-0.5">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span> Disetujui
                </span>
            </div>
            <div class="mt-space-xs flex items-center justify-between pt-2 bg-surface-container-low/60 px-2.5 py-1.5 rounded-lg text-xs">
                <span class="text-on-surface-variant">Surat Pengesahan:</span>
                <a href="{{ route('portal.dokumen') }}" class="font-bold text-primary hover:underline">Tersedia</a>
            </div>
        </div>

        <!-- Stat 4: Masa Berlaku CPPOB -->
        <div class="flex flex-col justify-between rounded-xl bg-surface-container-lowest p-space-md shadow-sm border border-surface-container hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Masa Berlaku CPPOB</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-secondary-container text-secondary">
                    <span class="material-symbols-outlined text-[20px]">verified</span>
                </div>
            </div>
            <div class="mt-space-sm flex items-baseline gap-2">
                <span class="font-headline-xl text-headline-xl text-on-surface font-extrabold tracking-tight">
                    {{ $facility?->cppob_certificate_valid_until?->diffInMonths(now()) ?? '18' }}
                </span>
                <span class="font-label-sm text-label-sm text-secondary font-medium">Bulan Tersisa</span>
            </div>
            <div class="mt-space-xs flex items-center justify-between pt-2 bg-surface-container-low/60 px-2.5 py-1.5 rounded-lg text-xs">
                <span class="text-on-surface-variant">Kedaluwarsa:</span>
                <span class="font-bold text-on-surface">{{ $facility?->cppob_certificate_valid_until?->translatedFormat('M Y') ?? 'Jun 2027' }}</span>
            </div>
        </div>
    </section>

    <!-- Priority Findings Table Section -->
    <section class="flex flex-col gap-space-md bg-surface-container-lowest rounded-xl shadow-sm p-space-md lg:p-space-lg border border-surface-container">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[22px]">assignment_late</span>
                    Daftar Temuan Pengawasan yang Memerlukan Tindak Lanjut
                </h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                    Prioritaskan penyelesaian temuan ketidaksesuaian sebelum batas waktu berakhir.
                </p>
            </div>
            <a 
                href="{{ route('portal.temuan-capa') }}" 
                class="inline-flex items-center gap-1 font-label-md text-label-md text-primary hover:text-on-primary-fixed-variant self-start sm:self-auto"
            >
                <span>Lihat Seluruh Temuan</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-surface-container">
            <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                <thead>
                    <tr class="bg-surface-container text-on-surface font-label-md text-label-md">
                        <th class="py-space-sm px-space-md">No. BAP &amp; Klausul</th>
                        <th class="py-space-sm px-space-md">Deskripsi Ketidaksesuaian</th>
                        <th class="py-space-sm px-space-md">Tenggat Waktu</th>
                        <th class="py-space-sm px-space-md text-center">Status CAPA</th>
                        <th class="py-space-sm px-space-md text-right">Aksi Tindak Lanjut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    @forelse($recentFindings as $finding)
                    @php
                        $latestSub = $finding->capaSubmissions->first();
                        $isOverdue = $finding->due_date && $finding->due_date < now() && $finding->status !== 'closed';
                    @endphp
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="py-space-md px-space-md">
                            <span class="font-label-md text-label-md text-on-surface block font-bold">
                                {{ $finding->inspection?->inspection_number ?? 'BAP-2026' }}
                            </span>
                            <span class="text-xs text-on-surface-variant uppercase font-semibold">
                                Standar: {{ strtoupper($finding->standard->value ?? (string)$finding->standard) }}
                            </span>
                        </td>
                        <td class="py-space-md px-space-md max-w-md">
                            <p class="font-medium text-on-surface line-clamp-2">{{ $finding->description }}</p>
                            <span class="text-xs text-on-surface-variant mt-0.5 block truncate">
                                <strong>Rekomendasi:</strong> {{ $finding->recommendation }}
                            </span>
                        </td>
                        <td class="py-space-md px-space-md whitespace-nowrap">
                            <span class="font-label-sm text-label-sm block {{ $isOverdue ? 'text-error font-bold' : 'text-on-surface' }}">
                                {{ $finding->due_date?->translatedFormat('d M Y') ?? '—' }}
                            </span>
                            @if($finding->status !== 'closed' && $finding->due_date)
                                <span class="text-[11px] {{ $isOverdue ? 'text-error font-semibold' : 'text-on-surface-variant' }}">
                                    {{ $isOverdue ? 'Terlambat '.$finding->due_date->diffInDays(now()).' hari' : $finding->due_date->diffForHumans() }}
                                </span>
                            @endif
                        </td>
                        <td class="py-space-md px-space-md text-center">
                            @if($finding->status === 'closed')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span> Closed
                                </span>
                            @elseif($latestSub?->status === 'submitted')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-tertiary-container/30 text-tertiary font-label-sm text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span> Evaluasi Balai
                                </span>
                            @elseif($latestSub?->status === 'revision')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-error-container text-on-error-container font-label-sm text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Perlu Revisi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-outline"></span> Belum Kirim
                                </span>
                            @endif
                        </td>
                        <td class="py-space-md px-space-md text-right whitespace-nowrap">
                            @if($finding->status === 'closed')
                                <a 
                                    href="{{ route('portal.submit-capa', ['findingId' => $finding->id]) }}" 
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-xs font-semibold transition-colors"
                                >
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    <span>Lihat Arsip</span>
                                </a>
                            @else
                                <a 
                                    href="{{ route('portal.submit-capa', ['findingId' => $finding->id]) }}" 
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-sm text-xs font-semibold transition-colors shadow-sm"
                                >
                                    <span class="material-symbols-outlined text-[16px]">send</span>
                                    <span>{{ $latestSub ? 'Perbarui CAPA' : 'Kirim CAPA' }}</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-space-lg px-space-md text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-3xl text-outline mb-1">task_alt</span>
                            <p>Tidak ada temuan pemeriksaan aktif. Sarana dalam status kepatuhan baik.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- Bottom Split: Inspection History & Guidelines -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">
        <!-- Inspection History -->
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl shadow-sm p-space-md lg:p-space-lg border border-surface-container">
            <div class="flex items-center justify-between mb-space-md">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-[22px]">history</span>
                    Riwayat Siklus Pengawasan Lapangan
                </h3>
                <a href="{{ route('portal.dokumen') }}" class="font-label-sm text-label-sm text-secondary hover:underline">Lihat Semua BAP</a>
            </div>

            <div class="space-y-3">
                @forelse($recentInspections as $insp)
                <div class="p-3 rounded-lg bg-surface-container-low flex items-center justify-between gap-3 border border-surface-container">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center text-primary shadow-sm font-bold">
                            {{ $insp->grade ?? 'B' }}
                        </div>
                        <div>
                            <span class="font-label-md text-label-md text-on-surface font-semibold block">{{ $insp->inspection_number }}</span>
                            <span class="text-xs text-on-surface-variant">
                                Tanggal: {{ $insp->inspection_date?->translatedFormat('d M Y') ?? '—' }} • {{ $insp->findings->count() }} Temuan
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 rounded-full bg-surface-container text-on-surface font-label-sm text-xs">
                            {{ ucfirst($insp->status->value ?? (string)$insp->status) }}
                        </span>
                        <a 
                            href="{{ route('portal.dokumen') }}" 
                            class="p-1.5 rounded-lg text-primary hover:bg-surface-container transition-colors" 
                            title="Unduh BAP"
                        >
                            <span class="material-symbols-outlined text-[20px]">download</span>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-sm text-on-surface-variant text-center py-4">Belum ada riwayat inspeksi tercatat.</p>
                @endforelse
            </div>
        </div>

        <!-- CAPA Guidelines Widget -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-md lg:p-space-lg border border-surface-container flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 text-primary mb-2">
                    <span class="material-symbols-outlined text-[22px]">menu_book</span>
                    <h3 class="font-headline-md text-headline-md text-on-surface">Panduan Penyusunan CAPA</h3>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                    Pastikan eviden perbaikan mencakup analisis akar masalah (metode 5-Why), tindakan koreksi langsung, dan pencegahan berulang disertai foto sebelum vs sesudah.
                </p>
                <div class="mt-4 space-y-2 text-xs text-on-surface">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        <span>Maksimal 30 hari kalender sejak BAP</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        <span>Foto komparatif beresolusi jelas</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        <span>SOP pembaruan disahkan pimpinan</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-3 border-t border-surface-container">
                <a 
                    href="{{ route('publik.panduan') }}" 
                    class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-xs font-semibold transition-colors"
                >
                    <span class="material-symbols-outlined text-[16px]">help</span>
                    <span>Pelajari Tata Cara Lengkap</span>
                </a>
            </div>
        </div>
    </div>
</div>
