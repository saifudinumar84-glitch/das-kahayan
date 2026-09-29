<x-filament-panels::page>
    <div class="space-y-6">
        <!-- FILTER BAR -->
        <div class="p-5 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <x-heroicon-o-funnel class="w-5 h-5 text-primary-500" />
                Filter Parameter Laporan
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                    <input type="date" wire:model.live="startDate" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai</label>
                    <input type="date" wire:model.live="endDate" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Kabupaten / Kota</label>
                    <select wire:model.live="regency" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Wilayah (Kalteng)</option>
                        <option value="Kota Palangka Raya">Kota Palangka Raya</option>
                        <option value="Kabupaten Kotawaringin Barat">Kabupaten Kotawaringin Barat</option>
                        <option value="Kabupaten Kotawaringin Timur">Kabupaten Kotawaringin Timur</option>
                        <option value="Kabupaten Kapuas">Kabupaten Kapuas</option>
                        <option value="Kabupaten Barito Selatan">Kabupaten Barito Selatan</option>
                        <option value="Kabupaten Barito Timur">Kabupaten Barito Timur</option>
                        <option value="Kabupaten Barito Utara">Kabupaten Barito Utara</option>
                        <option value="Kabupaten Gunung Mas">Kabupaten Gunung Mas</option>
                        <option value="Kabupaten Katingan">Kabupaten Katingan</option>
                        <option value="Kabupaten Pulang Pisau">Kabupaten Pulang Pisau</option>
                        <option value="Kabupaten Murung Raya">Kabupaten Murung Raya</option>
                        <option value="Kabupaten Lamandau">Kabupaten Lamandau</option>
                        <option value="Kabupaten Sukamara">Kabupaten Sukamara</option>
                        <option value="Kabupaten Seruyan">Kabupaten Seruyan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Kesimpulan Hasil</label>
                    <select wire:model.live="conclusion" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Status (MS & TMS)</option>
                        <option value="MS">Memenuhi Syarat (MS)</option>
                        <option value="TMS">Tidak Memenuhi Syarat (TMS)</option>
                    </select>
                </div>
            </div>
        </div>

        @php
            $data = $this->reportData;
            $stats = $data['stats'];
        @endphp

        <!-- STATS OVERVIEW CARDS -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Sarana Diperiksa</div>
                <div class="mt-2 text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $stats['total_inspections'] }}</div>
                <div class="mt-1 text-xs text-gray-500">
                    <span class="text-emerald-600 font-medium">{{ $stats['inspections_ms'] }} MS</span> &bull; 
                    <span class="text-rose-600 font-medium">{{ $stats['inspections_tms'] }} TMS</span>
                </div>
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Sampel Diuji</div>
                <div class="mt-2 text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['total_samplings'] }}</div>
                <div class="mt-1 text-xs text-gray-500">
                    <span class="text-emerald-600 font-medium">{{ $stats['samplings_ms'] }} MS</span> &bull; 
                    <span class="text-rose-600 font-medium">{{ $stats['samplings_tms'] }} TMS</span>
                </div>
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Ketidaksesuaian</div>
                <div class="mt-2 text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['total_findings'] }}</div>
                <div class="mt-1 text-xs text-gray-500">Temuan Sarana Pangan</div>
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">CAPA Disetujui (Closed)</div>
                <div class="mt-2 text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['total_capa_closed'] }}</div>
                <div class="mt-1 text-xs text-gray-500">Surat Pengesahan BBPOM</div>
            </div>
        </div>

        <!-- TABEL DATA INSPEKSI TERAKHIR -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h4 class="font-semibold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                    <x-heroicon-o-clipboard-document-check class="w-4 h-4 text-primary-500" />
                    Rincian Pemeriksaan Sarana (Sampel 20 Terakhir)
                </h4>
                <a href="{{ route('export.executive.excel', ['start_date' => $this->startDate, 'end_date' => $this->endDate, 'regency' => $this->regency]) }}" target="_blank" class="text-xs text-primary-600 hover:underline font-medium">
                    Lihat Seluruh Data di Excel &rarr;
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 font-semibold border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-3">No. Pemeriksaan</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Sarana</th>
                            <th class="px-4 py-3">Wilayah</th>
                            <th class="px-4 py-3">Grade</th>
                            <th class="px-4 py-3">Kesimpulan</th>
                            <th class="px-4 py-3">Temuan</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($data['inspections'] as $insp)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $insp->inspection_number }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $insp->inspection_date?->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $insp->facility?->name }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $insp->facility?->regency }}</td>
                                <td class="px-4 py-3 font-bold text-primary-600">{{ $insp->grade ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if(str_contains(strtolower($insp->conclusion ?? ''), 'tidak'))
                                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-rose-100 text-rose-800 dark:bg-rose-900/50 dark:text-rose-300">TMS</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">MS</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold {{ $insp->findings->count() > 0 ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $insp->findings->count() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('export.bap.pdf', $insp->id) }}" target="_blank" class="text-xs text-primary-600 hover:text-primary-800 font-medium inline-flex items-center gap-1">
                                        <x-heroicon-o-document-text class="w-3.5 h-3.5" />
                                        PDF BAP
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-gray-500">Tidak ada data pemeriksaan yang cocok dengan filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TABEL DATA SAMPLING TERAKHIR -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h4 class="font-semibold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                    <x-heroicon-o-beaker class="w-4 h-4 text-emerald-500" />
                    Rincian Uji Sampel Pangan (Sampel 20 Terakhir)
                </h4>
                <a href="{{ route('export.executive.excel', ['start_date' => $this->startDate, 'end_date' => $this->endDate, 'regency' => $this->regency]) }}" target="_blank" class="text-xs text-emerald-600 hover:underline font-medium">
                    Lihat Seluruh Data di Excel &rarr;
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 font-semibold border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-3">No. Sampling</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3">Jenis Pangan</th>
                            <th class="px-4 py-3">Lokasi Sampling</th>
                            <th class="px-4 py-3">Kesimpulan Lab</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($data['samplings'] as $smp)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $smp->sampling_number }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $smp->sampling_date?->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    {{ $smp->product_name }}
                                    @if($smp->brand)<span class="text-gray-500 text-[11px]">({{ $smp->brand }})</span>@endif
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $smp->foodType?->name }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ Str::limit($smp->sampling_location, 30) }}</td>
                                <td class="px-4 py-3">
                                    @if($smp->conclusion?->value === 'ms')
                                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">MS</span>
                                    @elseif($smp->conclusion?->value === 'tms')
                                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-rose-100 text-rose-800 dark:bg-rose-900/50 dark:text-rose-300">TMS</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300">Proses</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('export.sampling.pdf', $smp->id) }}" target="_blank" class="text-xs text-emerald-600 hover:text-emerald-800 font-medium inline-flex items-center gap-1">
                                        <x-heroicon-o-document-magnifying-glass class="w-3.5 h-3.5" />
                                        PDF Uji
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">Tidak ada data sampling pangan yang cocok dengan filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
