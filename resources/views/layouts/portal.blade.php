<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $title ?? 'Portal Pelaku Usaha — Si Kahayan BBPOM Palangka Raya' }}</title>
    <meta name="description" content="{{ $description ?? 'Sentra Layanan Pengawasan & Tindak Lanjut CAPA Pelaku Usaha BBPOM di Palangka Raya' }}"/>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet"/>

    <style>
        @layer base {
            html, body { margin: 0; padding: 0; }
            body { overscroll-behavior: none; }
            main > :first-child { margin-top: 0 !important; }
            main > :last-child { margin-bottom: 0 !important; }
        }
        ::-webkit-scrollbar { display: none; }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "inverse-surface": "#213145",
                        "on-error-container": "#93000a",
                        "surface-variant": "#d3e4fe",
                        "on-primary-fixed": "#002115",
                        "primary-fixed-dim": "#86d6b4",
                        "inverse-on-surface": "#eaf1ff",
                        "tertiary": "#623f00",
                        "on-tertiary-fixed": "#291800",
                        "on-background": "#0b1c30",
                        "on-surface-variant": "#3f4944",
                        "surface-container-lowest": "#ffffff",
                        "secondary-container": "#8ff3f2",
                        "on-surface": "#0b1c30",
                        "surface-container-low": "#eff4ff",
                        "tertiary-fixed-dim": "#ffb955",
                        "on-primary-container": "#97e8c5",
                        "background": "#f8f9ff",
                        "surface-dim": "#cbdbf5",
                        "on-secondary-fixed": "#002020",
                        "primary-container": "#0f6b4f",
                        "primary": "#00513a",
                        "on-primary-fixed-variant": "#00513a",
                        "surface-tint": "#106b4f",
                        "tertiary-container": "#825400",
                        "inverse-primary": "#86d6b4",
                        "on-primary": "#ffffff",
                        "outline": "#6f7a73",
                        "on-tertiary-fixed-variant": "#633f00",
                        "surface-container-highest": "#d3e4fe",
                        "surface-bright": "#f8f9ff",
                        "error-container": "#ffdad6",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#004f50",
                        "secondary-fixed": "#8ff3f2",
                        "on-secondary": "#ffffff",
                        "surface-container-high": "#dce9ff",
                        "secondary-fixed-dim": "#72d6d6",
                        "on-tertiary-container": "#ffcf92",
                        "surface": "#f8f9ff",
                        "on-secondary-container": "#007070",
                        "primary-fixed": "#a1f3cf",
                        "surface-container": "#e5eeff",
                        "secondary": "#006a6a",
                        "on-error": "#ffffff",
                        "tertiary-fixed": "#ffddb4",
                        "error": "#ba1a1a",
                        "outline-variant": "#bec9c2",
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "space-xs": "0.25rem",
                        "gutter": "1.5rem",
                        "margin-mobile": "1rem",
                        "space-md": "1rem",
                        "margin": "2rem",
                        "space-xl": "2.5rem",
                        "gutter-mobile": "1rem",
                        "space-sm": "0.5rem",
                        "space-lg": "1.5rem"
                    },
                    fontFamily: {
                        "label-md": ["Inter", "sans-serif"],
                        "headline-md": ["Plus Jakarta Sans", "sans-serif"],
                        "body-lg": ["Inter", "sans-serif"],
                        "body-sm": ["Inter", "sans-serif"],
                        "headline-xl": ["Plus Jakarta Sans", "sans-serif"],
                        "title-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "display-lg-mobile": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "label-sm": ["Inter", "sans-serif"],
                        "display-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"]
                    },
                    fontSize: {
                        "label-md": ["0.875rem", { lineHeight: "1.25rem", fontWeight: "600" }],
                        "headline-md": ["1.25rem", { lineHeight: "1.75rem", fontWeight: "600" }],
                        "body-lg": ["1.125rem", { lineHeight: "1.75rem", fontWeight: "400" }],
                        "body-sm": ["0.875rem", { lineHeight: "1.25rem", fontWeight: "400" }],
                        "headline-xl": ["2rem", { lineHeight: "2.5rem", fontWeight: "700" }],
                        "title-sm": ["1rem", { lineHeight: "1.5rem", fontWeight: "600" }],
                        "display-lg-mobile": ["2.25rem", { lineHeight: "2.75rem", fontWeight: "700" }],
                        "headline-lg": ["1.5rem", { lineHeight: "2rem", fontWeight: "600" }],
                        "label-sm": ["0.75rem", { lineHeight: "1rem", fontWeight: "600" }],
                        "display-lg": ["3rem", { lineHeight: "3.5rem", fontWeight: "700" }],
                        "body-md": ["1rem", { lineHeight: "1.5rem", fontWeight: "400" }]
                    }
                }
            }
        };
    </script>
    @livewireStyles
</head>
<body class="bg-background font-body-md text-on-surface antialiased min-h-screen" x-data="{ sidebarOpen: false }">
    <!-- Backdrop for mobile drawer -->
    <div 
        x-show="sidebarOpen" 
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        style="display: none;"
    ></div>

    @php
        $user = auth()->user();
        $facility = $user?->facilities()?->first() ?? \App\Models\Facility::first();
    @endphp

    <!-- Sidebar Navigation -->
    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-50 flex flex-col justify-between select-none transition-transform duration-300 ease-in-out"
    >
        <div class="flex flex-col flex-1 overflow-y-auto">
            <!-- Header Brand -->
            <div class="h-16 px-space-lg flex items-center justify-between bg-surface-container-lowest border-b border-surface-container/60">
                <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-space-sm">
                    <img 
                        alt="Logo Si Kahayan" 
                        class="h-8 w-auto object-contain" 
                        src="https://lh3.googleusercontent.com/aida/AEtjO1XmEAYYP_2FYkFtafVIdCsgduAG_nRNtBHQ_u0gdqdUNpQnZAUDNUV8YbeqTMo7AYkl50QL3IrUt-uw42JcwIeLcTRcFDemgtm0bIhyTc1-GtzDPvaUW9heXqga3ARG9V4v3aeFuqUuJOKtGV-llL5rzmSuPo3aX5ledIfILCulL67JbAmtfXAualW8DWrAeFMF51G036IHlZy6nDSfAASDZXxMdKqqSiMqRKbgmIivTji2xhUZj7C2mXmL"
                    />
                    <div class="flex flex-col">
                        <span class="font-headline-md text-primary leading-tight font-bold tracking-tight">Si Kahayan</span>
                        <span class="font-label-sm text-on-surface-variant leading-none text-[11px]">BBPOM di Palangka Raya</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-on-surface-variant hover:text-on-surface p-1">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <!-- Portal Badge -->
            <div class="px-space-md py-space-sm">
                <div class="p-space-sm bg-surface-container-low rounded-lg border border-surface-container">
                    <div class="flex items-center gap-space-xs">
                        <span class="w-2 h-2 rounded-full bg-primary-container animate-pulse"></span>
                        <span class="font-label-sm text-on-surface font-semibold">Portal Pelaku Usaha</span>
                    </div>
                    <p class="font-label-sm text-on-surface-variant truncate mt-0.5 text-[11px]">Sentra Layanan Pengawasan &amp; CAPA</p>
                </div>
            </div>

            <!-- Main Nav Links -->
            <nav class="flex flex-col gap-1 px-space-md mt-space-xs">
                <a 
                    href="{{ route('portal.dashboard') }}" 
                    class="flex items-center gap-space-sm px-space-md py-space-sm rounded-lg font-label-md transition-all {{ request()->routeIs('portal.dashboard') ? 'bg-primary-container text-on-primary-container font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}"
                >
                    <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
                    <span class="font-label-md">Dashboard</span>
                </a>

                <a 
                    href="{{ route('portal.temuan-capa') }}" 
                    class="flex items-center justify-between px-space-md py-space-sm rounded-lg font-label-md transition-all {{ request()->routeIs('portal.temuan-capa*') || request()->routeIs('portal.submit-capa*') ? 'bg-primary-container text-on-primary-container font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}"
                >
                    <div class="flex items-center gap-space-sm">
                        <span class="material-symbols-outlined text-[20px]">assignment_late</span>
                        <span class="font-label-md">Temuan &amp; CAPA</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-error-container text-on-error-container font-label-sm text-[11px] font-bold">Aktif</span>
                </a>

                <a 
                    href="{{ route('portal.dokumen') }}" 
                    class="flex items-center gap-space-sm px-space-md py-space-sm rounded-lg font-label-md transition-all {{ request()->routeIs('portal.dokumen') ? 'bg-primary-container text-on-primary-container font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}"
                >
                    <span class="material-symbols-outlined text-[20px]">folder_open</span>
                    <span class="font-label-md">Dokumen &amp; BAP</span>
                </a>

                <a 
                    href="{{ route('portal.profil') }}" 
                    class="flex items-center gap-space-sm px-space-md py-space-sm rounded-lg font-label-md transition-all {{ request()->routeIs('portal.profil') ? 'bg-primary-container text-on-primary-container font-bold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}"
                >
                    <span class="material-symbols-outlined text-[20px]">storefront</span>
                    <span class="font-label-md">Profil Sarana</span>
                </a>

                <div class="my-2 border-t border-surface-container"></div>

                <a 
                    href="{{ route('publik.validasi-bap') }}" 
                    target="_blank"
                    class="flex items-center gap-space-sm px-space-md py-space-sm rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all text-sm"
                >
                    <span class="material-symbols-outlined text-[20px]">qr_code_scanner</span>
                    <span class="font-label-md">Cek Keaslian BAP (Publik)</span>
                    <span class="material-symbols-outlined text-[16px] text-outline ml-auto">open_in_new</span>
                </a>

                <a 
                    href="{{ route('publik.panduan') }}" 
                    target="_blank"
                    class="flex items-center gap-space-sm px-space-md py-space-sm rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all text-sm"
                >
                    <span class="material-symbols-outlined text-[20px]">menu_book</span>
                    <span class="font-label-md">Panduan &amp; Regulasi</span>
                    <span class="material-symbols-outlined text-[16px] text-outline ml-auto">open_in_new</span>
                </a>
            </nav>
        </div>

        <!-- Bottom User Card -->
        <div class="p-space-md bg-surface-container-lowest border-t border-surface-container flex flex-col gap-space-sm">
            <div class="p-space-sm rounded-lg bg-surface-container-low flex flex-col gap-1">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-on-surface-variant text-[11px]">Status Izin CPPOB</span>
                    <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-sm font-semibold text-[10px]">Aktif (MS)</span>
                </div>
                <p class="font-label-sm text-on-surface font-semibold truncate">{{ $facility?->name ?? 'UD. Berkah Mandiri Patin' }}</p>
            </div>

            <div class="flex items-center justify-between pt-space-xs">
                <div class="flex items-center gap-space-sm min-w-0">
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="font-label-sm text-on-surface font-semibold truncate">{{ $user?->name ?? 'Penanggung Jawab Sarana' }}</span>
                        <span class="font-label-sm text-on-surface-variant text-[11px] truncate">{{ $user?->email ?? 'pelaku.usaha@kahayan.id' }}</span>
                    </div>
                </div>
                <form action="{{ route('portal.logout') }}" method="POST">
                    @csrf
                    <button 
                        type="submit" 
                        class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/40 rounded-lg transition-colors" 
                        title="Keluar / Logout"
                    >
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="lg:pl-72 flex flex-col min-h-screen">
        <!-- Top App Bar -->
        <header class="sticky top-0 z-30 h-16 bg-surface-container-lowest/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] flex items-center justify-between px-space-md lg:px-space-lg">
            <div class="flex items-center gap-space-md flex-1 max-w-xl">
                <!-- Mobile hamburger button -->
                <button 
                    @click="sidebarOpen = true" 
                    type="button" 
                    class="lg:hidden p-2 rounded-lg text-on-surface-variant hover:bg-surface-container transition-colors"
                >
                    <span class="material-symbols-outlined text-[24px]">menu</span>
                </button>

                <div class="flex items-center gap-space-xs px-3 py-1.5 rounded-lg bg-surface-container-low text-on-surface">
                    <span class="material-symbols-outlined text-primary text-[18px]">domain</span>
                    <div class="flex flex-col text-left">
                        <span class="font-label-sm text-on-surface truncate max-w-[180px] sm:max-w-[260px]">{{ $facility?->name ?? 'UD. Berkah Mandiri Patin' }}</span>
                        <span class="text-[10px] text-on-surface-variant leading-none truncate">
                            {{ $facility?->cppob_certificate_number ? 'Izin: '.$facility->cppob_certificate_number : 'Produsen Olahan Ikan' }} • {{ $facility?->regency ?? 'Palangka Raya' }}
                        </span>
                    </div>
                </div>

                <div class="relative flex-1 hidden md:block">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
                    <input 
                        class="w-full pl-9 pr-3 py-1.5 rounded-lg bg-surface-container-low font-body-sm text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:bg-surface-container-lowest focus:ring-1 focus:ring-primary transition-all text-sm" 
                        placeholder="Cari BAP, CAPA, temuan, surat..." 
                        type="text"
                    />
                </div>
            </div>

            <div class="flex items-center gap-space-sm">
                <div class="hidden sm:flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container text-on-surface font-label-sm text-xs">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span>BBPOM Siap Melayani</span>
                </div>

                <a 
                    href="{{ route('publik.panduan') }}" 
                    class="p-2 rounded-lg text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" 
                    title="Bantuan &amp; Regulasi"
                >
                    <span class="material-symbols-outlined text-[20px]">help_outline</span>
                </a>

                <a 
                    href="{{ route('publik.beranda') }}" 
                    class="hidden sm:inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface font-label-sm text-xs transition-colors"
                >
                    <span class="material-symbols-outlined text-[16px]">public</span>
                    <span>Portal Publik</span>
                </a>

                <div class="h-6 w-px bg-outline-variant/40 mx-1"></div>

                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary">
                    <span class="material-symbols-outlined text-[18px]">person</span>
                </div>
            </div>
        </header>

        <!-- Body Main Content -->
        <main class="w-full flex-1 bg-background px-space-md lg:px-space-lg py-space-lg">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
