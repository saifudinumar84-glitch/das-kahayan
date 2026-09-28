<div class="flex flex-col w-full">
{{-- Breadcrumb --}}
<div class="w-full bg-surface-container-high py-space-xs px-margin-mobile lg:px-margin">
    <div class="max-w-[1280px] mx-auto flex items-center gap-space-xs text-on-surface-variant font-label-sm text-label-sm">
        <a href="{{ route('publik.beranda') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">home</span> Beranda
        </a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-semibold">Panduan</span>
    </div>
</div>

<div class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin pt-space-lg pb-space-xl">

    {{-- Title --}}
    <div class="mb-space-xl max-w-3xl">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container text-primary font-label-sm text-label-sm rounded-full mb-3">
            <span class="material-symbols-outlined text-[16px]">help_outline</span>
            <span>Panduan Penggunaan Si Kahayan</span>
        </div>
        <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight mb-2">Panduan Penggunaan Sistem</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Pelajari cara menggunakan sistem Si Kahayan — baik sebagai masyarakat umum maupun sebagai pelaku usaha pangan.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">

        {{-- Sidebar Navigation --}}
        <div class="lg:col-span-3">
            <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-md sticky top-24">
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-space-sm">Pilih Panduan</p>
                <nav class="flex flex-col gap-1">
                    @foreach([
                        ['key'=>'masyarakat','label'=>'Masyarakat Umum','icon'=>'people'],
                        ['key'=>'pelaku-usaha','label'=>'Pelaku Usaha','icon'=>'storefront'],
                        ['key'=>'validasi-bap','label'=>'Validasi BAP','icon'=>'qr_code_scanner'],
                        ['key'=>'portal','label'=>'Portal Pelaku Usaha','icon'=>'login'],
                    ] as $nav)
                    <button wire:click="switchSection('{{ $nav['key'] }}')" type="button"
                            class="flex items-center gap-space-sm px-space-md py-space-sm rounded-lg text-left font-label-md text-label-md transition-all {{ $activeSection === $nav['key'] ? 'bg-primary-container text-on-primary' : 'text-on-surface-variant hover:bg-surface-container' }}">
                        <span class="material-symbols-outlined text-[18px]">{{ $nav['icon'] }}</span>
                        {{ $nav['label'] }}
                    </button>
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="lg:col-span-9">

            {{-- Masyarakat --}}
            @if($activeSection === 'masyarakat')
            <div wire:key="guide-masyarakat">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-space-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary-container text-[28px]">people</span>
                    Panduan untuk Masyarakat Umum
                </h2>
                <div class="space-y-space-md">
                    @foreach([
                        ['icon'=>'home','title'=>'Beranda Publik','content'=>'Kunjungi halaman beranda untuk melihat ringkasan statistik pengawasan pangan — jumlah sampel, sarana yang diperiksa, dan tingkat kepatuhan produk di Kalimantan Tengah secara real-time.'],
                        ['icon'=>'science','title'=>'Cek Hasil Pengujian Produk','content'=>'Gunakan menu "Hasil Pengawasan" untuk melihat daftar lengkap produk pangan yang telah diuji oleh laboratorium BBPOM. Anda dapat melihat status keamanan produk (MS = Memenuhi Syarat / TMS = Tidak Memenuhi Syarat).'],
                        ['icon'=>'search','title'=>'Cari Produk atau Sarana','content'=>'Gunakan fitur "Cari Produk & Sarana" untuk mencari berdasarkan nama merek produk atau nama sarana usaha pangan yang telah terdata dalam pengawasan BBPOM Palangka Raya.'],
                        ['icon'=>'qr_code_scanner','title'=>'Validasi Keaslian BAP','content'=>'Jika Anda menerima salinan Berita Acara Pemeriksaan (BAP), verifikasi keasliannya dengan scan QR Code atau memasukkan kode token di halaman Validasi BAP. Dokumen palsu dapat dikenali jika token tidak terverifikasi.'],
                        ['icon'=>'shield','title'=>'Informasi yang Dilindungi','content'=>'Data pribadi pelaku usaha seperti NIB, NPWP, kontak, serta rincian CAPA tidak ditampilkan kepada publik sesuai UU Keterbukaan Informasi Publik dan UU Perlindungan Data Pribadi.'],
                    ] as $item)
                    <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm">
                        <div class="flex items-start gap-space-md">
                            <div class="w-10 h-10 rounded-lg bg-primary-fixed text-primary-container flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[22px]">{{ $item['icon'] }}</span>
                            </div>
                            <div>
                                <h3 class="font-title-sm text-title-sm text-on-surface font-semibold mb-1">{{ $item['title'] }}</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">{{ $item['content'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Pelaku Usaha --}}
            @if($activeSection === 'pelaku-usaha')
            <div wire:key="guide-pelaku-usaha">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-space-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-[28px]">storefront</span>
                    Panduan untuk Pelaku Usaha
                </h2>
                <div class="space-y-space-md">
                    @foreach([
                        ['step'=>'01','title'=>'Daftar & Login ke Portal','content'=>'Hubungi BBPOM Palangka Raya untuk mendapatkan akun pelaku usaha. Login melalui tombol "Masuk Pelaku Usaha" di pojok kanan atas atau kunjungi /portal.','icon'=>'login'],
                        ['step'=>'02','title'=>'Lihat Hasil Inspeksi & Temuan','content'=>'Setelah login, Anda dapat melihat hasil inspeksi sarana Anda beserta daftar temuan ketidaksesuaian yang harus ditindaklanjuti.','icon'=>'list_alt'],
                        ['step'=>'03','title'=>'Unduh Dokumen BAP','content'=>'Setelah pemeriksaan selesai, Berita Acara Pemeriksaan (BAP) akan otomatis tersedia di akun Anda dalam format PDF lengkap dengan QR Code verifikasi.','icon'=>'download'],
                        ['step'=>'04','title'=>'Kirim CAPA (Tindak Lanjut)','content'=>'Untuk setiap temuan, Anda wajib mengisi Corrective Action and Preventive Action (CAPA). Unggah bukti dokumen tindakan perbaikan dan kirim melalui portal.','icon'=>'edit_note'],
                        ['step'=>'05','title'=>'Pantau Status Evaluasi','content'=>'BBPOM akan mengevaluasi CAPA yang Anda kirimkan. Pantau statusnya di dashboard portal — apakah Accepted, Rejected, atau sudah Closed.','icon'=>'track_changes'],
                        ['step'=>'06','title'=>'Terima Surat Closed CAPA','content'=>'Setelah seluruh temuan dinyatakan selesai dan disahkan Kepala Balai, surat Closed CAPA resmi akan dikirim ke akun portal dan email Anda.','icon'=>'mail'],
                    ] as $item)
                    <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm flex items-start gap-space-md">
                        <div class="flex flex-col items-center shrink-0">
                            <div class="w-10 h-10 rounded-lg bg-secondary-fixed text-secondary flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">{{ $item['icon'] }}</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-secondary font-bold mt-1">{{ $item['step'] }}</span>
                        </div>
                        <div>
                            <h3 class="font-title-sm text-title-sm text-on-surface font-semibold mb-1">{{ $item['title'] }}</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">{{ $item['content'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Validasi BAP --}}
            @if($activeSection === 'validasi-bap')
            <div wire:key="guide-validasi">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-space-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[28px]">qr_code_scanner</span>
                    Panduan Validasi BAP
                </h2>
                <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg mb-space-lg">
                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-space-lg">
                        Setiap Berita Acara Pemeriksaan (BAP) yang diterbitkan oleh BBPOM Palangka Raya memiliki QR Code unik yang dapat diverifikasi keasliannya melalui sistem Si Kahayan.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-md mb-space-lg">
                        @foreach([
                            ['icon'=>'qr_code_2','step'=>'1','title'=>'Temukan QR Code','desc'=>'QR Code terdapat di pojok kanan bawah dokumen BAP, baik pada versi cetak maupun digital (PDF).'],
                            ['icon'=>'content_paste','step'=>'2','title'=>'Masukkan Token','desc'=>'Scan QR dengan kamera smartphone atau salin kode token yang tertera di bawah QR Code, lalu tempel di kolom input.'],
                            ['icon'=>'verified','step'=>'3','title'=>'Cek Hasilnya','desc'=>'Sistem akan menampilkan status: Terverifikasi (dokumen sah) atau Tidak Ditemukan (dokumen tidak valid/palsu).'],
                        ] as $step)
                        <div class="text-center p-space-md rounded-lg bg-surface-container-low">
                            <div class="w-10 h-10 rounded-full bg-primary-fixed text-primary-container flex items-center justify-center mx-auto mb-space-sm">
                                <span class="material-symbols-outlined text-[22px]">{{ $step['icon'] }}</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-primary font-bold uppercase">Langkah {{ $step['step'] }}</span>
                            <p class="font-title-sm text-title-sm text-on-surface font-semibold mt-1 mb-1">{{ $step['title'] }}</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $step['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('publik.validasi-bap') }}"
                       class="inline-flex items-center gap-space-xs px-space-lg py-space-sm rounded-lg bg-primary-container hover:bg-primary text-on-primary font-label-md text-label-md transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">qr_code_scanner</span>
                        <span>Mulai Validasi BAP</span>
                    </a>
                </div>
            </div>
            @endif

            {{-- Portal --}}
            @if($activeSection === 'portal')
            <div wire:key="guide-portal">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-space-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-tertiary-container text-[28px]">login</span>
                    Panduan Portal Pelaku Usaha
                </h2>
                <div class="space-y-space-md">
                    <div class="bg-surface-container-lowest rounded-xl p-space-lg shadow-sm">
                        <h3 class="font-title-sm text-title-sm text-on-surface font-semibold mb-space-md">Fitur Portal Pelaku Usaha</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md">
                            @foreach([
                                ['icon'=>'dashboard','label'=>'Dashboard Status CAPA','desc'=>'Ringkasan semua temuan dan status tindak lanjut sarana Anda.'],
                                ['icon'=>'list_alt','label'=>'Daftar Temuan & Inspeksi','desc'=>'Detail temuan per inspeksi dan rekomendasi perbaikan dari petugas.'],
                                ['icon'=>'upload_file','label'=>'Kirim CAPA','desc'=>'Unggah dokumen bukti tindakan perbaikan dan pencegahan.'],
                                ['icon'=>'description','label'=>'Unduh Dokumen','desc'=>'Akses BAP, surat tindak lanjut, dan surat Closed CAPA resmi.'],
                            ] as $f)
                            <div class="flex items-start gap-space-sm p-space-md rounded-lg bg-surface-container-low">
                                <span class="material-symbols-outlined text-primary-container text-[20px] shrink-0">{{ $f['icon'] }}</span>
                                <div>
                                    <p class="font-label-md text-label-md text-on-surface">{{ $f['label'] }}</p>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $f['desc'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-space-md flex items-start gap-space-md">
                        <span class="material-symbols-outlined text-secondary text-[22px] shrink-0">info</span>
                        <div>
                            <p class="font-title-sm text-title-sm text-on-surface font-semibold mb-1">Cara Mendapatkan Akun</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Akun portal pelaku usaha dibuat oleh petugas BBPOM Palangka Raya setelah proses pemeriksaan sarana Anda. Hubungi BBPOM untuk informasi lebih lanjut di <span class="font-label-md text-label-md text-primary">Halo BPOM 1500533</span>.</p>
                        </div>
                    </div>
                    <div class="text-center pt-space-md">
                        <a href="{{ route('portal.login') }}"
                           class="inline-flex items-center gap-space-xs px-space-xl py-space-sm rounded-lg bg-secondary hover:bg-on-secondary-fixed-variant text-on-secondary font-label-md text-label-md transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">login</span>
                            <span>Masuk ke Portal Pelaku Usaha</span>
                        </a>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Contact Box --}}
    <div class="mt-space-xl rounded-xl bg-primary-container p-space-lg text-on-primary flex flex-col sm:flex-row items-center justify-between gap-space-lg shadow-sm">
        <div>
            <h3 class="font-title-sm text-title-sm font-semibold mb-1">Butuh Bantuan Lebih Lanjut?</h3>
            <p class="font-body-sm text-body-sm opacity-90">Hubungi tim BBPOM Palangka Raya untuk pertanyaan teknis dan layanan pengaduan.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-space-sm shrink-0">
            <a href="tel:1500533"
               class="inline-flex items-center gap-space-xs px-space-lg py-space-sm rounded-lg bg-surface-container-lowest text-primary hover:bg-surface-container font-label-md text-label-md transition-colors">
                <span class="material-symbols-outlined text-[18px]">call</span>
                Halo BPOM 1500533
            </a>
            <a href="mailto:bapom_palangkaraya@pom.go.id"
               class="inline-flex items-center gap-space-xs px-space-lg py-space-sm rounded-lg bg-on-primary text-on-primary-container hover:bg-on-primary/90 font-label-md text-label-md transition-colors">
                <span class="material-symbols-outlined text-[18px]">mail</span>
                Kirim Email
            </a>
        </div>
    </div>

</div>
</div>
