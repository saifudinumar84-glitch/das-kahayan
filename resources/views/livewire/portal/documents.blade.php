<div class="flex flex-col w-full gap-space-lg pb-12">
    <!-- Top Banner / Identity & Context Header -->
    <div class="relative overflow-hidden rounded-xl bg-surface-container-lowest p-space-lg shadow-sm border border-surface-container">
        <!-- Subtle Kahayan River Wave Motif Accent -->
        <div class="pointer-events-none absolute -right-16 -top-24 h-64 w-64 rounded-full bg-gradient-to-br from-primary/10 via-secondary/5 to-transparent blur-2xl"></div>
        <div class="pointer-events-none absolute right-48 -bottom-20 h-48 w-48 rounded-full bg-gradient-to-tr from-secondary-fixed/30 to-transparent blur-xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md">
            <div class="flex flex-col gap-2 max-w-3xl">
                <!-- Breadcrumb & Status Ribbon -->
                <div class="flex flex-wrap items-center gap-space-xs text-on-surface-variant font-label-sm text-xs">
                    <span class="flex items-center gap-1 text-primary">
                        <span class="material-symbols-outlined text-[16px]">folder_special</span>
                        <span>Portal Si Kahayan</span>
                    </span>
                    <span class="text-outline-variant">/</span>
                    <span class="text-on-surface-variant">Arsip Digital &amp; Dokumen Hukum</span>
                    <span class="text-outline-variant">/</span>
                    <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-semibold text-[11px] flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                        TTE BSrE BSSN Compliant
                    </span>
                </div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight font-bold">Repositori Dokumen Pengawasan &amp; Sertifikat</h1>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    Arsip resmi Berita Acara Pemeriksaan (BAP), Surat Rekomendasi Tindak Lanjut, dan Surat Pengesahan Closed CAPA dengan legalitas Tanda Tangan Elektronik (TTE) tersertifikasi Balai Sertifikasi Elektronik (BSrE) BSSN.
                </p>

                <!-- Business Context Info Chip Strip -->
                <div class="flex flex-wrap items-center gap-2 pt-1">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-surface-container-low text-on-surface text-xs font-semibold">
                        <span class="material-symbols-outlined text-primary text-[18px]">storefront</span>
                        <span>{{ $facility?->name ?? 'UD. Berkah Mandiri Patin' }}</span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-surface-container-low text-on-surface-variant text-xs">
                        <span class="material-symbols-outlined text-[16px]">badge</span>
                        <span>NIB: <span class="font-semibold text-on-surface">{{ $facility?->nib ?? '-' }}</span></span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-surface-container-low text-primary text-xs font-semibold">
                        <span class="material-symbols-outlined text-[16px]">verified_user</span>
                        <span>Izin CPPOB: <strong class="text-primary">{{ $facility?->cppob_certificate_number ?? 'Aktif' }}</strong></span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap lg:flex-col xl:flex-row items-center gap-space-sm self-start lg:self-center">
                <a 
                    href="{{ route('publik.validasi-bap') }}" 
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-secondary font-label-md text-xs font-semibold transition-all shadow-sm"
                >
                    <span class="material-symbols-outlined text-[20px]">qr_code_scanner</span>
                    <span>Cek Integritas TTE</span>
                </a>
                <button 
                    onclick="window.print()" 
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-md text-xs font-semibold transition-all shadow-sm"
                >
                    <span class="material-symbols-outlined text-[20px]">download</span>
                    <span>Cetak Arsip</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Key Metrics / Summary Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-md">
        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm border border-surface-container flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant text-xs">Total Dokumen Sah</span>
                <span class="font-headline-lg text-headline-lg text-primary font-bold">{{ $totalDocsCount }} Berkas</span>
                <span class="text-[11px] text-on-surface-variant flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-[14px] text-primary">check_circle</span>
                    Semua berstatus tersertifikasi
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary-fixed text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">task_alt</span>
            </div>
        </div>

        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm border border-surface-container flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant text-xs">Surat Closed CAPA</span>
                <span class="font-headline-lg text-headline-lg text-secondary font-bold">{{ $closureDocs->count() }} Surat</span>
                <span class="text-[11px] text-on-surface-variant flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-[14px] text-secondary">workspace_premium</span>
                    Audit Memenuhi Syarat
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-secondary-container text-secondary flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">verified</span>
            </div>
        </div>

        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm border border-surface-container flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-sm text-label-sm text-on-surface-variant text-xs">Berita Acara Pemeriksaan</span>
                <span class="font-headline-lg text-headline-lg text-on-surface font-bold">{{ $bapDocs->count() }} BAP</span>
                <span class="text-[11px] text-on-surface-variant flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-[14px]">fact_check</span>
                    Pemeriksaan Lapangan
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-on-surface">
                <span class="material-symbols-outlined text-[24px]">description</span>
            </div>
        </div>
    </div>

    <!-- Filter Segmented Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto p-1 bg-surface-container rounded-xl w-fit">
        <button 
            type="button"
            wire:click="filterType('all')" 
            class="px-3.5 py-1.5 rounded-lg font-label-md text-xs transition-all whitespace-nowrap {{ $type === 'all' ? 'bg-surface-container-lowest text-primary font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}"
        >
            Semua Dokumen ({{ $totalDocsCount }})
        </button>
        <button 
            type="button"
            wire:click="filterType('bap')" 
            class="px-3.5 py-1.5 rounded-lg font-label-md text-xs transition-all whitespace-nowrap {{ $type === 'bap' ? 'bg-surface-container-lowest text-primary font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}"
        >
            Berita Acara Pemeriksaan ({{ $bapDocs->count() }})
        </button>
        <button 
            type="button"
            wire:click="filterType('capa_closure')" 
            class="px-3.5 py-1.5 rounded-lg font-label-md text-xs transition-all whitespace-nowrap {{ $type === 'capa_closure' ? 'bg-surface-container-lowest text-primary font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}"
        >
            Surat Closed CAPA ({{ $closureDocs->count() }})
        </button>
        <button 
            type="button"
            wire:click="filterType('follow_up')" 
            class="px-3.5 py-1.5 rounded-lg font-label-md text-xs transition-all whitespace-nowrap {{ $type === 'follow_up' ? 'bg-surface-container-lowest text-primary font-bold shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}"
        >
            Surat Rekomendasi ({{ $followUpDocs->count() }})
        </button>
    </div>

    <!-- Documents List / Table -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-container overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                <thead>
                    <tr class="bg-surface-container text-on-surface font-label-md text-label-md">
                        <th class="py-space-sm px-space-md">Nama Dokumen &amp; Nomor</th>
                        <th class="py-space-sm px-space-md">Jenis &amp; Siklus</th>
                        <th class="py-space-sm px-space-md">Tanggal Diterbitkan</th>
                        <th class="py-space-sm px-space-md">Legalitas TTE</th>
                        <th class="py-space-sm px-space-md text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    <!-- BAP Documents -->
                    @if(in_array($type, ['all', 'bap']))
                        @foreach($bapDocs as $bap)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-space-md px-space-md">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-surface-container text-on-surface flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">description</span>
                                    </div>
                                    <div>
                                        <strong class="font-label-md text-on-surface block text-sm">Berita Acara Pemeriksaan (BAP)</strong>
                                        <span class="text-xs text-on-surface-variant font-mono">{{ $bap->document_number }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-space-md px-space-md">
                                <span class="px-2 py-0.5 rounded bg-surface-container text-on-surface text-xs font-medium">BAP Lapangan</span>
                                <span class="text-xs text-on-surface-variant block mt-0.5">{{ $bap->inspection?->inspection_number }}</span>
                            </td>
                            <td class="py-space-md px-space-md text-xs text-on-surface-variant">
                                {{ $bap->generated_at?->translatedFormat('d F Y') ?? '—' }}
                            </td>
                            <td class="py-space-md px-space-md">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                                    BSrE BSSN Valid
                                </span>
                            </td>
                            <td class="py-space-md px-space-md text-right whitespace-nowrap">
                                <a 
                                    href="{{ route('publik.validasi-bap', ['token' => $bap->qr_token]) }}" 
                                    target="_blank"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-xs text-secondary font-semibold transition-colors mr-1"
                                    title="Validasi QR Token"
                                >
                                    <span class="material-symbols-outlined text-[16px]">qr_code_scanner</span>
                                    <span>Cek Validitas</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @endif

                    <!-- Closed CAPA Documents -->
                    @if(in_array($type, ['all', 'capa_closure']))
                        @foreach($closureDocs as $closure)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-space-md px-space-md">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-primary-fixed text-primary flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">verified</span>
                                    </div>
                                    <div>
                                        <strong class="font-label-md text-on-surface block text-sm">Surat Keterangan Closed CAPA</strong>
                                        <span class="text-xs text-on-surface-variant font-mono">{{ $closure->letter_number }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-space-md px-space-md">
                                <span class="px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed-variant text-xs font-semibold">Pengesahan Resmi</span>
                                <span class="text-xs text-on-surface-variant block mt-0.5">{{ $closure->inspection?->inspection_number }}</span>
                            </td>
                            <td class="py-space-md px-space-md text-xs text-on-surface-variant">
                                {{ $closure->approved_at?->translatedFormat('d F Y') ?? '—' }}
                            </td>
                            <td class="py-space-md px-space-md">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                                    Disahkan Kepala BBPOM
                                </span>
                            </td>
                            <td class="py-space-md px-space-md text-right whitespace-nowrap">
                                <button 
                                    onclick="window.print()" 
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-primary hover:bg-primary-container text-on-primary text-xs font-semibold transition-colors"
                                >
                                    <span class="material-symbols-outlined text-[16px]">download</span>
                                    <span>Unduh Surat</span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif

                    <!-- Follow Up Letters -->
                    @if(in_array($type, ['all', 'follow_up']))
                        @foreach($followUpDocs as $letter)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-space-md px-space-md">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-surface-container text-secondary flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">mail</span>
                                    </div>
                                    <div>
                                        <strong class="font-label-md text-on-surface block text-sm">Surat Rekomendasi Tindak Lanjut</strong>
                                        <span class="text-xs text-on-surface-variant font-mono">BBPOM-TL-{{ $loop->iteration }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-space-md px-space-md">
                                <span class="px-2 py-0.5 rounded bg-surface-container text-on-surface text-xs font-medium">Instruksi Perbaikan</span>
                            </td>
                            <td class="py-space-md px-space-md text-xs text-on-surface-variant">
                                {{ $letter->sent_at?->translatedFormat('d F Y') ?? '—' }}
                            </td>
                            <td class="py-space-md px-space-md">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container text-on-surface text-xs">
                                    Terkirim ke Email
                                </span>
                            </td>
                            <td class="py-space-md px-space-md text-right whitespace-nowrap">
                                <button 
                                    onclick="window.print()" 
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface text-xs font-semibold transition-colors"
                                >
                                    <span class="material-symbols-outlined text-[16px]">download</span>
                                    <span>Salinan</span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
