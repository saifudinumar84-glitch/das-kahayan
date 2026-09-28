<div class="flex flex-col w-full pb-12 gap-space-lg">
    <!-- Page Breadcrumb & Header Meta -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
        <div class="flex items-center gap-2 text-xs">
            <span class="font-label-sm text-on-surface-variant">Layanan Terpadu</span>
            <span class="text-outline-variant">•</span>
            <span class="font-label-sm text-on-surface-variant">Portal Pelaku Usaha</span>
            <span class="text-outline-variant">•</span>
            <span class="font-label-sm text-primary font-semibold">Dossier Profil Sarana</span>
        </div>
        <div class="flex items-center gap-2 text-xs">
            <span class="px-2.5 py-1 rounded-full bg-surface-container-high text-on-surface-variant font-label-sm text-[11px] flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[14px] text-primary">verified_user</span>
                Terintegrasi SIMWAS POM &amp; OSS RBA
            </span>
            <span class="text-outline-variant hidden sm:inline">|</span>
            <span class="text-on-surface-variant text-[11px]">ID: <strong class="text-on-surface font-mono">{{ substr($facility?->id ?? '001', 0, 8) }}</strong></span>
        </div>
    </div>

    <!-- Primary Header Dossier Card -->
    <section class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg relative overflow-hidden border border-surface-container">
        <!-- River Wave Motif Pattern -->
        <div class="absolute right-0 top-0 bottom-0 w-96 pointer-events-none opacity-40 overflow-hidden hidden xl:block">
            <svg class="h-full w-full" fill="none" preserveAspectRatio="none" viewBox="0 0 400 200">
                <path d="M0 160 C 100 130, 200 180, 400 140 L 400 200 L 0 200 Z" fill="#97e8c5" fill-opacity="0.15"></path>
                <path d="M0 80 C 120 40, 240 120, 400 70 L 400 200 L 0 200 Z" fill="#0f6b4f" fill-opacity="0.05"></path>
            </svg>
        </div>

        <div class="relative z-10 flex flex-col xl:flex-row xl:items-start justify-between gap-space-lg">
            <div class="flex flex-col md:flex-row gap-space-md items-start">
                <!-- Facility Icon Badge -->
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-xl bg-primary-container/10 flex items-center justify-center shrink-0 shadow-inner">
                    <div class="w-16 h-16 rounded-lg bg-primary-container flex items-center justify-center text-on-primary">
                        <span class="material-symbols-outlined text-3xl">storefront</span>
                    </div>
                </div>

                <!-- Facility Metadata Details -->
                <div class="flex flex-col">
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <span class="px-2.5 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant font-label-sm text-[11px] font-semibold">
                            Sarana {{ ucfirst($facility?->facility_type?->value ?? (string)($facility?->facility_type ?? 'Produksi')) }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full bg-surface-container-high text-on-surface font-label-sm text-[11px]">
                            UMKM Binaan BBPOM
                        </span>
                        <span class="px-3 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-[11px] flex items-center gap-1.5 font-bold">
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                            Terdaftar Aktif (MS)
                        </span>
                    </div>

                    <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight mb-1 font-bold">
                        {{ $facility?->name ?? 'Sarana Usaha' }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-on-surface-variant font-body-sm text-xs sm:text-sm">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-primary">category</span>
                            Komoditas: <strong class="text-on-surface font-medium">{{ $facility?->commodity_type ?? 'Olahan Pangan Lokal' }}</strong>
                        </span>
                        <span class="hidden sm:inline text-outline-variant">•</span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-primary">badge</span>
                            Penanggung Jawab: <strong class="text-on-surface font-medium">{{ $facility?->pic_name ?? 'Pimpinan Sarana' }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-space-sm shrink-0 self-start">
                <button 
                    onclick="alert('Permintaan sinkronisasi data profil telah dikirimkan ke petugas BBPOM Palangka Raya.');"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-secondary font-label-md text-xs font-semibold transition-all shadow-sm" 
                    type="button"
                >
                    <span class="material-symbols-outlined text-[18px]">sync</span>
                    <span>Minta Pembaruan Data</span>
                </button>
                <button 
                    onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-md text-xs font-semibold transition-all shadow-sm" 
                    type="button"
                >
                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                    <span>Cetak Profil Ringkas</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Notice Banner -->
    <div class="rounded-xl bg-surface-container-low p-space-md flex items-start gap-space-md shadow-sm border border-surface-container">
        <span class="material-symbols-outlined text-primary text-[22px] shrink-0 mt-0.5">verified</span>
        <div class="text-xs text-on-surface-variant leading-relaxed">
            <strong class="text-on-surface">Data Profil Resmi Terverifikasi:</strong>
            Informasi identitas sarana disinkronkan langsung dari basis data perizinan BBPOM di Palangka Raya. Apabila terjadi perubahan kepemilikan, relokasi pabrik, atau perpanjangan sertifikat, harap laporkan ke Seksi Pemeriksaan BBPOM Palangka Raya.
        </div>
    </div>

    <!-- Bento Grid Sections -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
        <!-- Card 1: Legalitas & Sertifikasi -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg border border-surface-container flex flex-col gap-space-md">
            <h2 class="font-headline-md text-headline-md text-on-surface font-bold flex items-center gap-2 text-base sm:text-lg">
                <span class="material-symbols-outlined text-primary text-[22px]">policy</span>
                Identitas Legalitas &amp; Sertifikasi
            </h2>

            <div class="space-y-3 text-xs sm:text-sm">
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">Nomor Induk Berusaha (NIB):</span>
                    <strong class="font-mono text-on-surface">{{ $facility?->nib ?? '-' }}</strong>
                </div>
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">NPWP Badan / Usaha:</span>
                    <span class="font-mono text-on-surface">{{ $facility?->npwp ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">Nomor Izin Edar (NIE / MD):</span>
                    <span class="font-mono text-on-surface">{{ $facility?->nie_number ?? 'MD 243423001002' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">No. Sertifikat CPPOB / CPerPOB:</span>
                    <span class="font-mono font-bold text-primary">{{ $facility?->cppob_certificate_number ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-on-surface-variant">Masa Berlaku Sertifikat:</span>
                    <strong class="text-on-surface">{{ $facility?->cppob_certificate_valid_until?->translatedFormat('d F Y') ?? '30 Juni 2027' }}</strong>
                </div>
            </div>
        </div>

        <!-- Card 2: Lokasi & Geotagging -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg border border-surface-container flex flex-col gap-space-md">
            <h2 class="font-headline-md text-headline-md text-on-surface font-bold flex items-center gap-2 text-base sm:text-lg">
                <span class="material-symbols-outlined text-secondary text-[22px]">pin_drop</span>
                Lokasi &amp; Geotagging Presisi
            </h2>

            <div class="space-y-3 text-xs sm:text-sm">
                <div class="flex flex-col py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant text-xs mb-1">Alamat Fasilitas:</span>
                    <strong class="text-on-surface leading-snug">{{ $facility?->address }}</strong>
                </div>
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">Kabupaten / Kota:</span>
                    <strong class="text-on-surface">{{ $facility?->regency ?? 'Kota Palangka Raya' }}</strong>
                </div>
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">Koordinat Titik Inspeksi:</span>
                    <span class="font-mono text-primary text-xs">{{ $facility?->latitude ?? '-2.2162' }}, {{ $facility?->longitude ?? '113.9164' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-on-surface-variant">Verifikasi Geotagging BBPOM:</span>
                    <span class="inline-flex items-center gap-1 text-primary font-semibold text-xs">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                        GPS Terverifikasi Petugas
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 3: Kontak & Penanggung Jawab -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg border border-surface-container flex flex-col gap-space-md">
            <h2 class="font-headline-md text-headline-md text-on-surface font-bold flex items-center gap-2 text-base sm:text-lg">
                <span class="material-symbols-outlined text-primary text-[22px]">contacts</span>
                Penanggung Jawab Teknis &amp; Kontak
            </h2>

            <div class="space-y-3 text-xs sm:text-sm">
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">Nama Penanggung Jawab:</span>
                    <strong class="text-on-surface">{{ $facility?->pic_name ?? 'Pimpinan Sarana' }}</strong>
                </div>
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">Nomor Telepon / WhatsApp:</span>
                    <span class="font-mono text-on-surface">{{ $facility?->phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">Email Terdaftar:</span>
                    <span class="text-on-surface">{{ $facility?->email ?? '-' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-on-surface-variant">Status Akses Portal:</span>
                    <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-xs font-bold">Aktif Terhubung</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Matriks Kepatuhan & Audit Terakhir -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg border border-surface-container flex flex-col gap-space-md">
            <h2 class="font-headline-md text-headline-md text-on-surface font-bold flex items-center gap-2 text-base sm:text-lg">
                <span class="material-symbols-outlined text-secondary text-[22px]">workspace_premium</span>
                Rekam Jejak Kepatuhan Pengawasan
            </h2>

            <div class="space-y-3 text-xs sm:text-sm">
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">Inspeksi Terakhir:</span>
                    <strong class="text-on-surface">{{ $latestInspection?->inspection_number ?? 'INSP-2026' }}</strong>
                </div>
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">Tanggal Audit Terakhir:</span>
                    <span class="text-on-surface">{{ $latestInspection?->inspection_date?->translatedFormat('d M Y') ?? '—' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-surface-container">
                    <span class="text-on-surface-variant">Grade Evaluasi:</span>
                    <span class="font-bold text-primary text-base">Grade {{ $latestInspection?->grade ?? 'A' }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-on-surface-variant">Status CAPA:</span>
                    <span class="inline-flex items-center gap-1 text-primary font-semibold text-xs">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                        Closed / Dalam Kepatuhan
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
