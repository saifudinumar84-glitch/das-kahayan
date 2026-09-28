<div class="w-full max-w-[1280px] mx-auto px-gutter-mobile lg:px-margin py-space-md lg:py-space-xl flex flex-col justify-center min-h-[calc(100vh-8rem)]">
    <!-- Breadcrumb Indicator Bar -->
    <div class="flex items-center justify-between mb-space-md text-on-surface-variant">
        <div class="flex items-center gap-space-xs">
            <span class="inline-flex items-center justify-center w-2 h-2 rounded-full bg-primary animate-pulse"></span>
            <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold">Sistem Masuk Terintegrasi</span>
            <span class="font-label-sm text-label-sm text-outline-variant">/</span>
            <span class="font-label-sm text-label-sm">BBPOM di Palangka Raya</span>
        </div>
        <a class="inline-flex items-center gap-1 font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="{{ route('publik.beranda') }}">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali ke Portal Publik</span>
        </a>
    </div>

    <!-- Main Split-Screen Container -->
    <div class="w-full bg-surface-container-lowest rounded-xl shadow-xl overflow-hidden flex flex-col lg:flex-row border border-surface-container">
        <!-- LEFT HALF: Institutional Brand Panel -->
        <div class="relative w-full lg:w-[48%] bg-gradient-to-br from-primary via-primary-container to-[#073828] text-on-primary p-space-lg lg:p-space-xl flex flex-col justify-between overflow-hidden">
            <!-- Ambient Kahayan River Wave Motif Layer -->
            <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-10" fill="none" preserveaspectratio="none" viewbox="0 0 600 800">
                <path d="M-100 200 C 150 120, 250 320, 650 180 L 650 900 L -100 900 Z" fill="#ffffff"></path>
                <path d="M-80 340 C 180 260, 280 480, 700 310" stroke="#ffffff" stroke-dasharray="6 8" stroke-width="2.5"></path>
                <path d="M-60 480 C 160 410, 300 620, 720 460" stroke="#ffffff" stroke-width="1.8"></path>
                <circle cx="480" cy="180" fill="#a1f3cf" fill-opacity="0.08" r="140"></circle>
                <circle cx="80" cy="620" fill="#72d6d6" fill-opacity="0.06" r="220"></circle>
            </svg>

            <!-- Brand Top Region -->
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-on-primary/10 backdrop-blur-md text-primary-fixed mb-space-md">
                    <span class="material-symbols-outlined text-[16px]">verified_user</span>
                    <span class="font-label-sm text-label-sm font-semibold tracking-wide">Akses Terbatas &amp; Terenkripsi - BBPOM Palangka Raya</span>
                </div>
                <div class="flex items-center gap-3 mb-space-lg">
                    <div class="w-12 h-12 rounded-lg bg-surface-container-lowest/15 backdrop-blur-md flex items-center justify-center p-2">
                        <span class="material-symbols-outlined text-secondary-fixed text-[28px]">shield_lock</span>
                    </div>
                    <div>
                        <div class="font-headline-lg text-headline-lg font-bold text-on-primary tracking-tight leading-none">Si Kahayan</div>
                        <p class="font-label-sm text-label-sm text-primary-fixed mt-1">Portal Evaluasi &amp; Pembinaan Pelaku Usaha Obat dan Makanan</p>
                    </div>
                </div>

                <h1 class="font-headline-xl text-headline-xl font-bold text-on-primary leading-snug mb-space-sm">
                    Pantau dan Tindak Lanjuti Hasil Pengawasan Sarana Anda
                </h1>
                <p class="font-body-md text-body-md text-on-primary-container leading-relaxed">
                    Portal terpadu bagi sarana produksi (CPPOB) dan distribusi di wilayah Kalimantan Tengah untuk percepatan tindak lanjut temuan inspeksi serta perolehan sertifikat rekomendasi resmi.
                </p>

                <!-- 3 Frosted Feature Bullets -->
                <div class="mt-space-lg space-y-space-sm">
                    <div class="flex items-start gap-3 p-3 rounded-lg bg-on-primary/10 backdrop-blur-md">
                        <div class="w-9 h-9 rounded-md bg-secondary-container text-on-secondary-container flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[20px]">assignment_turned_in</span>
                        </div>
                        <div class="min-w-0">
                            <div class="font-title-sm text-title-sm text-on-primary font-semibold">Lihat Temuan &amp; Rekomendasi</div>
                            <p class="font-body-sm text-body-sm text-primary-fixed mt-0.5 leading-normal">
                                Akses lembar hasil pemeriksaan lapangan dan hasil uji lab sampel secara komprehensif dan terstruktur.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-lg bg-on-primary/10 backdrop-blur-md">
                        <div class="w-9 h-9 rounded-md bg-primary-fixed text-on-primary-fixed-variant flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[20px]">cloud_upload</span>
                        </div>
                        <div class="min-w-0">
                            <div class="font-title-sm text-title-sm text-on-primary font-semibold">Kirim CAPA Secara Mandiri</div>
                            <p class="font-body-sm text-body-sm text-primary-fixed mt-0.5 leading-normal">
                                Unggah formulir Corrective &amp; Preventive Action, bukti eviden foto/dokumen perbaikan tanpa harus ke balai.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-lg bg-on-primary/10 backdrop-blur-md">
                        <div class="w-9 h-9 rounded-md bg-secondary-fixed text-on-secondary-fixed-variant flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[20px]">approval_delegation</span>
                        </div>
                        <div class="min-w-0">
                            <div class="font-title-sm text-title-sm text-on-primary font-semibold">Terima BAP &amp; Surat Closed CAPA</div>
                            <p class="font-body-sm text-body-sm text-primary-fixed mt-0.5 leading-normal">
                                Unduh BAP digital dengan barcode verifikasi resmi dan Surat Keterangan Closed CAPA.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Indicator Badge at Bottom of Left Panel -->
            <div class="relative z-10 mt-space-xl pt-space-md bg-on-primary/5 rounded-lg p-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary-fixed text-[18px]">lock</span>
                    <span class="font-label-sm text-label-sm text-on-primary leading-tight font-medium">
                        Terhubung dengan Sistem Pengawasan BBPOM Palangka Raya
                    </span>
                </div>
            </div>
        </div>

        <!-- RIGHT HALF: Authentication Form -->
        <div class="w-full lg:w-[52%] bg-surface-container-lowest p-space-lg lg:p-space-xl flex flex-col justify-between" x-data="{ showPassword: false }">
            <div>
                <!-- Header and Breadcrumb -->
                <div class="flex items-center justify-between mb-space-md">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container font-label-sm text-label-sm text-primary font-semibold">
                        <span class="material-symbols-outlined text-[14px]">domain</span>
                        Area Pelaku Usaha
                    </span>
                    <a class="font-label-md text-label-md text-primary hover:text-on-surface transition-colors flex items-center gap-1" href="{{ route('publik.panduan') }}">
                        <span>Bantuan Teknis</span>
                        <span class="material-symbols-outlined text-[16px]">help_outline</span>
                    </a>
                </div>

                <div class="mb-space-lg">
                    <h2 class="font-headline-lg text-headline-lg font-bold text-on-surface tracking-tight">Masuk Portal</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                        Masukkan akun penanggung jawab sarana yang terdaftar dalam sistem Si Kahayan.
                    </p>
                </div>

                <!-- Error Notification -->
                @if($errorMessage)
                <div class="mb-space-md p-space-sm rounded-lg bg-error-container text-on-error-container">
                    <div class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-error text-[20px] flex-shrink-0 mt-0.5">error</span>
                        <div class="min-w-0 text-sm">
                            <div class="font-label-md text-label-md font-bold text-error">Autentikasi Gagal</div>
                            <div class="font-body-sm text-body-sm text-on-surface leading-normal mt-0.5">
                                {{ $errorMessage }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Demo Quick Fill Accounts (Helper) -->
                @if($demoUsers->isNotEmpty())
                <div class="mb-space-md p-3 rounded-lg bg-surface-container-low border border-surface-container">
                    <span class="font-label-sm text-label-sm text-on-surface-variant font-semibold block mb-1.5 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px] text-primary">key</span>
                        Pilih Akun Demo Sarana Cepat:
                    </span>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($demoUsers as $demo)
                        <button 
                            type="button"
                            wire:click="fillAccount('{{ $demo->email }}')"
                            class="px-2.5 py-1 rounded bg-surface-container hover:bg-primary-container hover:text-on-primary text-[11px] text-on-surface transition-colors"
                        >
                            {{ $demo->name }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Authentication Form -->
                <form wire:submit.prevent="login" class="space-y-space-md">
                    <!-- User / ID Input -->
                    <div class="space-y-1.5">
                        <label class="block font-label-md text-label-md text-on-surface font-semibold" for="userEmail">
                            Email Akun Sarana <span class="text-error">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">badge</span>
                            <input 
                                wire:model.defer="email"
                                class="w-full h-11 pl-10 pr-3 rounded-lg bg-surface text-on-surface font-body-md text-body-md shadow-sm border border-surface-container focus:outline-none focus:ring-2 focus:ring-primary/20 placeholder:text-outline" 
                                id="userEmail" 
                                placeholder="contoh@sarana-usaha.co.id" 
                                required 
                                type="email"
                            />
                        </div>
                        @error('email') <span class="text-xs text-error font-medium">{{ $message }}</span> @enderror
                        <p class="font-body-sm text-body-sm text-on-surface-variant text-xs">Gunakan email yang didaftarkan saat pemeriksaan sarana.</p>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block font-label-md text-label-md text-on-surface font-semibold" for="userPassword">
                                Kata Sandi <span class="text-error">*</span>
                            </label>
                            <span class="font-label-sm text-label-sm text-on-surface-variant text-xs">Default demo: <code>password</code></span>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                            <input 
                                wire:model.defer="password"
                                :type="showPassword ? 'text' : 'password'"
                                class="w-full h-11 pl-10 pr-10 rounded-lg bg-surface text-on-surface font-body-md text-body-md shadow-sm border border-surface-container focus:outline-none focus:ring-2 focus:ring-primary/20 placeholder:text-outline" 
                                id="userPassword" 
                                placeholder="Masukkan kata sandi" 
                                required
                            />
                            <button 
                                type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface"
                            >
                                <span class="material-symbols-outlined text-[20px]" x-text="showPassword ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                        @error('password') <span class="text-xs text-error font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Remember Me & Security Meta -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input 
                                wire:model.defer="remember"
                                class="w-4 h-4 rounded text-primary focus:ring-primary bg-surface border-surface-container" 
                                type="checkbox"
                            />
                            <span class="font-body-sm text-body-sm text-on-surface text-xs sm:text-sm">Ingat saya di perangkat ini</span>
                        </label>
                        <div class="hidden sm:flex items-center gap-1 font-label-sm text-label-sm text-primary text-xs">
                            <span class="material-symbols-outlined text-[16px]">lock_clock</span>
                            <span>Sesi Aman</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button 
                            type="submit"
                            wire:loading.attr="disabled"
                            class="w-full h-11 px-6 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-md text-label-md flex items-center justify-center gap-2 shadow-md transition-all active:scale-[0.99]"
                        >
                            <span wire:loading.remove>Masuk ke Portal Pelaku Usaha</span>
                            <span wire:loading>Memproses Autentikasi...</span>
                            <span class="material-symbols-outlined text-[18px]">login</span>
                        </button>
                    </div>

                    <!-- Security indicator -->
                    <div class="flex items-center justify-center gap-2 py-1 text-on-surface-variant font-label-sm text-label-sm text-xs">
                        <span class="material-symbols-outlined text-primary text-[16px]">verified</span>
                        <span>Sistem Layanan Mandiri BBPOM Palangka Raya</span>
                    </div>
                </form>

                <!-- Informational Notice Box -->
                <div class="mt-space-lg p-space-md rounded-xl bg-surface-container flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="material-symbols-outlined text-[18px]">info</span>
                    </div>
                    <div class="min-w-0">
                        <div class="font-title-sm text-title-sm text-on-surface font-semibold text-xs sm:text-sm">Belum Memiliki Akun Sarana?</div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5 leading-relaxed text-xs">
                            Akun sarana diterbitkan otomatis oleh tim pengawas BBPOM di Palangka Raya pasca-pemeriksaan lapangan. Hubungi kontak resmi kami jika belum menerima kredensial akun.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
