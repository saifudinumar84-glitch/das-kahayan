<div class="flex flex-col w-full">
{{-- Breadcrumb --}}
<div class="w-full bg-surface-container-high py-space-xs px-margin-mobile lg:px-margin">
    <div class="max-w-[1280px] mx-auto flex items-center gap-space-xs text-on-surface-variant font-label-sm text-label-sm">
        <a href="{{ route('publik.beranda') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">home</span> Beranda
        </a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-semibold">Validasi BAP</span>
    </div>
</div>

<div class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin pt-space-lg pb-space-xl">
    <div class="max-w-2xl mx-auto">

        {{-- Title --}}
        <div class="text-center mb-space-xl">
            <div class="w-16 h-16 rounded-2xl bg-secondary-container/40 text-secondary flex items-center justify-center mx-auto mb-space-md shadow-sm">
                <span class="material-symbols-outlined text-[36px]">qr_code_scanner</span>
            </div>
            <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight mb-2">Validasi Dokumen BAP</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">
                Masukkan kode token dari QR Code dokumen Berita Acara Pemeriksaan (BAP) untuk memverifikasi keasliannya.
            </p>
        </div>

        {{-- Input Form --}}
        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg mb-space-lg">
            <form wire:submit="verify" class="flex flex-col gap-space-md">
                <div>
                    <label for="bap-token" class="font-label-md text-label-md text-on-surface block mb-space-sm">
                        Kode Token BAP
                    </label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-space-md text-outline text-[22px]">key</span>
                        <input wire:model="token"
                               id="bap-token"
                               type="text"
                               placeholder="Contoh: BBPOM-2026-XXXXXXXX"
                               class="w-full h-12 pl-12 pr-space-md rounded-lg bg-surface-container-low text-on-surface font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-primary-container transition-all tracking-wider uppercase"
                               autocomplete="off"/>
                    </div>
                    <p class="font-label-sm text-label-sm text-on-surface-variant mt-1.5">
                        Token dapat ditemukan pada bagian bawah dokumen BAP atau dengan scan QR Code.
                    </p>
                </div>
                <button type="submit"
                        class="h-12 w-full rounded-lg bg-primary-container hover:bg-primary text-on-primary font-label-md text-label-md flex items-center justify-center gap-space-xs transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">verified</span>
                    <span>Verifikasi Sekarang</span>
                </button>
            </form>
        </div>

        {{-- Loading --}}
        <div wire:loading class="flex items-center justify-center gap-2 text-on-surface-variant font-label-sm text-label-sm mb-space-md">
            <span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span> Memverifikasi...
        </div>

        {{-- Results --}}
        @if($isSearched)
            @if($document)
            {{-- VALID --}}
            <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                <div class="bg-primary-fixed p-space-md flex items-center gap-space-md">
                    <div class="w-12 h-12 rounded-full bg-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-on-primary text-[26px]">verified</span>
                    </div>
                    <div>
                        <p class="font-title-sm text-title-sm text-on-primary-fixed font-semibold">Dokumen Terverifikasi ✓</p>
                        <p class="font-body-sm text-body-sm text-on-primary-fixed-variant">Dokumen BAP ini sah dan diterbitkan oleh BBPOM Palangka Raya.</p>
                    </div>
                </div>
                <div class="p-space-lg grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-0.5">Nomor Dokumen</p>
                        <p class="font-label-md text-label-md text-on-surface">{{ $document->document_number }}</p>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-0.5">Tanggal Diterbitkan</p>
                        <p class="font-label-md text-label-md text-on-surface">{{ $document->generated_at?->translatedFormat('d MMMM Y, HH:mm') ?? '—' }} WIB</p>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-0.5">Sarana yang Diperiksa</p>
                        <p class="font-label-md text-label-md text-on-surface">{{ $document->inspection?->facility?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-0.5">Kabupaten / Kota</p>
                        <p class="font-label-md text-label-md text-on-surface">{{ $document->inspection?->facility?->regency ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-0.5">Tanggal Pemeriksaan</p>
                        <p class="font-label-md text-label-md text-on-surface">{{ $document->inspection?->inspection_date?->translatedFormat('d MMMM Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-0.5">Nomor Inspeksi</p>
                        <p class="font-label-md text-label-md text-on-surface">{{ $document->inspection?->inspection_number ?? '—' }}</p>
                    </div>
                </div>
                <div class="px-space-lg pb-space-lg">
                    <div class="rounded-lg bg-surface-container-low p-space-md flex items-start gap-space-sm">
                        <span class="material-symbols-outlined text-secondary text-[20px] shrink-0">shield_person</span>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                            Data detail pemeriksaan bersifat rahasia. Informasi yang ditampilkan hanya mencakup data publik yang diizinkan sesuai regulasi Keterbukaan Informasi Publik.
                        </p>
                    </div>
                </div>
            </div>
            @else
            {{-- INVALID --}}
            <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                <div class="bg-error-container p-space-md flex items-center gap-space-md">
                    <div class="w-12 h-12 rounded-full bg-error flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-on-error text-[26px]">gpp_bad</span>
                    </div>
                    <div>
                        <p class="font-title-sm text-title-sm text-on-error-container font-semibold">Dokumen Tidak Ditemukan</p>
                        <p class="font-body-sm text-body-sm text-on-error-container/80">Token yang Anda masukkan tidak sesuai dengan catatan resmi kami.</p>
                    </div>
                </div>
                <div class="p-space-lg">
                    <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-md">Kemungkinan penyebab:</p>
                    <ul class="space-y-space-xs font-body-sm text-body-sm text-on-surface-variant">
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-[16px] text-outline mt-0.5">circle</span> Token salah ketik atau tidak lengkap</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-[16px] text-outline mt-0.5">circle</span> Dokumen BAP tersebut tidak terdaftar dalam sistem Si Kahayan</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-[16px] text-outline mt-0.5">circle</span> Dokumen mungkin tidak sah atau telah dimanipulasi</li>
                    </ul>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-space-md">
                        Hubungi BBPOM Palangka Raya di <span class="font-label-md text-label-md text-primary">Halo BPOM 1500533</span> jika ada pertanyaan lebih lanjut.
                    </p>
                </div>
            </div>
            @endif
        @endif

        {{-- How to Use --}}
        @if(!$isSearched)
        <div class="rounded-xl bg-surface-container-low p-space-md mt-space-lg">
            <h2 class="font-title-sm text-title-sm text-on-surface mb-space-md flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">help_outline</span>
                Cara Menggunakan Validasi BAP
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-md">
                @foreach([
                    ['icon'=>'qr_code_scanner','step'=>'1','title'=>'Scan QR Code','desc'=>'Arahkan kamera pada QR Code di pojok kanan dokumen BAP fisik atau digital.'],
                    ['icon'=>'content_paste','step'=>'2','title'=>'Salin Token','desc'=>'Token otomatis terisi, atau ketik manual kode token di bawah dokumen BAP.'],
                    ['icon'=>'verified','step'=>'3','title'=>'Verifikasi','desc'=>'Sistem akan menampilkan status keaslian dan informasi singkat pemeriksaan.'],
                ] as $step)
                <div class="flex flex-col items-center text-center p-space-md rounded-lg bg-surface-container-lowest">
                    <div class="w-10 h-10 rounded-full bg-primary-fixed text-primary-container flex items-center justify-center mb-space-sm">
                        <span class="material-symbols-outlined text-[22px]">{{ $step['icon'] }}</span>
                    </div>
                    <span class="font-label-sm text-label-sm text-primary font-bold uppercase tracking-wider mb-1">Langkah {{ $step['step'] }}</span>
                    <p class="font-title-sm text-title-sm text-on-surface font-semibold mb-1">{{ $step['title'] }}</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
</div>
