<div class="flex flex-col w-full gap-space-lg pb-12">
    <!-- Section 1: Page Header & Quick Metadata Dossier -->
    <div class="flex flex-col gap-space-md">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md">
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-space-xs text-secondary font-label-sm uppercase tracking-wider text-xs">
                    <span class="material-symbols-outlined text-[16px]">verified_user</span>
                    <span>Sistem Informasi Pengawasan Obat &amp; Makanan</span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight font-bold">Daftar Temuan &amp; Tindak Lanjut CAPA</h1>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-3xl leading-relaxed">
                    Kelola, pantau batas waktu, dan sampaikan bukti <span class="font-semibold text-on-surface">Corrective and Preventive Action (CAPA)</span> hasil pengawasan BBPOM di Palangka Raya secara mandiri dan akuntabel.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center flex-wrap gap-space-xs sm:gap-space-sm">
                <a 
                    href="{{ route('publik.panduan') }}" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md text-sm transition-colors"
                >
                    <span class="material-symbols-outlined text-[20px] text-secondary">menu_book</span>
                    <span>Panduan CAPA</span>
                </a>
                <button 
                    onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface font-label-md text-sm transition-colors"
                >
                    <span class="material-symbols-outlined text-[20px] text-primary">download</span>
                    <span>Unduh Rekap</span>
                </button>
            </div>
        </div>

        <!-- Sarana Dossier Badges -->
        <div class="flex items-center flex-wrap gap-2.5 p-3 rounded-xl bg-surface-container-lowest shadow-sm border border-surface-container">
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-surface-container text-on-surface font-label-sm text-xs">
                <span class="material-symbols-outlined text-primary text-[18px]">factory</span>
                <span class="text-on-surface-variant">Sarana:</span>
                <span class="font-semibold text-on-surface">{{ $facility?->name ?? 'Sarana Usaha' }}</span>
            </div>
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-surface-container text-on-surface font-label-sm text-xs">
                <span class="material-symbols-outlined text-secondary text-[18px]">badge</span>
                <span class="text-on-surface-variant">NIB:</span>
                <span class="font-mono text-on-surface">{{ $facility?->nib ?? '-' }}</span>
            </div>
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-surface-container text-on-surface font-label-sm text-xs">
                <span class="w-2 h-2 rounded-full bg-primary-container"></span>
                <span class="text-on-surface-variant">Status Binaan:</span>
                <span class="font-semibold text-primary">Aktif (CPPOB)</span>
            </div>
        </div>
    </div>

    <!-- Section 2: Urgency Notice Banner -->
    @if($counts['need_action'] > 0)
    <div class="p-4 rounded-xl bg-error-container/40 text-on-surface shadow-sm border border-error-container flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-lg bg-error-container text-on-error-container flex items-center justify-center shrink-0 mt-0.5">
                <span class="material-symbols-outlined text-[24px]">timer_off</span>
            </div>
            <div class="flex flex-col gap-0.5">
                <span class="font-title-sm text-title-sm font-bold text-error flex items-center gap-2">
                    Peringatan Batas Waktu Regulasi (SOP-CAPA-BBPOM)
                    <span class="px-2 py-0.5 rounded-full bg-error text-on-error font-label-sm text-[10px]">Perhatian</span>
                </span>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                    Batas waktu penyelesaian CAPA maksimal <span class="font-semibold text-on-surface">30 hari kalender</span> sejak tanggal Berita Acara Pemeriksaan (BAP) diterbitkan. Temuan yang melewati tenggat waktu berisiko penangguhan rekomendasi perpanjangan izin edar.
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Section 3: Filter Tabs & Search Bar -->
    <div class="flex flex-col gap-space-md">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-md">
            <!-- Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto p-1 bg-surface-container rounded-xl">
                <button 
                    type="button"
                    wire:click="switchTab('all')" 
                    class="px-3.5 py-1.5 rounded-lg font-label-md text-xs transition-all whitespace-nowrap {{ $tab === 'all' ? 'bg-surface-container-lowest text-primary font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}"
                >
                    Semua Temuan ({{ $counts['all'] }})
                </button>
                <button 
                    type="button"
                    wire:click="switchTab('need_action')" 
                    class="px-3.5 py-1.5 rounded-lg font-label-md text-xs transition-all whitespace-nowrap flex items-center gap-1.5 {{ $tab === 'need_action' ? 'bg-surface-container-lowest text-error font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}"
                >
                    <span>Perlu Tindak Lanjut</span>
                    @if($counts['need_action'] > 0)
                        <span class="px-1.5 py-0.5 rounded-full bg-error text-on-error text-[10px] font-bold">{{ $counts['need_action'] }}</span>
                    @endif
                </button>
                <button 
                    type="button"
                    wire:click="switchTab('closed')" 
                    class="px-3.5 py-1.5 rounded-lg font-label-md text-xs transition-all whitespace-nowrap {{ $tab === 'closed' ? 'bg-surface-container-lowest text-primary font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}"
                >
                    Closed CAPA ({{ $counts['closed'] }})
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="flex items-center gap-2">
                <div class="relative flex-1 sm:w-64">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
                    <input 
                        wire:model.live.debounce.300ms="search"
                        type="text" 
                        placeholder="Cari kata kunci temuan..." 
                        class="w-full pl-9 pr-3 py-1.5 rounded-lg bg-surface-container-low font-body-sm text-on-surface placeholder:text-on-surface-variant text-xs border border-surface-container focus:outline-none focus:ring-1 focus:ring-primary"
                    />
                </div>
            </div>
        </div>
    </div>

    <!-- Section 4: Findings Cards Grid / List -->
    <div class="flex flex-col gap-space-md">
        @forelse($findings as $finding)
        @php
            $latestSub = $finding->capaSubmissions->first();
            $isClosed = $finding->status === 'closed';
            $isOverdue = $finding->due_date && $finding->due_date < now() && ! $isClosed;
        @endphp
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-container overflow-hidden transition-all hover:shadow-md">
            <!-- Colored Accent Bar -->
            <div class="h-1.5 w-full {{ $isClosed ? 'bg-primary' : ($isOverdue ? 'bg-error' : 'bg-tertiary-container') }}"></div>

            <div class="p-space-md lg:p-space-lg flex flex-col gap-space-md">
                <!-- Card Header -->
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-space-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg {{ $isClosed ? 'bg-primary-fixed text-primary' : ($isOverdue ? 'bg-error-container text-on-error-container' : 'bg-surface-container text-on-surface') }} flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]">
                                {{ $isClosed ? 'check_circle' : ($isOverdue ? 'warning' : 'assignment') }}
                            </span>
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full {{ $isClosed ? 'bg-primary-fixed text-on-primary-fixed-variant' : ($isOverdue ? 'bg-error text-on-error' : 'bg-surface-container text-on-surface') }} font-label-sm text-[11px] font-bold uppercase tracking-wide">
                                    {{ $isClosed ? 'Closed CAPA' : ($isOverdue ? 'Lewat Batas Waktu' : 'Temuan Terbuka') }}
                                </span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant text-xs">
                                    Standar {{ strtoupper($finding->standard->value ?? (string)$finding->standard) }}
                                </span>
                                <span class="text-outline-variant">•</span>
                                <span class="text-xs text-on-surface-variant">BAP: <strong>{{ $finding->inspection?->inspection_number }}</strong></span>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface mt-1 font-semibold">
                                {{ $finding->requirement?->title ?? 'Ketidaksesuaian Fasilitas / Operasional' }}
                            </h3>
                        </div>
                    </div>

                    <!-- Due date pill -->
                    <div class="flex sm:flex-col items-end gap-1">
                        <span class="text-xs text-on-surface-variant">Tenggat Waktu:</span>
                        <span class="font-label-md text-label-md {{ $isOverdue ? 'text-error font-bold' : 'text-on-surface' }}">
                            {{ $finding->due_date?->translatedFormat('d F Y') ?? '—' }}
                        </span>
                    </div>
                </div>

                <!-- Description & Recommendation -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                    <!-- Left: Uraian Temuan -->
                    <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col gap-1 border border-surface-container">
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-semibold flex items-center gap-1 text-xs">
                            <span class="material-symbols-outlined text-[16px] text-primary">fact_check</span>
                            Uraian Ketidaksesuaian oleh Petugas
                        </span>
                        <p class="font-body-sm text-body-sm text-on-surface leading-relaxed mt-1">
                            {{ $finding->description }}
                        </p>
                    </div>

                    <!-- Right: Rekomendasi -->
                    <div class="bg-primary/5 p-space-md rounded-lg flex flex-col gap-1 border border-primary/10">
                        <span class="font-label-sm text-label-sm text-primary uppercase font-bold flex items-center gap-1 text-xs">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            Rekomendasi Tindakan Koreksi
                        </span>
                        <p class="font-body-sm text-body-sm text-on-surface leading-relaxed mt-1">
                            {{ $finding->recommendation }}
                        </p>
                    </div>
                </div>

                <!-- Status Submission & Footer Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-md pt-space-xs border-t border-surface-container">
                    <div class="flex items-center gap-2">
                        @if($latestSub)
                            <span class="text-xs text-on-surface-variant">
                                Pengajuan Terakhir (Ronde {{ $latestSub->round }}):
                                <strong class="text-on-surface">{{ $latestSub->submitted_at?->translatedFormat('d M Y') }}</strong>
                            </span>
                            @if($latestSub->status === 'accepted')
                                <span class="px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed-variant text-[11px] font-semibold">Diterima Petugas</span>
                            @elseif($latestSub->status === 'revision')
                                <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container text-[11px] font-semibold">Perlu Revisi</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-surface-container text-on-surface text-[11px]">Sedang Ditinjau</span>
                            @endif
                        @else
                            <span class="text-xs text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-outline">pending</span>
                                Belum ada formulir CAPA yang diserahkan untuk temuan ini.
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 self-end sm:self-auto">
                        <a 
                            href="{{ route('portal.submit-capa', ['findingId' => $finding->id]) }}" 
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg {{ $isClosed ? 'bg-surface-container hover:bg-surface-container-high text-on-surface' : 'bg-primary hover:bg-primary-container text-on-primary shadow-sm' }} font-label-md text-xs font-semibold transition-all"
                        >
                            <span class="material-symbols-outlined text-[18px]">
                                {{ $isClosed ? 'visibility' : 'edit_document' }}
                            </span>
                            <span>{{ $isClosed ? 'Lihat Detail & Bukti' : ($latestSub ? 'Perbarui Laporan CAPA' : 'Tindak Lanjuti & Kirim CAPA') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-surface-container-lowest rounded-xl p-space-xl text-center text-on-surface-variant border border-surface-container">
            <span class="material-symbols-outlined text-4xl text-outline mb-2">assignment_turned_in</span>
            <h3 class="font-headline-md text-headline-md text-on-surface font-semibold">Tidak Ada Temuan Sesuai Filter</h3>
            <p class="text-sm mt-1">Coba sesuaikan kata kunci pencarian atau tab status temuan.</p>
        </div>
        @endforelse

        <div class="pt-space-md">
            {{ $findings->links() }}
        </div>
    </div>
</div>
