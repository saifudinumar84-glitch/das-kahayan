{{-- Breadcrumb & Title --}}
<div class="relative w-full max-w-[1280px] mx-auto px-margin-mobile lg:px-margin pt-space-md pb-space-xl">

    {{-- Breadcrumb + Live badge --}}
    <div class="flex flex-wrap items-center justify-between gap-space-sm mb-space-md">
        <nav class="flex items-center gap-space-xs font-label-sm text-label-sm text-on-surface-variant">
            <a href="{{ route('publik.beranda') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">home</span> Beranda
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-semibold">Hasil Pengawasan</span>
        </nav>
        <div class="inline-flex items-center gap-2 bg-surface-container px-3 py-1.5 rounded-full text-on-surface-variant font-label-sm text-label-sm">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
            </span>
            <span>Diperbarui secara berkala</span>
        </div>
    </div>

    {{-- Title --}}
    <div class="mb-space-lg">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container text-primary font-label-sm text-label-sm rounded-full mb-3">
            <span class="material-symbols-outlined text-[16px]">shield_with_heart</span>
            <span>Layanan Kawal Mutu Pangan Bumi Tambun Bungai</span>
        </div>
        <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight mb-2">Dashboard Publik Hasil Pengawasan Pangan</h1>
        <p class="font-body-md text-body-md text-on-surface-variant max-w-4xl leading-relaxed">
            Transparansi data pengujian laboratorium sampel pangan dan pemeriksaan sarana peredaran di 13 Kabupaten dan 1 Kota se-Kalimantan Tengah secara berkala, akuntabel, dan terlindungi privasi.
        </p>
    </div>

    {{-- Summary Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-gutter mb-space-lg">
        @foreach([
            ['icon'=>'science','label'=>'Total Sampel','value'=>$totalSamplings,'color'=>'primary-container'],
            ['icon'=>'storefront','label'=>'Total Inspeksi','value'=>$totalInspections,'color'=>'secondary'],
        ] as $stat)
        <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex items-center gap-space-md">
            <div class="w-10 h-10 rounded-lg bg-surface-container-low text-{{ $stat['color'] }} flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[22px]">{{ $stat['icon'] }}</span>
            </div>
            <div>
                <p class="font-headline-md text-headline-md text-on-surface font-bold">{{ number_format($stat['value']) }}</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $stat['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filter Card --}}
    <div class="bg-surface-container-lowest p-space-md lg:p-space-lg rounded-xl shadow-sm mb-space-lg">
        <div class="flex items-center justify-between gap-space-sm mb-space-md">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">tune</span>
                <span class="font-title-sm text-title-sm text-on-surface">Filter Interaktif</span>
            </div>
            <button wire:click="resetFilters" type="button"
                    class="inline-flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-[16px]">refresh</span> Reset
            </button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
            {{-- Tahun --}}
            <div class="flex flex-col gap-1.5">
                <label for="filter-year" class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">calendar_today</span> Periode Tahun
                </label>
                <div class="relative">
                    <select wire:model.live="year" id="filter-year"
                            class="w-full h-11 px-3 bg-surface-container-low rounded-lg font-body-sm text-body-sm text-on-surface appearance-none focus:outline-none pr-9 cursor-pointer">
                        @foreach(range(date('Y'), 2020) as $y)
                            <option value="{{ $y }}">Tahun {{ $y }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-3 pointer-events-none text-on-surface-variant text-[18px]">expand_more</span>
                </div>
            </div>

            {{-- Kategori --}}
            <div class="flex flex-col gap-1.5">
                <label for="filter-category" class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">category</span> Kategori Pangan
                </label>
                <div class="relative">
                    <input wire:model.live="category" id="filter-category" type="text" placeholder="Semua kategori"
                           class="w-full h-11 px-3 bg-surface-container-low rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-primary-container"/>
                </div>
            </div>

            {{-- Kabupaten --}}
            <div class="flex flex-col gap-1.5">
                <label for="filter-regency" class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">location_on</span> Kabupaten / Kota
                </label>
                <input wire:model.live="regency" id="filter-regency" type="text" placeholder="Semua wilayah"
                       class="w-full h-11 px-3 bg-surface-container-low rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-primary-container"/>
            </div>

            {{-- Status --}}
            <div class="flex flex-col gap-1.5">
                <label for="filter-conclusion" class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">fact_check</span> Status Hasil
                </label>
                <div class="relative">
                    <select wire:model.live="conclusion" id="filter-conclusion"
                            class="w-full h-11 px-3 bg-surface-container-low rounded-lg font-body-sm text-body-sm text-on-surface appearance-none focus:outline-none pr-9 cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="compliant">MS - Memenuhi Syarat</option>
                        <option value="non_compliant">TMS - Tidak Memenuhi Syarat</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-3 pointer-events-none text-on-surface-variant text-[18px]">expand_more</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tab Switcher & Export Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-md mb-space-md">
        <div class="flex items-center gap-space-md">
            <div class="inline-flex p-1 bg-surface-container rounded-lg">
                <button wire:click="switchTab('sampel')" type="button"
                        class="px-space-md py-space-xs rounded-md font-label-md text-label-md transition-all {{ $activeTab === 'sampel' ? 'text-on-primary bg-primary-container shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                    <span class="material-symbols-outlined text-[16px] align-middle mr-1">science</span> Hasil Pengujian Sampel
                </button>
                <button wire:click="switchTab('sarana')" type="button"
                        class="px-space-md py-space-xs rounded-md font-label-md text-label-md transition-all {{ $activeTab === 'sarana' ? 'text-on-primary bg-secondary shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                    <span class="material-symbols-outlined text-[16px] align-middle mr-1">storefront</span> Pemeriksaan Sarana
                </button>
            </div>
            <div wire:loading class="flex items-center gap-2 text-on-surface-variant font-label-sm text-label-sm">
                <span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span> Memuat...
            </div>
        </div>

        {{-- Export Buttons --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('export.public.excel', ['type' => $activeTab === 'sampel' ? 'sampling' : 'inspection', 'regency' => $regency, 'conclusion' => $conclusion]) }}"
               target="_blank"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm transition-colors border border-outline-variant/30">
                <span class="material-symbols-outlined text-[16px] text-emerald-600">table_view</span>
                <span>Ekspor Excel</span>
            </a>
            <a href="{{ route('export.public.pdf', ['type' => $activeTab === 'sampel' ? 'sampling' : 'inspection', 'regency' => $regency, 'conclusion' => $conclusion]) }}"
               target="_blank"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-sm text-label-sm transition-colors border border-outline-variant/30">
                <span class="material-symbols-outlined text-[16px] text-rose-600">picture_as_pdf</span>
                <span>Ekspor PDF</span>
            </a>
        </div>
    </div>

    {{-- Tab: Sampel --}}
    @if($activeTab === 'sampel')
    <div wire:key="tab-sampel-results">
        @if($samplings->isEmpty())
            <div class="bg-surface-container-lowest rounded-xl p-space-xl text-center">
                <span class="material-symbols-outlined text-[56px] text-outline block mb-3">science</span>
                <p class="font-title-sm text-title-sm text-on-surface mb-1">Tidak Ada Data</p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Tidak ada sampel yang cocok dengan filter yang dipilih.</p>
            </div>
        @else
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface font-label-md text-label-md">
                            <th class="py-space-md px-space-md">No. Sampling</th>
                            <th class="py-space-md px-space-md">Nama Produk & Merk</th>
                            <th class="py-space-md px-space-md">Kategori Pangan</th>
                            <th class="py-space-md px-space-md">Tempat Sampling</th>
                            <th class="py-space-md px-space-md">Tanggal Uji</th>
                            <th class="py-space-md px-space-md">Kesimpulan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @foreach($samplings as $item)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-space-md px-space-md font-label-sm text-label-sm text-on-surface-variant">{{ $item->sampling_number }}</td>
                            <td class="py-space-md px-space-md font-label-md text-label-md text-on-surface">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined {{ $item->conclusion === 'non_compliant' ? 'text-error' : 'text-primary-container' }} text-[18px]">
                                        {{ $item->conclusion === 'non_compliant' ? 'warning' : 'inventory_2' }}
                                    </span>
                                    <div>
                                        <a href="{{ route('publik.detail-pengujian', ['id' => $item->id]) }}" class="hover:text-primary hover:underline font-semibold text-on-surface">
                                            {{ $item->product_name ?? $item->sample_name }}
                                        </a>
                                        @if($item->brand)<p class="font-body-sm text-body-sm text-on-surface-variant">{{ $item->brand }}</p>@endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->foodType?->foodCategory?->name ?? '—' }}</td>
                            <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->sampling_location }}</td>
                            <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->test_date?->translatedFormat('d M Y') ?? '—' }}</td>
                            <td class="py-space-md px-space-md">
                                @if($item->conclusion === 'compliant')
                                    <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-label-sm font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-primary-container"></span> MS
                                    </span>
                                @elseif($item->conclusion === 'non_compliant')
                                    <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-error-container text-on-error-container font-label-sm text-label-sm font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-error"></span> TMS
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-space-sm py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm">Proses</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-space-md border-t border-surface-container">
                {{ $samplings->links() }}
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- Tab: Sarana --}}
    @if($activeTab === 'sarana')
    <div wire:key="tab-sarana-results">
        @if($inspections->isEmpty())
            <div class="bg-surface-container-lowest rounded-xl p-space-xl text-center">
                <span class="material-symbols-outlined text-[56px] text-outline block mb-3">storefront</span>
                <p class="font-title-sm text-title-sm text-on-surface mb-1">Tidak Ada Data</p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Tidak ada inspeksi yang cocok dengan filter yang dipilih.</p>
            </div>
        @else
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface font-label-md text-label-md">
                            <th class="py-space-md px-space-md">No. Inspeksi</th>
                            <th class="py-space-md px-space-md">Jenis Sarana</th>
                            <th class="py-space-md px-space-md">Kabupaten / Kota</th>
                            <th class="py-space-md px-space-md">Tanggal Pemeriksaan</th>
                            <th class="py-space-md px-space-md">Grade</th>
                            <th class="py-space-md px-space-md">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @foreach($inspections as $item)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-space-md px-space-md font-label-sm text-label-sm">
                                <a href="{{ route('publik.detail-pengujian', ['id' => $item->id]) }}" class="text-primary hover:underline font-bold">
                                    {{ $item->inspection_number }}
                                </a>
                            </td>
                            <td class="py-space-md px-space-md font-label-md text-label-md text-on-surface">
                                {{ $item->facility?->facility_type === 'production' ? 'Sarana Produksi' : 'Sarana Distribusi' }}
                                @if($item->facility?->commodity_type)
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $item->facility->commodity_type }}</p>
                                @endif
                            </td>
                            <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->facility?->regency ?? '—' }}</td>
                            <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->inspection_date?->translatedFormat('d M Y') ?? '—' }}</td>
                            <td class="py-space-md px-space-md font-label-md text-label-md text-on-surface">{{ $item->grade ?: '—' }}</td>
                            <td class="py-space-md px-space-md">
                                @php
                                    $statusValue = $item->status?->value ?? (is_string($item->status) ? $item->status : '');
                                @endphp
                                @if($statusValue === 'completed' || $item->status === \App\Enums\InspectionStatus::Completed)
                                    <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-label-sm font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-primary-container"></span> Selesai
                                    </span>
                                @elseif(in_array($statusValue, ['awaiting_capa','capa_review'], true) || in_array($item->status, [\App\Enums\InspectionStatus::AwaitingCapa, \App\Enums\InspectionStatus::CapaReview], true))
                                    <span class="inline-flex items-center gap-1.5 px-space-sm py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-semibold">
                                        <span class="w-2 h-2 rounded-full bg-secondary"></span> Pembinaan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-space-sm py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm">
                                        {{ $item->status instanceof \App\Enums\InspectionStatus ? $item->status->getLabel() : ucwords(str_replace('_',' ', $statusValue)) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-space-md border-t border-surface-container">
                {{ $inspections->links() }}
            </div>
        </div>
        @endif
    </div>
    @endif

</div>
