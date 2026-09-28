<div class="flex flex-col w-full pb-12">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col gap-space-sm mb-space-lg">
        <nav class="flex items-center gap-space-xs font-label-sm text-on-surface-variant flex-wrap text-xs">
            <a href="{{ route('portal.dashboard') }}" class="hover:text-primary transition-colors">Portal Pelaku Usaha</a>
            <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
            <a href="{{ route('portal.temuan-capa') }}" class="hover:text-primary transition-colors">Temuan &amp; CAPA</a>
            <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
            <span class="font-semibold text-on-surface">{{ $finding?->inspection?->inspection_number ?? 'BAP' }}</span>
            <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
            <span class="text-primary font-semibold">Formulir Tindak Lanjut</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md pt-space-xs">
            <div class="flex items-start gap-space-md">
                <a 
                    href="{{ route('portal.temuan-capa') }}" 
                    class="p-2 rounded-lg bg-surface-container-lowest shadow-sm text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all flex items-center justify-center mt-1 border border-surface-container" 
                    title="Kembali ke Daftar Temuan"
                >
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                </a>
                <div class="flex flex-col">
                    <div class="flex items-center gap-space-sm flex-wrap">
                        <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight font-bold">Tindak Lanjut &amp; Pengajuan Bukti CAPA</h1>
                        @if($finding?->status === 'closed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span> Closed CAPA
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-error-container text-on-error-container font-label-sm text-xs font-semibold">
                                <span class="w-2 h-2 rounded-full bg-error animate-pulse"></span> Perlu Tindak Lanjut
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-space-md text-on-surface-variant font-body-sm mt-1 flex-wrap text-xs">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-primary">description</span>
                            No. BAP: <strong class="text-on-surface">{{ $finding?->inspection?->inspection_number }}</strong>
                        </span>
                        <span class="text-outline-variant">•</span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-primary">event</span>
                            Inspeksi: {{ $finding?->inspection?->inspection_date?->translatedFormat('d M Y') ?? '—' }}
                        </span>
                        <span class="text-outline-variant">•</span>
                        <span class="flex items-center gap-1 text-error font-medium">
                            <span class="material-symbols-outlined text-[16px]">schedule</span>
                            Batas Akhir: {{ $finding?->due_date?->translatedFormat('d F Y') ?? '30 Hari Sejak BAP' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-space-sm">
                <a 
                    href="{{ route('portal.dokumen') }}" 
                    class="px-4 py-2 rounded-lg bg-surface-container-lowest text-on-surface font-label-md text-xs shadow-sm hover:bg-surface-container transition-all flex items-center gap-2 border border-surface-container"
                >
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    <span>Unduh Salinan BAP</span>
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN 2-COLUMN LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
        <!-- LEFT COLUMN: 8/12 cols -->
        <div class="lg:col-span-8 flex flex-col gap-space-lg">
            <!-- CARD A: RINGKASAN TEMUAN PENGAWASAN -->
            <section class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden flex flex-col border border-surface-container">
                <div class="h-1.5 w-full {{ $finding?->status === 'closed' ? 'bg-primary' : 'bg-error' }}"></div>
                <div class="p-space-lg flex flex-col gap-space-md">
                    <div class="flex items-start justify-between gap-space-md flex-wrap">
                        <div class="flex items-center gap-space-sm">
                            <div class="w-10 h-10 rounded-lg {{ $finding?->status === 'closed' ? 'bg-primary-fixed text-primary' : 'bg-error-container/60 text-on-error-container' }} flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">
                                    {{ $finding?->status === 'closed' ? 'check_circle' : 'warning' }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full {{ $finding?->status === 'closed' ? 'bg-primary-fixed text-on-primary-fixed-variant' : 'bg-error text-on-error' }} font-label-sm text-[11px] uppercase font-bold tracking-wide">
                                        {{ $finding?->status === 'closed' ? 'Status Closed' : 'Temuan Inspeksi' }}
                                    </span>
                                    <span class="font-label-sm text-label-sm text-on-surface-variant text-xs">
                                        Standar: {{ strtoupper($finding?->standard?->value ?? (string)($finding?->standard ?? 'CPPOB')) }}
                                    </span>
                                </div>
                                <h2 class="font-headline-md text-headline-md text-on-surface mt-0.5 font-bold">
                                    {{ $finding?->requirement?->title ?? 'Ketidaksesuaian Fasilitas & Operasional' }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    <!-- Description Box -->
                    <div class="bg-surface-container-low p-space-md rounded-lg flex flex-col gap-space-xs border border-surface-container">
                        <span class="font-label-sm uppercase tracking-wider text-on-surface-variant flex items-center gap-1 text-xs font-semibold">
                            <span class="material-symbols-outlined text-[16px] text-primary">fact_check</span>
                            Uraian Ketidaksesuaian oleh Petugas BBPOM
                        </span>
                        <p class="font-body-md text-body-md text-on-surface leading-relaxed mt-1 text-sm">
                            {{ $finding?->description }}
                        </p>
                    </div>

                    <!-- Recommendation Box -->
                    <div class="bg-primary/5 p-space-md rounded-lg flex flex-col gap-space-xs border border-primary/10">
                        <span class="font-label-sm uppercase tracking-wider text-primary flex items-center gap-1 font-semibold text-xs">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            Rekomendasi Tindakan Koreksi Standar BPOM
                        </span>
                        <p class="font-body-sm text-body-sm text-on-surface leading-relaxed mt-1">
                            {{ $finding?->recommendation }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- CARD B: FORMULIR SUBMISSION TINDAK LANJUT CAPA -->
            <section class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden flex flex-col border border-surface-container">
                <div class="p-space-lg flex flex-col gap-space-md">
                    <div class="flex items-center justify-between border-b border-surface-container pb-space-sm">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[24px]">edit_note</span>
                            <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Formulir Laporan CAPA Pelaku Usaha</h2>
                        </div>
                        <span class="text-xs text-on-surface-variant">Ronde Pengajuan ke-{{ ($finding?->capaSubmissions()->max('round') ?? 0) + 1 }}</span>
                    </div>

                    <!-- Success Message -->
                    @if($isSubmittedSuccessfully)
                    <div class="p-4 rounded-xl bg-primary-fixed text-on-primary-fixed-variant border border-primary/20 flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-[24px] shrink-0 mt-0.5">check_circle</span>
                        <div>
                            <h3 class="font-bold text-sm">Laporan CAPA Berhasil Dikirimkan!</h3>
                            <p class="text-xs mt-1 leading-relaxed">
                                Dokumen perbaikan dan bukti eviden Anda telah masuk ke antrean evaluasi auditor BBPOM di Palangka Raya. Anda akan menerima notifikasi hasil verifikasi maksimal dalam 5 hari kerja.
                            </p>
                            <button 
                                wire:click="resetForm" 
                                class="mt-2 text-xs font-semibold text-primary underline"
                            >
                                Kirim pembaruan tambahan jika diperlukan
                            </button>
                        </div>
                    </div>
                    @endif

                    @if($finding?->status === 'closed')
                    <div class="p-4 rounded-xl bg-surface-container-low text-on-surface border border-surface-container flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary text-[24px]">task_alt</span>
                        <p class="text-sm">Temuan ini telah dinyatakan <strong>Closed (Selesai)</strong> oleh tim pengawas BBPOM di Palangka Raya.</p>
                    </div>
                    @else
                    <form wire:submit.prevent="submit" class="space-y-space-md">
                        <!-- Root Cause -->
                        <div class="space-y-1.5">
                            <label class="block font-label-md text-label-md text-on-surface font-semibold text-xs sm:text-sm">
                                1. Analisis Akar Masalah (Root Cause Analysis / 5-Why)
                            </label>
                            <textarea 
                                wire:model.defer="rootCause"
                                rows="3"
                                placeholder="Jelaskan faktor mendasar mengapa ketidaksesuaian terjadi (misalnya: ketiadaan SOP pengadaan alat sanitasi, minimnya pelatihan karyawan, atau kelalaian pemeliharaan sarana)..."
                                class="w-full p-3 rounded-lg bg-surface text-on-surface font-body-sm text-xs sm:text-sm border border-surface-container focus:outline-none focus:ring-2 focus:ring-primary/20 placeholder:text-outline"
                            ></textarea>
                            <span class="text-[11px] text-on-surface-variant block">Gunakan analisis metode 5-Why agar tindakan pencegahan tepat sasaran.</span>
                        </div>

                        <!-- Corrective Action -->
                        <div class="space-y-1.5">
                            <label class="block font-label-md text-label-md text-on-surface font-semibold text-xs sm:text-sm">
                                2. Tindakan Koreksi yang Telah Dilakukan (Corrective Action) <span class="text-error">*</span>
                            </label>
                            <textarea 
                                wire:model.defer="correctiveAction"
                                rows="4"
                                placeholder="Uraikan perbaikan fisik/langsung yang telah diselesaikan di sarana (misalnya: pemasangan dispenser sabun cair otomatis, penggantian kasa anti-serangga stainless, pemisahan area baku vs matang)..."
                                class="w-full p-3 rounded-lg bg-surface text-on-surface font-body-sm text-xs sm:text-sm border border-surface-container focus:outline-none focus:ring-2 focus:ring-primary/20 placeholder:text-outline"
                                required
                            ></textarea>
                            @error('correctiveAction') <span class="text-xs text-error font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Preventive Action -->
                        <div class="space-y-1.5">
                            <label class="block font-label-md text-label-md text-on-surface font-semibold text-xs sm:text-sm">
                                3. Tindakan Pencegahan Berulang (Preventive Action) <span class="text-error">*</span>
                            </label>
                            <textarea 
                                wire:model.defer="preventiveAction"
                                rows="4"
                                placeholder="Uraikan mekanisme sistemik agar ketidaksesuaian tidak terulang (misalnya: penerbitan SOP checklist sanitasi harian, penunjukan supervisor monitoring, agenda pelatihan berkala)..."
                                class="w-full p-3 rounded-lg bg-surface text-on-surface font-body-sm text-xs sm:text-sm border border-surface-container focus:outline-none focus:ring-2 focus:ring-primary/20 placeholder:text-outline"
                                required
                            ></textarea>
                            @error('preventiveAction') <span class="text-xs text-error font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- File Upload Evidence -->
                        <div class="space-y-1.5">
                            <label class="block font-label-md text-label-md text-on-surface font-semibold text-xs sm:text-sm">
                                4. Unggah Bukti Eviden (Foto Before-After / Dokumen SOP / Invoice)
                            </label>
                            <div class="p-4 rounded-xl border-2 border-dashed border-surface-container hover:border-primary/40 bg-surface-container-low/40 text-center transition-colors">
                                <span class="material-symbols-outlined text-3xl text-primary mb-1">cloud_upload</span>
                                <div class="flex items-center justify-center gap-1 text-xs text-on-surface">
                                    <label class="font-bold text-primary hover:underline cursor-pointer">
                                        Pilih Berkas
                                        <input wire:model="attachmentFile" type="file" class="hidden" accept="image/*,.pdf,.doc,.docx"/>
                                    </label>
                                    <span>atau tarik berkas ke sini</span>
                                </div>
                                <span class="text-[11px] text-on-surface-variant block mt-1">Format: JPG, PNG, PDF (Maks. 10 MB)</span>

                                <div wire:loading wire:target="attachmentFile" class="text-xs text-primary font-semibold mt-2">
                                    Mengunggah berkas eviden...
                                </div>

                                @if($attachmentFile)
                                <div class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-surface-container text-xs text-on-surface font-semibold">
                                    <span class="material-symbols-outlined text-[16px] text-primary">attach_file</span>
                                    <span>{{ $attachmentFile->getClientOriginalName() }}</span>
                                </div>
                                @endif
                            </div>
                            @error('attachmentFile') <span class="text-xs text-error font-medium">{{ $message }}</span> @enderror

                            <!-- Optional Caption -->
                            <input 
                                wire:model.defer="attachmentCaption"
                                type="text"
                                placeholder="Keterangan singkat berkas (opsional, cth: Foto dispenser sabun dan tempat sampah baru)"
                                class="w-full mt-2 p-2 rounded-lg bg-surface text-on-surface text-xs border border-surface-container"
                            />
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 flex items-center justify-end gap-3 border-t border-surface-container">
                            <a 
                                href="{{ route('portal.temuan-capa') }}" 
                                class="px-4 py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md text-xs transition-colors"
                            >
                                Batal
                            </a>
                            <button 
                                type="submit"
                                wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-md text-xs font-semibold shadow-sm transition-all"
                            >
                                <span wire:loading.remove>Kirim Laporan CAPA Resmi</span>
                                <span wire:loading>Menyimpan Dokumen...</span>
                                <span class="material-symbols-outlined text-[18px]">send</span>
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </section>

            <!-- CARD C: RIWAYAT EVALUASI DAN PENGAJUAN SEBELUMNYA -->
            @if($finding?->capaSubmissions->isNotEmpty())
            <section class="bg-surface-container-lowest rounded-xl shadow-sm p-space-lg flex flex-col gap-space-md border border-surface-container">
                <h3 class="font-headline-md text-headline-md text-on-surface font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-[22px]">history</span>
                    Riwayat Pengajuan &amp; Catatan Petugas
                </h3>

                <div class="space-y-4">
                    @foreach($finding->capaSubmissions->sortByDesc('round') as $sub)
                    <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-xs text-primary">Ronde {{ $sub->round }} • {{ $sub->submitted_at?->translatedFormat('d F Y, H:i') }} WIB</span>
                            @if($sub->status->value === 'accepted')
                                <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed-variant text-[11px] font-bold">Disetujui Petugas</span>
                            @elseif($sub->status->value === 'revision')
                                <span class="px-2 py-0.5 rounded-full bg-error-container text-on-error-container text-[11px] font-bold">Perlu Perbaikan</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface text-[11px]">Sedang Ditinjau</span>
                            @endif
                        </div>

                        <div class="text-xs text-on-surface space-y-1 mt-1">
                            <div><strong>Tindakan Koreksi:</strong> {{ $sub->corrective_action }}</div>
                            <div><strong>Tindakan Pencegahan:</strong> {{ $sub->preventive_action }}</div>
                        </div>

                        @if($sub->review_notes)
                        <div class="mt-2 p-2.5 rounded-lg bg-surface-container-lowest border-l-2 border-secondary text-xs text-on-surface">
                            <strong class="text-secondary block mb-0.5">Catatan Verifikasi Auditor BBPOM:</strong>
                            {{ $sub->review_notes }}
                            <span class="text-[10px] text-on-surface-variant block mt-1">Diverifikasi pada: {{ $sub->reviewed_at?->translatedFormat('d M Y') }}</span>
                        </div>
                        @endif

                        @if($sub->attachments->isNotEmpty())
                        <div class="mt-2 flex flex-wrap gap-2 pt-1 border-t border-surface-container">
                            @foreach($sub->attachments as $att)
                            <a 
                                href="{{ asset('storage/'.$att->file_path) }}" 
                                target="_blank"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-surface-container-lowest text-[11px] text-primary hover:underline border border-surface-container"
                            >
                                <span class="material-symbols-outlined text-[14px]">attach_file</span>
                                <span>{{ $att->file_name }}</span>
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </section>
            @endif
        </div>

        <!-- RIGHT COLUMN: 4/12 cols -->
        <div class="lg:col-span-4 flex flex-col gap-space-lg">
            <!-- Dossier Info Sidebar -->
            <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-md border border-surface-container flex flex-col gap-space-sm">
                <h3 class="font-headline-md text-headline-md text-on-surface font-bold flex items-center gap-1.5 text-sm sm:text-base">
                    <span class="material-symbols-outlined text-primary text-[20px]">info</span>
                    Detail Dokumen Pemeriksaan
                </h3>

                <div class="space-y-2.5 text-xs text-on-surface pt-2">
                    <div class="flex justify-between py-1 border-b border-surface-container">
                        <span class="text-on-surface-variant">Sarana:</span>
                        <strong class="text-right">{{ $finding?->inspection?->facility?->name }}</strong>
                    </div>
                    <div class="flex justify-between py-1 border-b border-surface-container">
                        <span class="text-on-surface-variant">Nomor BAP:</span>
                        <strong class="text-right">{{ $finding?->inspection?->inspection_number }}</strong>
                    </div>
                    <div class="flex justify-between py-1 border-b border-surface-container">
                        <span class="text-on-surface-variant">Tanggal Inspeksi:</span>
                        <span>{{ $finding?->inspection?->inspection_date?->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-surface-container">
                        <span class="text-on-surface-variant">Batas Regulasi:</span>
                        <span class="text-error font-bold">{{ $finding?->due_date?->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-surface-container">
                        <span class="text-on-surface-variant">SLA Evaluasi Balai:</span>
                        <span>Maks. 5 Hari Kerja</span>
                    </div>
                </div>
            </div>

            <!-- Guidelines Sidebar -->
            <div class="bg-surface-container-lowest rounded-xl shadow-sm p-space-md border border-surface-container flex flex-col gap-space-sm">
                <h3 class="font-headline-md text-headline-md text-on-surface font-bold flex items-center gap-1.5 text-sm sm:text-base">
                    <span class="material-symbols-outlined text-secondary text-[20px]">checklist</span>
                    Kriteria Kelayakan Bukti Eviden
                </h3>
                <div class="space-y-2 text-xs text-on-surface-variant">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[16px] text-primary shrink-0 mt-0.5">check_circle</span>
                        <span>Foto komparatif kondisi sebelum (temuan) vs kondisi setelah perbaikan.</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[16px] text-primary shrink-0 mt-0.5">check_circle</span>
                        <span>Dokumen SOP atau instruksi kerja bertandatangan pimpinan sarana.</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[16px] text-primary shrink-0 mt-0.5">check_circle</span>
                        <span>Bukti pengadaan sarana/peralatan (faktur/nota pembelian).</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[16px] text-primary shrink-0 mt-0.5">check_circle</span>
                        <span>Daftar hadir sosialisasi/briefing internal kepada pekerja.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
