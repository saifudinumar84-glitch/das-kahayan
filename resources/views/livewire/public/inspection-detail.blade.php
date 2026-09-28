<div class="flex flex-col w-full">
    <!-- Top Navigation & Breadcrumbs Bar -->
    <section class="w-full bg-surface-container-lowest shadow-sm">
        <div class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin py-space-md">
            <!-- Breadcrumb and Quick Back -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm mb-space-md">
                <nav aria-label="Breadcrumb" class="flex items-center gap-space-xs text-on-surface-variant font-label-sm text-label-sm flex-wrap">
                    <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('publik.beranda') }}">
                        <span class="material-symbols-outlined text-[16px]">home</span>
                        <span>Beranda</span>
                    </a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <a class="hover:text-primary transition-colors" href="{{ route('publik.cari') }}">
                        Cari Produk &amp; Sarana
                    </a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-primary font-label-md text-label-md">Detail Hasil Pengawasan</span>
                </nav>
                <a class="inline-flex items-center gap-space-xs text-secondary hover:text-primary font-label-md text-label-md transition-colors self-start md:self-auto group" href="{{ route('publik.cari') }}">
                    <span class="material-symbols-outlined text-[18px] transition-transform group-hover:-translate-x-1">arrow_back</span>
                    <span>Kembali ke Pencarian</span>
                </a>
            </div>

            <!-- Segmented Tab Switcher + Action Buttons Header -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md pt-space-xs border-t-0">
                <!-- Interactive Segmented Switcher -->
                <div class="inline-flex p-1 bg-surface-container rounded-xl shadow-inner max-w-fit">
                    <button 
                        type="button"
                        wire:click="switchTab('lab')"
                        class="tab-button inline-flex items-center gap-space-xs px-space-md py-space-sm rounded-lg font-label-md text-label-md transition-all {{ $activeTab === 'lab' ? 'bg-surface-container-lowest text-primary shadow-sm font-bold' : 'text-on-surface-variant hover:text-on-surface' }}"
                    >
                        <span class="material-symbols-outlined text-[18px]">science</span>
                        <span>Detail Hasil Pengujian Sampel Pangan</span>
                    </button>
                    <button 
                        type="button"
                        wire:click="switchTab('sarana')"
                        class="tab-button inline-flex items-center gap-space-xs px-space-md py-space-sm rounded-lg font-label-md text-label-md transition-all {{ $activeTab === 'sarana' ? 'bg-surface-container-lowest text-primary shadow-sm font-bold' : 'text-on-surface-variant hover:text-on-surface' }}"
                    >
                        <span class="material-symbols-outlined text-[18px]">store</span>
                        <span>Pratinjau Detail Pemeriksaan Sarana</span>
                    </button>
                </div>

                <!-- Download & Share Actions -->
                <div class="flex items-center gap-space-sm">
                    <button class="inline-flex items-center gap-space-xs px-space-md py-space-sm rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md text-label-md transition-colors shadow-sm" onclick="window.print()">
                        <span class="material-symbols-outlined text-[18px] text-secondary">picture_as_pdf</span>
                        <span>Cetak / PDF</span>
                    </button>
                    <button class="inline-flex items-center gap-space-xs px-space-md py-space-sm rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-md text-label-md transition-colors shadow-sm" onclick="navigator.clipboard?.writeText(window.location.href); alert('Tautan laporan publik berhasil disalin.');">
                        <span class="material-symbols-outlined text-[18px]">share</span>
                        <span>Bagikan Laporan</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Dynamic Detail Content Slot -->
    <div class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin py-space-lg w-full flex flex-col gap-space-xl">
        @if($activeTab === 'lab')
        <!-- VIEW 1: Lab Test Results -->
        <div class="flex flex-col gap-space-lg" wire:key="lab-view">
            @if($sampling)
            <!-- Primary Highlight Dossier Card -->
            <div class="relative overflow-hidden bg-surface-container-lowest rounded-xl shadow-md p-space-md lg:p-space-lg">
                <div class="absolute -right-16 -top-20 w-80 h-80 rounded-full bg-primary/5 pointer-events-none blur-2xl"></div>
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary"></div>
                <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-space-lg relative z-10">
                    <div class="space-y-space-sm flex-1">
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <span class="inline-flex items-center gap-1 px-space-sm py-0.5 rounded-full bg-surface-container-low text-primary font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[14px]">set_meal</span>
                                {{ $sampling->foodType?->name ?? 'Produk Pangan' }}
                            </span>
                            <span class="inline-flex items-center gap-1 px-space-sm py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[14px]">tag</span>
                                No. Sampel: {{ $sampling->sample_code }}
                            </span>
                            <span class="inline-flex items-center gap-1 px-space-sm py-0.5 rounded-full bg-surface-container-low text-secondary font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[14px]">pin_drop</span>
                                {{ $sampling->sampling_location ?? 'Kalimantan Tengah' }}
                            </span>
                        </div>
                        <div class="pt-space-xs">
                            <span class="font-label-sm text-label-sm text-secondary uppercase tracking-wider block">
                                {{ $sampling->facility?->name ?? 'Sarana Pangan Binaan' }}
                            </span>
                            <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight mt-0.5">
                                {{ $sampling->sample_name }}
                            </h1>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-1 max-w-3xl leading-relaxed">
                                {{ $sampling->notes ?: 'Hasil pengujian laboratorium terstandarisasi pengawasan peredaran pangan olahan di Kalimantan Tengah oleh Balai Besar POM di Palangka Raya.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Big Status Pill Component -->
                    <div class="flex flex-col items-start lg:items-end justify-center shrink-0">
                        @if($sampling->conclusion === 'compliant')
                        <div class="flex items-center gap-space-sm px-space-md py-space-sm rounded-full bg-primary-fixed shadow-sm text-on-primary-fixed-variant">
                            <div class="w-3 h-3 rounded-full bg-primary-container animate-pulse"></div>
                            <span class="font-headline-md text-headline-md tracking-tight font-bold">MEMENUHI SYARAT (MS)</span>
                            <span class="material-symbols-outlined text-[24px]">verified</span>
                        </div>
                        @elseif($sampling->conclusion === 'non_compliant')
                        <div class="flex items-center gap-space-sm px-space-md py-space-sm rounded-full bg-error-container shadow-sm text-on-error-container">
                            <div class="w-3 h-3 rounded-full bg-error"></div>
                            <span class="font-headline-md text-headline-md tracking-tight font-bold">TIDAK MEMENUHI SYARAT (TMS)</span>
                            <span class="material-symbols-outlined text-[24px]">warning</span>
                        </div>
                        @else
                        <div class="flex items-center gap-space-sm px-space-md py-space-sm rounded-full bg-surface-container shadow-sm text-on-surface-variant">
                            <span class="font-headline-md text-headline-md tracking-tight font-bold">DALAM PENGUJIAN</span>
                            <span class="material-symbols-outlined text-[24px]">hourglass_top</span>
                        </div>
                        @endif
                        <span class="font-label-sm text-label-sm text-on-surface-variant mt-space-xs text-left lg:text-right">
                            Standar SNI &amp; Regulasi Keamanan Pangan BPOM RI
                        </span>
                    </div>
                </div>

                <!-- Sampling Metadata Grid (4 Columns) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md mt-space-lg pt-space-md bg-surface-container-low/60 rounded-xl p-space-md">
                    <div class="flex items-start gap-space-sm">
                        <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center text-primary shadow-sm shrink-0">
                            <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                        </div>
                        <div>
                            <span class="block font-label-sm text-label-sm text-on-surface-variant">Tanggal Sampling</span>
                            <span class="font-title-sm text-title-sm text-on-surface">{{ $sampling->sampling_date?->translatedFormat('d F Y') ?? '—' }}</span>
                            <span class="block font-body-sm text-body-sm text-on-surface-variant">Seksi Pengawasan</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-space-sm">
                        <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center text-primary shadow-sm shrink-0">
                            <span class="material-symbols-outlined text-[20px]">location_on</span>
                        </div>
                        <div>
                            <span class="block font-label-sm text-label-sm text-on-surface-variant">Tempat Sampling</span>
                            <span class="font-title-sm text-title-sm text-on-surface">{{ $sampling->sampling_location ?? 'Kalimantan Tengah' }}</span>
                            <span class="block font-body-sm text-body-sm text-on-surface-variant">{{ $sampling->facility?->name ?? 'Pasar Tradisional / Sarana' }}</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-space-sm">
                        <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center text-primary shadow-sm shrink-0">
                            <span class="material-symbols-outlined text-[20px]">science</span>
                        </div>
                        <div>
                            <span class="block font-label-sm text-label-sm text-on-surface-variant">Laboratorium Penguji</span>
                            <span class="font-title-sm text-title-sm text-on-surface">Lab BBPOM Palangka Raya</span>
                            <span class="block font-body-sm text-body-sm text-on-surface-variant">Akreditasi KAN ISO/IEC 17025</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-space-sm">
                        <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center text-primary shadow-sm shrink-0">
                            <span class="material-symbols-outlined text-[20px]">verified_user</span>
                        </div>
                        <div>
                            <span class="block font-label-sm text-label-sm text-on-surface-variant">Status Publikasi</span>
                            <span class="font-title-sm text-title-sm text-primary font-semibold">Resmi &amp; Terverifikasi</span>
                            <span class="block font-body-sm text-body-sm text-on-surface-variant">{{ $sampling->published_at?->translatedFormat('d M Y') ?? 'Terbuka' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lifecycle Workflow -->
            <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-md lg:p-space-lg">
                <div class="flex items-center justify-between mb-space-md">
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-primary text-[20px]">timeline</span>
                        <h2 class="font-title-sm text-title-sm text-on-surface font-semibold">Alur Pengawasan &amp; Pengujian Sampel Pangan Terverifikasi</h2>
                    </div>
                    <span class="font-label-sm text-label-sm text-primary bg-primary/10 px-2.5 py-0.5 rounded-full font-semibold">Siklus Selesai</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
                    <div class="flex flex-col bg-surface-container-low/40 p-space-sm rounded-lg border-l-2 border-primary">
                        <span class="font-label-sm text-label-sm text-primary uppercase font-bold">Langkah 1</span>
                        <h3 class="font-title-sm text-title-sm text-on-surface mt-1">Sampling Terpilih</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">{{ $sampling->sampling_date?->translatedFormat('d M Y') ?? '—' }}</p>
                    </div>
                    <div class="flex flex-col bg-surface-container-low/40 p-space-sm rounded-lg border-l-2 border-primary">
                        <span class="font-label-sm text-label-sm text-primary uppercase font-bold">Langkah 2</span>
                        <h3 class="font-title-sm text-title-sm text-on-surface mt-1">Uji Kimia &amp; Mikro</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Laboratorium Terakreditasi</p>
                    </div>
                    <div class="flex flex-col bg-surface-container-low/40 p-space-sm rounded-lg border-l-2 border-primary">
                        <span class="font-label-sm text-label-sm text-primary uppercase font-bold">Langkah 3</span>
                        <h3 class="font-title-sm text-title-sm text-on-surface mt-1">Validasi &amp; Verifikasi Mutu</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Disetujui Manajer Teknis</p>
                    </div>
                    <div class="flex flex-col bg-surface-container-low/40 p-space-sm rounded-lg border-l-2 border-secondary">
                        <span class="font-label-sm text-label-sm text-secondary uppercase font-bold">Langkah 4</span>
                        <h3 class="font-title-sm text-title-sm text-on-surface mt-1">Publikasi Terbuka</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Portal Si Kahayan</p>
                    </div>
                </div>
            </div>

            <!-- Comprehensive Lab Results Table -->
            <div class="bg-surface-container-lowest rounded-xl shadow-md overflow-hidden">
                <div class="p-space-md lg:p-space-lg flex flex-col md:flex-row md:items-center justify-between gap-space-sm bg-surface-container-lowest">
                    <div>
                        <div class="flex items-center gap-space-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                            <h2 class="font-headline-md text-headline-md text-on-surface">Hasil per Parameter Uji Laboratorium</h2>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                            Standar Keputusan Kepala BPOM RI &amp; Standar Nasional Indonesia (SNI).
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 font-label-sm text-label-sm px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            {{ $sampling->testResults->where('status', 'compliant')->count() }} Parameter Memenuhi Syarat
                        </span>
                        @if($sampling->testResults->where('status', 'non_compliant')->count() > 0)
                        <span class="inline-flex items-center gap-1 font-label-sm text-label-sm px-2.5 py-1 rounded-full bg-error-container text-on-error-container font-semibold">
                            {{ $sampling->testResults->where('status', 'non_compliant')->count() }} TMS
                        </span>
                        @endif
                    </div>
                </div>

                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                        <thead>
                            <tr class="bg-surface-container text-on-surface font-label-md text-label-md">
                                <th class="py-space-sm px-space-md">Parameter Uji</th>
                                <th class="py-space-sm px-space-md">Kategori / Metode</th>
                                <th class="py-space-sm px-space-md">Batas Maksimum Standar</th>
                                <th class="py-space-sm px-space-md">Hasil Uji Lab</th>
                                <th class="py-space-sm px-space-md text-center">Kesimpulan</th>
                            </tr>
                        </thead>
                        <tbody class="text-on-surface divide-y divide-surface-container">
                            @forelse($sampling->testResults as $result)
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="py-space-md px-space-md font-title-sm text-title-sm text-on-surface">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-secondary text-[18px]">biotech</span>
                                        <span>{{ $result->testParameter?->name ?? 'Parameter Uji' }}</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant block pl-6">
                                        {{ $result->testParameter?->category ?? 'Analisis Kimia/Mikro' }}
                                    </span>
                                </td>
                                <td class="py-space-md px-space-md text-on-surface-variant">
                                    {{ $result->testParameter?->unit ?? 'Kualitatif/Kuantitatif' }}
                                </td>
                                <td class="py-space-md px-space-md font-label-md text-label-md text-on-surface">
                                    {{ $result->testParameter?->standard_limit ?? 'Sesuai SNI/BPOM' }}
                                </td>
                                <td class="py-space-md px-space-md">
                                    <span class="font-label-md text-label-md text-primary font-bold">{{ $result->result_value ?? 'Negatif / Aman' }}</span>
                                    @if($result->notes)
                                        <span class="block font-label-sm text-label-sm text-on-surface-variant">{{ $result->notes }}</span>
                                    @endif
                                </td>
                                <td class="py-space-md px-space-md text-center">
                                    @if($result->status === 'compliant')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-label-sm font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-primary-container"></span> MS
                                        </span>
                                    @elseif($result->status === 'non_compliant')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-error-container text-on-error-container font-label-sm text-label-sm font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-error"></span> TMS
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm font-semibold">
                                            {{ ucfirst($result->status->value ?? (string)($result->status ?? 'Proses')) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="py-space-md px-space-md font-title-sm text-title-sm text-on-surface">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-secondary text-[18px]">water_drop</span>
                                        <span>Formalin &amp; Boraks (Uji Kualitatif)</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant block pl-6">Bahan Kimia Berbahaya Terlarang</span>
                                </td>
                                <td class="py-space-md px-space-md text-on-surface-variant">Spektrofotometri / Kit Uji Cepat</td>
                                <td class="py-space-md px-space-md font-label-md text-label-md text-on-surface">Negatif (0 mg/kg)</td>
                                <td class="py-space-md px-space-md">
                                    <span class="font-label-md text-label-md text-primary font-bold">Negatif (Tidak Terdeteksi)</span>
                                </td>
                                <td class="py-space-md px-space-md text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-label-sm font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-primary-container"></span> MS
                                    </span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Evaluator Note -->
                <div class="p-space-md bg-surface-container-low flex items-start gap-space-md">
                    <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px]">assignment_turned_in</span>
                    </div>
                    <div>
                        <span class="font-label-md text-label-md text-primary uppercase font-bold">Catatan Evaluasi Mutu Analis Laboratorium:</span>
                        <p class="font-body-md text-body-md text-on-surface mt-0.5 leading-relaxed">
                            Parameter uji kimia bahan berbahaya dan cemaran mikrobiologi <strong>memenuhi kriteria keamanan pangan olahan</strong> sesuai ketentuan SNI dan Peraturan BPOM. Produk dinyatakan <em>layak dan aman dikonsumsi masyarakat</em> di wilayah Kalimantan Tengah.
                        </p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-surface-container-lowest rounded-xl p-space-xl text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl text-outline mb-2">science</span>
                <p>Data pengujian laboratorium tidak ditemukan.</p>
            </div>
            @endif
        </div>
        @else
        <!-- VIEW 2: Facility Inspection Preview -->
        <div class="flex flex-col gap-space-lg" wire:key="sarana-view">
            @if($inspection)
            <div class="bg-surface-container-lowest rounded-xl shadow-md p-space-md lg:p-space-lg relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-secondary"></div>
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-space-md">
                    <div>
                        <div class="flex flex-wrap items-center gap-space-xs mb-space-xs">
                            <span class="inline-flex items-center gap-1 px-space-sm py-0.5 rounded-full bg-secondary-container/40 text-secondary font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[14px]">factory</span>
                                Sarana {{ ucfirst($inspection->facility?->facility_type->value ?? (string)($inspection->facility?->facility_type ?? 'Produksi')) }}
                            </span>
                            <span class="inline-flex items-center gap-1 px-space-sm py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[14px]">pin_drop</span>
                                {{ $inspection->facility?->regency ?? 'Kalimantan Tengah' }}
                            </span>
                            <span class="inline-flex items-center gap-1 px-space-sm py-0.5 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[14px]">tag</span>
                                No. BAP: {{ $inspection->inspection_number }}
                            </span>
                        </div>
                        <h2 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">{{ $inspection->facility?->name }}</h2>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">{{ $inspection->facility?->address }}</p>
                    </div>

                    <div class="flex items-center gap-space-sm px-space-md py-space-sm rounded-xl bg-surface-container-low shadow-sm">
                        <span class="material-symbols-outlined text-secondary text-[32px]">workspace_premium</span>
                        <div>
                            <span class="font-label-sm text-label-sm text-on-surface-variant block">Hasil Inspeksi:</span>
                            <span class="font-headline-md text-headline-md text-secondary font-bold">Grade {{ $inspection->grade ?? 'B' }}</span>
                            <span class="block font-label-sm text-label-sm text-primary font-semibold">Status: {{ ucfirst($inspection->status->value ?? (string)$inspection->status) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Inspection Meta -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md mt-space-lg pt-space-md bg-surface-container-low/40 rounded-xl p-space-md">
                    <div>
                        <span class="block font-label-sm text-label-sm text-on-surface-variant">Tanggal Pemeriksaan</span>
                        <span class="font-title-sm text-title-sm text-on-surface">{{ $inspection->inspection_date?->translatedFormat('d F Y') ?? '—' }}</span>
                        <span class="block font-body-sm text-body-sm text-on-surface-variant">Seksi Pemeriksaan BBPOM</span>
                    </div>
                    <div>
                        <span class="block font-label-sm text-label-sm text-on-surface-variant">Geotagging Lokasi</span>
                        <span class="font-title-sm text-title-sm text-on-surface font-mono text-[13px]">{{ $inspection->geo_latitude ?? '-' }}, {{ $inspection->geo_longitude ?? '-' }}</span>
                        <span class="block font-body-sm text-body-sm text-on-surface-variant">Akurasi GPS: {{ $inspection->geo_accuracy_m ?? '5' }} meter</span>
                    </div>
                    <div>
                        <span class="block font-label-sm text-label-sm text-on-surface-variant">Status Tindak Lanjut (CAPA)</span>
                        <span class="inline-flex items-center gap-1 font-title-sm text-title-sm text-primary">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                            <span>{{ $inspection->findings->where('status', 'closed')->count() }} dari {{ $inspection->findings->count() }} Temuan Closed</span>
                        </span>
                        <span class="block font-body-sm text-body-sm text-on-surface-variant">Tercatat di Portal SI KAHAYAN</span>
                    </div>
                </div>

                <!-- Findings Summary Table -->
                <div class="mt-space-lg">
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-space-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">checklist</span>
                        Ringkasan Temuan Ketidaksesuaian &amp; Rekomendasi
                    </h3>
                    <div class="overflow-x-auto rounded-lg border border-surface-container">
                        <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                            <thead>
                                <tr class="bg-surface-container text-on-surface font-label-md text-label-md">
                                    <th class="py-space-sm px-space-md">No</th>
                                    <th class="py-space-sm px-space-md">Deskripsi Temuan</th>
                                    <th class="py-space-sm px-space-md">Rekomendasi Petugas</th>
                                    <th class="py-space-sm px-space-md">Tenggat Waktu</th>
                                    <th class="py-space-sm px-space-md text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container">
                                @forelse($inspection->findings as $idx => $finding)
                                <tr class="hover:bg-surface-container-low/50 transition-colors">
                                    <td class="py-space-md px-space-md text-on-surface-variant font-bold">{{ $idx + 1 }}</td>
                                    <td class="py-space-md px-space-md max-w-sm">
                                        <div class="font-medium text-on-surface">{{ $finding->description }}</div>
                                        <span class="text-[11px] text-on-surface-variant uppercase font-semibold">Standar: {{ strtoupper($finding->standard->value ?? (string)$finding->standard) }}</span>
                                    </td>
                                    <td class="py-space-md px-space-md text-on-surface-variant max-w-sm">{{ $finding->recommendation }}</td>
                                    <td class="py-space-md px-space-md text-on-surface-variant">{{ $finding->due_date?->translatedFormat('d M Y') ?? '—' }}</td>
                                    <td class="py-space-md px-space-md text-center">
                                        @if($finding->status === 'closed')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-label-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span> Closed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-error-container text-on-error-container font-label-sm text-label-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-error"></span> {{ ucfirst($finding->status->value ?? (string)$finding->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-space-md px-space-md text-center text-on-surface-variant">
                                        Tidak ada catatan temuan ketidaksesuaian.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($inspection->conclusion)
                <div class="mt-space-md p-space-md bg-surface-container-low rounded-lg flex items-start gap-space-sm">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">info</span>
                    <div>
                        <span class="font-label-md text-label-md text-primary font-bold">Kesimpulan Pemeriksaan BBPOM:</span>
                        <p class="font-body-sm text-body-sm text-on-surface mt-0.5">{{ $inspection->conclusion }}</p>
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="bg-surface-container-lowest rounded-xl p-space-xl text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl text-outline mb-2">storefront</span>
                <p>Data pemeriksaan sarana tidak ditemukan.</p>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
