<div class="flex flex-col w-full">
{{-- Top Banner --}}
<div class="w-full bg-surface-container-high py-space-xs px-margin-mobile lg:px-margin">
    <div class="max-w-[1280px] mx-auto flex flex-wrap items-center justify-between gap-space-sm text-on-surface-variant font-label-sm text-label-sm">
        <nav class="flex items-center gap-space-xs">
            <a href="{{ route('publik.beranda') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">home</span> Beranda
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-semibold">Cari Produk & Sarana</span>
        </nav>
    </div>
</div>

<div class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin pt-space-lg pb-space-xl">

    {{-- Title --}}
    <div class="mb-space-lg">
        <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight mb-2">Cari Produk & Sarana Usaha Pangan</h1>
        <p class="font-body-md text-body-md text-on-surface-variant max-w-3xl">
            Cari nama produk pangan olahan atau sarana usaha yang telah terdata dalam pengawasan BBPOM Palangka Raya.
        </p>
    </div>

    {{-- Search Box --}}
    <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-md lg:p-space-lg mb-space-lg">
        <div class="flex flex-col sm:flex-row gap-space-sm mb-space-md">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-space-md top-3 text-outline text-[22px]">search</span>
                <input wire:model.live.debounce.500ms="query"
                       id="search-query"
                       type="text"
                       placeholder="Ketik nama produk atau nama sarana usaha..."
                       class="w-full h-12 pl-12 pr-space-md rounded-lg bg-surface-container-low text-on-surface font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-primary-container transition-all"/>
            </div>
            <button wire:click="$set('query', '')" type="button"
                    class="h-12 px-space-lg rounded-lg border border-outline-variant text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-[18px]">close</span> Hapus
            </button>
        </div>

        {{-- Search Type --}}
        <div class="flex flex-wrap gap-space-sm">
            <span class="font-label-sm text-label-sm text-on-surface-variant self-center">Cari di:</span>
            @foreach(['all'=>'Semua','produk'=>'Produk Pangan','sarana'=>'Sarana Usaha'] as $val => $label)
            <button wire:click="$set('searchType', '{{ $val }}')" type="button"
                    class="px-space-md py-space-xs rounded-full font-label-sm text-label-sm transition-all {{ $searchType === $val ? 'bg-primary-container text-on-primary font-semibold' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-high' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- Loading State --}}
    <div wire:loading class="flex items-center gap-2 text-on-surface-variant font-label-sm text-label-sm mb-space-md">
        <span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span> Mencari...
    </div>

    {{-- Empty Query --}}
    @if(mb_strlen(trim($query)) < 2 && !$query)
    <div class="bg-surface-container-lowest rounded-xl p-space-xl text-center">
        <span class="material-symbols-outlined text-[64px] text-outline block mb-3">manage_search</span>
        <p class="font-title-sm text-title-sm text-on-surface mb-1">Mulai Pencarian</p>
        <p class="font-body-sm text-body-sm text-on-surface-variant">Ketikkan minimal 2 karakter untuk mencari produk atau sarana usaha pangan.</p>
    </div>
    @else

    {{-- Results: Produk --}}
    @if(in_array($searchType, ['all','produk']) && $products instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mb-space-lg" wire:key="products-section">
        <div class="flex items-center justify-between mb-space-md">
            <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary-container text-[22px]">inventory_2</span>
                Hasil Produk Pangan
                <span class="font-label-sm text-label-sm text-on-surface-variant font-normal">({{ $products->total() }} ditemukan)</span>
            </h2>
        </div>
        @if($products->isEmpty())
            <div class="bg-surface-container-lowest rounded-xl p-space-lg text-center text-on-surface-variant">
                <span class="font-body-sm text-body-sm">Tidak ada produk yang cocok dengan kata kunci "{{ $query }}".</span>
            </div>
        @else
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden mb-space-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface font-label-md text-label-md">
                            <th class="py-space-md px-space-md rounded-l-lg">Nama Produk & Merk</th>
                            <th class="py-space-md px-space-md">Kategori</th>
                            <th class="py-space-md px-space-md">Tempat Sampling</th>
                            <th class="py-space-md px-space-md">Tanggal Uji</th>
                            <th class="py-space-md px-space-md rounded-r-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @foreach($products as $item)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-space-md px-space-md">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined {{ $item->conclusion === 'non_compliant' ? 'text-error' : 'text-primary-container' }} text-[18px]">
                                        {{ $item->conclusion === 'non_compliant' ? 'warning' : 'inventory_2' }}
                                    </span>
                                    <div>
                                        <a href="{{ route('publik.detail-pengujian', ['id' => $item->id]) }}" class="font-label-md text-label-md text-on-surface hover:text-primary hover:underline block font-semibold">
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
            <div class="p-space-md border-t border-surface-container">{{ $products->links() }}</div>
        </div>
        @endif
    </div>
    @endif

    {{-- Results: Sarana --}}
    @if(in_array($searchType, ['all','sarana']) && $facilities instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div wire:key="facilities-section">
        <div class="flex items-center justify-between mb-space-md">
            <h2 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-[22px]">storefront</span>
                Hasil Sarana Usaha
                <span class="font-label-sm text-label-sm text-on-surface-variant font-normal">({{ $facilities->total() }} ditemukan)</span>
            </h2>
        </div>
        @if($facilities->isEmpty())
            <div class="bg-surface-container-lowest rounded-xl p-space-lg text-center text-on-surface-variant">
                <span class="font-body-sm text-body-sm">Tidak ada sarana yang cocok dengan kata kunci "{{ $query }}".</span>
            </div>
        @else
        <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface font-label-md text-label-md">
                            <th class="py-space-md px-space-md rounded-l-lg">Nama Sarana</th>
                            <th class="py-space-md px-space-md">Jenis</th>
                            <th class="py-space-md px-space-md">Komoditas</th>
                            <th class="py-space-md px-space-md rounded-r-lg">Kabupaten / Kota</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @foreach($facilities as $item)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-space-md px-space-md font-label-md text-label-md text-on-surface">
                                <a href="{{ route('publik.detail-pengujian') }}" class="hover:text-primary hover:underline font-semibold">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td class="py-space-md px-space-md text-on-surface-variant">
                                {{ $item->facility_type === 'production' ? 'Produksi' : 'Distribusi' }}
                            </td>
                            <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->commodity_type ?: '—' }}</td>
                            <td class="py-space-md px-space-md text-on-surface-variant">{{ $item->regency ?: '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-space-md border-t border-surface-container">{{ $facilities->links() }}</div>
        </div>
        @endif
    </div>
    @endif

    @endif {{-- end query check --}}
</div>
</div>
