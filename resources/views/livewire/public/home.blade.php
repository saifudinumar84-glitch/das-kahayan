<div class="flex flex-col w-full">
{{-- Hero Section --}}
<section class="relative w-full overflow-hidden bg-gradient-to-b from-surface-container-low via-surface to-surface pb-space-xl">
    <div class="absolute inset-0 pointer-events-none opacity-40">
        <svg class="absolute -top-12 -right-12 w-[800px] h-[500px] text-surface-tint/10" fill="none" viewBox="0 0 1000 600">
            <path d="M0 150C250 80 400 280 650 190C850 120 950 240 1100 180V600H0V150Z" fill="currentColor"/>
            <path d="M0 260C280 180 430 380 720 270C920 200 980 340 1150 260V600H0V260Z" fill="currentColor" fill-opacity="0.5"/>
        </svg>
    </div>
    <div class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin pt-space-lg lg:pt-space-xl relative z-10">
        <div class="flex flex-col items-center text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-space-xs px-space-md py-1 rounded-full bg-secondary-container/40 text-secondary mb-space-md shadow-sm">
                <span class="material-symbols-outlined text-[18px]">verified</span>
                <span class="font-label-sm text-label-sm tracking-wide uppercase">Transparansi & Pengawasan Pangan Kalimantan Tengah</span>
            </div>
            <h1 class="font-headline-xl lg:font-display-lg text-headline-xl lg:text-display-lg text-on-surface tracking-tight mb-space-md">
                Kawal Hasil Pengawasan Pangan Olahan, <span class="text-primary-container">Terbuka</span> dan <span class="text-secondary">Dapat Ditelusuri</span>
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-3xl leading-relaxed mb-space-xl">
                Portal keterbukaan informasi publik Balai Besar POM di Palangka Raya untuk memantau hasil uji laboratorium sampel pangan dan inspeksi sarana produksi serta distribusi di seluruh wilayah Kalimantan Tengah.
            </p>

            {{-- Search --}}
            <div class="w-full bg-surface-container-lowest rounded-xl shadow-xl p-space-sm sm:p-space-md mb-space-lg max-w-3xl">
                <form wire:submit="searchProducts" class="flex flex-col sm:flex-row items-center gap-space-sm">
                    <div class="relative flex-1 w-full flex items-center">
                        <span class="material-symbols-outlined absolute left-space-md text-outline">search</span>
                        <input wire:model="search"
                               id="search-input"
                               type="text"
                               placeholder="Cari nama produk pangan atau nama sarana usaha..."
                               class="w-full h-12 pl-12 pr-space-md rounded-lg bg-surface text-on-surface placeholder:text-outline font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-primary-container transition-all"/>
                    </div>
                    <button type="submit"
                            class="w-full sm:w-auto h-12 px-space-xl rounded-lg bg-primary-container hover:bg-primary text-on-primary font-label-md text-label-md flex items-center justify-center gap-space-xs transition-colors shadow-sm whitespace-nowrap">
                        <span>Cari Sekarang</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </form>
            </div>

            {{-- Shortcuts --}}
            <div class="flex flex-wrap items-center justify-center gap-space-md mb-space-xl">
                <a href="{{ route('publik.validasi-bap') }}"
                   class="inline-flex items-center gap-space-xs px-space-lg py-space-sm rounded-lg bg-surface-container-lowest hover:bg-surface-container-high text-secondary font-label-md text-label-md shadow-sm transition-all">
                    <span class="material-symbols-outlined text-[20px]">qr_code_scanner</span>
                    <span>Validasi BAP dengan QR</span>
                </a>
                <a href="{{ route('portal.login') }}"
                   class="inline-flex items-center gap-space-xs px-space-lg py-space-sm rounded-lg bg-secondary hover:bg-on-secondary-fixed-variant text-on-secondary font-label-md text-label-md shadow-sm transition-all">
                    <span class="material-symbols-outlined text-[20px]">login</span>
                    <span>Masuk sebagai Pelaku Usaha</span>
                </a>
            </div>

            {{-- Trust --}}
            <div class="flex flex-wrap items-center justify-center gap-y-2 gap-x-4 text-on-surface-variant font-label-sm text-label-sm">
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-primary-container text-[18px]">verified_user</span>
                    <span>Data Terverifikasi BBPOM Palangka Raya</span>
                </div>
                <span class="hidden sm:inline text-outline-variant">•</span>
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-secondary text-[18px]">shield</span>
                    <span>Perlindungan Konsumen</span>
                </div>
                <span class="hidden sm:inline text-outline-variant">•</span>
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-tertiary text-[18px]">visibility</span>
                    <span>Keterbukaan Informasi Publik</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="max-w-[1280px] w-full mx-auto px-margin-mobile lg:px-margin -mt-8 relative z-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        @foreach([
            ['icon'=>'science','label'=>'Sampel Diuji','value'=>$statSampel,'sub'=>'Realisasi uji mutu lab Prov. Kalteng '.date('Y'),'badge'=>'+12% YoY','color'=>'primary'],
            ['icon'=>'storefront','label'=>'Sarana Diperiksa','value'=>$statSarana,'sub'=>'Distribusi ritel & fasilitas produksi CPPOB','badge'=>'14 Kab/Kota','color'=>'secondary'],
            ['icon'=>'task_alt','label'=>'Tingkat Kepatuhan (MS)','value'=>$statKepatuhan,'sub'=>'Memenuhi parameter kelayakan konsumsi','badge'=>'Standar Aman','color'=>'primary'],
            ['icon'=>'published_with_changes','label'=>'Temuan Ditindaklanjuti','value'=>$statTemuan,'sub'=>'Closed CAPA terevaluasi tuntas','badge'=>'Disahkan','color'=>'tertiary'],
        ] as $stat)
        <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-center justify-between mb-space-sm">
                <div class="w-10 h-10 rounded-lg bg-surface-container-low text-{{ $stat['color'] }}-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">{{ $stat['icon'] }}</span>
                </div>
                <span class="inline-flex items-center gap-0.5 px-space-sm py-0.5 rounded-full bg-surface-container-low text-{{ $stat['color'] }}-container font-label-sm text-label-sm font-semibold">
                    {{ $stat['badge'] }}
                </span>
            </div>
            <div>
                <span class="font-headline-xl text-headline-xl text-on-surface font-bold tracking-tight block">
                    {{ is_int($stat['value']) ? number_format($stat['value']) : $stat['value'] }}
                </span>
                <p class="font-title-sm text-title-sm text-on-surface font-semibold">{{ $stat['label'] }}</p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $stat['sub'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Recent Results (Tabbed) --}}
<section class="max-w-[1280px] w-full mx-auto px-margin-mobile lg:px-margin mt-space-xl">
    <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-md lg:p-space-xl">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mb-space-lg">
            <div>
                <div class="inline-flex items-center gap-1 font-label-sm text-label-sm text-primary font-semibold uppercase tracking-wider mb-1">
                    <span class="material-symbols-outlined text-[16px]">biotech</span> Pemantauan Wilayah
                </div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Pratinjau Hasil Pengawasan Terkini</h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Data publik dari pengujian laboratorium dan pemeriksaan lapangan BBPOM Palangka Raya.</p>
            </div>
            <div class="inline-flex p-1 bg-surface-container rounded-lg self-start md:self-auto">
                <button wire:click="switchTab('sampel')" type="button"
                        class="px-space-md py-space-xs rounded-md font-label-md text-label-md transition-all {{ $activeTab === 'sampel' ? 'text-on-primary bg-primary-container shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Pengujian Sampel
                </button>
                <button wire:click="switchTab('sarana')" type="button"
                        class="px-space-md py-space-xs rounded-md font-label-md text-label-md transition-all {{ $activeTab === 'sarana' ? 'text-on-primary bg-secondary shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Pemeriksaan Sarana
                </button>
            </div>
        </div>

        @if($activeTab === 'sampel')
        <div class="overflow-x-auto" wire:key="tab-sampel">
            @if($recentSamplings->isEmpty())
                <div class="py-space-xl text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] block mb-2 text-outline">science</span>
                    <p class="font-body-sm text-body-sm">Belum ada data sampel yang dipublikasikan.</p>
                </div>
            @else
            <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface font-label-md text-label-md">
                        <th class="py-space-md px-space-md rounded-l-lg">Nama Produk & Merk</th>
                        <th class="py-space-md px-space-md">Kategori Pangan</th>
                        <th class="py-space-md px-space-md">Tempat Sampling</th>
                        <th class="py-space-md px-space-md">Tanggal Uji</th>
                        <th class="py-space-md px-space-md rounded-r-lg">Kesimpulan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    @foreach($recentSamplings as $item)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="py-space-md px-space-md font-label-md text-label-md text-on-surface">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined {{ $item->conclusion === 'non_compliant' ? 'text-error' : 'text-primary-container' }} text-[20px]">
                                    {{ $item->conclusion === 'non_compliant' ? 'warning' : 'inventory_2' }}
                                </span>
                                <span>{{ $item->product_name }}{{ $item->brand ? ' "'.$item->brand.'"' : '' }}</span>
                            </div>
                        </td>
                        <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->foodType?->foodCategory?->name ?? '—' }}</td>
                        <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->sampling_location }}</td>
                        <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->test_date?->translatedFormat('d M Y') ?? '—' }}</td>
                        <td class="py-space-md px-space-md">
                            @if($item->conclusion === 'compliant')
                                <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-label-sm font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-primary-container"></span> MS - Memenuhi Syarat
                                </span>
                            @elseif($item->conclusion === 'non_compliant')
                                <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-error-container text-on-error-container font-label-sm text-label-sm font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-error"></span> TMS{{ $item->conclusion_notes ? ' - '.$item->conclusion_notes : '' }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-space-sm py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm">
                                    Dalam Proses
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        @endif

        @if($activeTab === 'sarana')
        <div class="overflow-x-auto" wire:key="tab-sarana">
            @if($recentInspections->isEmpty())
                <div class="py-space-xl text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] block mb-2 text-outline">storefront</span>
                    <p class="font-body-sm text-body-sm">Belum ada data inspeksi yang dipublikasikan.</p>
                </div>
            @else
            <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-on-surface font-label-md text-label-md">
                        <th class="py-space-md px-space-md rounded-l-lg">Jenis Sarana</th>
                        <th class="py-space-md px-space-md">Kabupaten / Kota</th>
                        <th class="py-space-md px-space-md">Lingkup Pengawasan</th>
                        <th class="py-space-md px-space-md">Tanggal Pemeriksaan</th>
                        <th class="py-space-md px-space-md rounded-r-lg">Hasil Evaluasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    @foreach($recentInspections as $item)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="py-space-md px-space-md font-label-md text-label-md text-on-surface">
                            {{ $item->facility?->facility_type === 'production' ? 'Sarana Produksi' : 'Sarana Distribusi' }} Pangan
                        </td>
                        <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->facility?->regency ?? '—' }}</td>
                        <td class="py-space-md px-space-md text-on-surface-variant">Penerapan CPPOB/CPerPOB</td>
                        <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->inspection_date?->translatedFormat('d M Y') ?? '—' }}</td>
                        <td class="py-space-md px-space-md">
                            @if($item->status === 'completed')
                                <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-label-sm font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-primary-container"></span> Sesuai Standar
                                </span>
                            @elseif(in_array($item->status, ['awaiting_capa','capa_review']))
                                <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-secondary"></span> Dalam Pembinaan
                                </span>
                            @else
                                <span class="inline-flex items-center px-space-sm py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm">
                                    {{ ucwords(str_replace('_',' ',$item->status)) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        @endif

        <div class="mt-space-lg pt-space-md flex flex-col sm:flex-row items-center justify-between gap-space-md">
            <p class="font-body-sm text-body-sm text-on-surface-variant">Data tervalidasi publik periode terkini.</p>
            <a href="{{ route('publik.hasil-pengawasan') }}"
               class="inline-flex items-center gap-space-xs font-label-md text-label-md text-primary hover:text-primary-container font-semibold transition-colors">
                <span>Lihat Semua Hasil Pengawasan</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

{{-- 4-Step Process --}}
<section class="max-w-[1280px] w-full mx-auto px-margin-mobile lg:px-margin mt-space-xl">
    <div class="text-center max-w-2xl mx-auto mb-space-xl">
        <span class="font-label-sm text-label-sm text-primary font-semibold uppercase tracking-wider block mb-1">Alur Transparan</span>
        <h2 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Cara Kerja Pengawasan Si Kahayan</h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-2">Empat tahapan berjenjang menjamin akuntabilitas pengawasan dan kemudahan pemenuhan standar regulasi.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
        @foreach([
            ['step'=>'01','icon'=>'manage_search','title'=>'Sampling & Inspeksi','desc'=>'Petugas BBPOM mengambil sampel acak dan menginspeksi standar CPPOB/CPerPOB di sarana secara terukur dan objektif.','meta'=>'Lapangan & Lab','meta_icon'=>'pin_drop','bg'=>'bg-primary-fixed','text'=>'text-primary-container'],
            ['step'=>'02','icon'=>'qr_code_2','title'=>'BAP Terbit (QR Terproteksi)','desc'=>'Dokumen BAP resmi diterbitkan dengan kode verifikasi QR digital terenkripsi untuk mencegah pemalsuan.','meta'=>'Terotentikasi','meta_icon'=>'security','bg'=>'bg-secondary-fixed','text'=>'text-secondary'],
            ['step'=>'03','icon'=>'edit_note','title'=>'CAPA Pelaku Usaha','desc'=>'Pelaku usaha menyusun tindakan perbaikan (Corrective and Preventive Action) secara daring melalui portal mandiri.','meta'=>'Berbasis Web','meta_icon'=>'cloud_upload','bg'=>'bg-surface-container','text'=>'text-tertiary-container'],
            ['step'=>'04','icon'=>'verified','title'=>'Closed CAPA Disahkan','desc'=>'Verifikasi berjenjang oleh Tim Inspeksi dan Pengesahan digital Kepala Balai hingga kepatuhan dinyatakan tuntas.','meta'=>'Selesai & Rekomendasi','meta_icon'=>'check_circle','bg'=>'bg-primary-fixed','text'=>'text-primary'],
        ] as $s)
        <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
            <div class="w-12 h-12 rounded-xl {{ $s['bg'] }} {{ $s['text'] }} flex items-center justify-center mb-space-md">
                <span class="material-symbols-outlined text-[26px]">{{ $s['icon'] }}</span>
            </div>
            <div>
                <span class="font-label-sm text-label-sm {{ $s['text'] }} font-bold tracking-widest uppercase block mb-1">Tahap {{ $s['step'] }}</span>
                <h3 class="font-title-sm text-title-sm text-on-surface font-semibold mb-2">{{ $s['title'] }}</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">{{ $s['desc'] }}</p>
            </div>
            <div class="mt-space-md pt-space-sm flex items-center gap-1.5 {{ $s['text'] }} font-label-sm text-label-sm font-semibold">
                <span class="material-symbols-outlined text-[16px]">{{ $s['meta_icon'] }}</span> {{ $s['meta'] }}
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Privacy Notice --}}
<section class="max-w-[1280px] w-full mx-auto px-margin-mobile lg:px-margin mt-space-xl mb-space-xl">
    <div class="rounded-xl bg-surface-container-low p-space-md lg:p-space-lg shadow-sm relative overflow-hidden">
        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-secondary"></div>
        <div class="flex flex-col sm:flex-row items-start gap-space-md">
            <div class="w-10 h-10 rounded-full bg-surface-container-lowest text-secondary flex items-center justify-center shrink-0 shadow-sm">
                <span class="material-symbols-outlined text-[22px]">shield_person</span>
            </div>
            <div class="flex-1">
                <h3 class="font-title-sm text-title-sm text-on-surface font-semibold flex flex-wrap items-center gap-2 mb-1">
                    <span>Komitmen Privasi & Keterbukaan Informasi Publik</span>
                    <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-container-high text-secondary">UU KIP & PDP</span>
                </h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                    Data pribadi, NIB, NPWP, nomor kontak penanggung jawab, alamat terperinci sarana, serta rincian dokumen CAPA internal dilindungi secara ketat dan tidak ditampilkan kepada publik sesuai regulasi pengawasan serta perundang-undangan perlindungan data pribadi yang berlaku.
                </p>
            </div>
        </div>
    </div>
</section>
</div>
