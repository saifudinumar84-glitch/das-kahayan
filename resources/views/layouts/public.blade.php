<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $title ?? 'Si Kahayan — Balai Besar POM Palangka Raya' }}</title>
    <meta name="description" content="{{ $description ?? 'Portal keterbukaan informasi publik Balai Besar POM di Palangka Raya untuk memantau hasil pengawasan pangan olahan di Kalimantan Tengah.' }}"/>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>

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
                        "on-error-container": "#93000a",
                        "surface-dim": "#cbdbf5",
                        "surface-container": "#e5eeff",
                        "surface-tint": "#106b4f",
                        "on-primary-fixed-variant": "#00513a",
                        "on-surface": "#0b1c30",
                        "surface-container-low": "#eff4ff",
                        "inverse-primary": "#86d6b4",
                        "on-surface-variant": "#3f4944",
                        "tertiary-fixed": "#ffddb4",
                        "outline": "#6f7a73",
                        "surface-container-lowest": "#ffffff",
                        "tertiary": "#623f00",
                        "inverse-on-surface": "#eaf1ff",
                        "tertiary-fixed-dim": "#ffb955",
                        "primary-fixed": "#a1f3cf",
                        "outline-variant": "#bec9c2",
                        "on-error": "#ffffff",
                        "on-secondary": "#ffffff",
                        "inverse-surface": "#213145",
                        "on-secondary-fixed": "#002020",
                        "primary-fixed-dim": "#86d6b4",
                        "tertiary-container": "#825400",
                        "secondary-container": "#8ff3f2",
                        "surface": "#f8f9ff",
                        "on-secondary-fixed-variant": "#004f50",
                        "surface-bright": "#f8f9ff",
                        "surface-container-high": "#dce9ff",
                        "secondary-fixed": "#8ff3f2",
                        "background": "#f8f9ff",
                        "on-background": "#0b1c30",
                        "primary": "#00513a",
                        "on-tertiary-fixed-variant": "#633f00",
                        "on-tertiary-container": "#ffcf92",
                        "on-primary": "#ffffff",
                        "on-tertiary-fixed": "#291800",
                        "on-primary-container": "#97e8c5",
                        "surface-container-highest": "#d3e4fe",
                        "surface-variant": "#d3e4fe",
                        "on-primary-fixed": "#002115",
                        "error-container": "#ffdad6",
                        "on-tertiary": "#ffffff",
                        "error": "#ba1a1a",
                        "primary-container": "#0f6b4f",
                        "secondary-fixed-dim": "#72d6d6",
                        "secondary": "#006a6a",
                        "on-secondary-container": "#007070"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"
                    },
                    spacing: {
                        "space-xs": "0.25rem", "margin-mobile": "1rem", "space-xl": "2.5rem",
                        "space-sm": "0.5rem", "margin": "2rem", "gutter": "1.5rem",
                        "space-md": "1rem", "space-lg": "1.5rem", "gutter-mobile": "1rem"
                    },
                    fontFamily: {
                        "headline-md": ["Plus Jakarta Sans"], "body-sm": ["Inter"],
                        "label-md": ["Inter"], "label-sm": ["Inter"],
                        "display-lg-mobile": ["Plus Jakarta Sans"], "body-md": ["Inter"],
                        "headline-xl": ["Plus Jakarta Sans"], "body-lg": ["Inter"],
                        "title-sm": ["Plus Jakarta Sans"], "headline-lg": ["Plus Jakarta Sans"],
                        "display-lg": ["Plus Jakarta Sans"]
                    },
                    fontSize: {
                        "headline-md": ["1.25rem", { lineHeight: "1.75rem", fontWeight: "600" }],
                        "body-sm": ["0.875rem", { lineHeight: "1.25rem", fontWeight: "400" }],
                        "label-md": ["0.875rem", { lineHeight: "1.25rem", fontWeight: "600" }],
                        "label-sm": ["0.75rem", { lineHeight: "1rem", fontWeight: "600" }],
                        "display-lg-mobile": ["2.25rem", { lineHeight: "2.75rem", fontWeight: "700" }],
                        "body-md": ["1rem", { lineHeight: "1.5rem", fontWeight: "400" }],
                        "headline-xl": ["2rem", { lineHeight: "2.5rem", fontWeight: "700" }],
                        "body-lg": ["1.125rem", { lineHeight: "1.75rem", fontWeight: "400" }],
                        "title-sm": ["1rem", { lineHeight: "1.5rem", fontWeight: "600" }],
                        "headline-lg": ["1.5rem", { lineHeight: "2rem", fontWeight: "600" }],
                        "display-lg": ["3rem", { lineHeight: "3.5rem", fontWeight: "700" }]
                    }
                }
            }
        }
    </script>

    @livewireStyles
</head>
<body class="bg-surface font-body-md text-body-md text-on-surface">

{{-- Header / Navbar --}}
<header class="fixed top-0 left-0 w-full z-50 bg-surface-container-lowest/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(15,23,42,0.05)]">
    <div class="h-20 max-w-[1280px] mx-auto px-margin-mobile lg:px-margin flex items-center justify-between gap-gutter">
        {{-- Brand --}}
        <div class="flex items-center gap-space-md">
            <a href="{{ route('publik.beranda') }}" class="flex items-center gap-space-md">
                <img alt="Logo Si Kahayan BBPOM Palangka Raya" class="h-9 w-auto object-contain"
                     src="{{ asset('images/logo-si-kahayan.png') }}"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"/>
                <div class="hidden w-9 h-9 rounded-full bg-primary items-center justify-center" id="logo-fallback">
                    <span class="material-symbols-outlined text-on-primary text-[20px]">shield_with_heart</span>
                </div>
            </a>
            <div class="flex flex-col">
                <span class="font-title-sm text-title-sm text-primary tracking-tight">Si Kahayan</span>
                <span class="font-label-sm text-label-sm text-on-surface-variant">Balai Besar POM di Palangka Raya</span>
            </div>
        </div>

        {{-- Desktop Nav --}}
        <nav class="hidden xl:flex items-center gap-space-xs p-space-xs">
            @php
                $navItems = [
                    ['route' => 'publik.beranda', 'label' => 'Beranda'],
                    ['route' => 'publik.hasil-pengawasan', 'label' => 'Hasil Pengawasan'],
                    ['route' => 'publik.cari', 'label' => 'Cari Produk & Sarana'],
                    ['route' => 'publik.validasi-bap', 'label' => 'Validasi BAP'],
                    ['route' => 'publik.panduan', 'label' => 'Panduan'],
                ];
            @endphp
            @foreach($navItems as $item)
                @if(request()->routeIs($item['route']))
                    <a href="{{ route($item['route']) }}" class="px-space-md py-space-sm transition-colors bg-primary-container text-on-primary font-label-md rounded-lg" aria-current="page">
                        {{ $item['label'] }}
                    </a>
                @else
                    <a href="{{ route($item['route']) }}" class="px-space-md py-space-sm font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors rounded-lg">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
        </nav>

        {{-- CTA + Mobile Menu --}}
        <div class="flex items-center gap-space-md">
            <a href="{{ route('portal.login') }}"
               class="inline-flex items-center gap-space-xs px-space-md py-space-sm rounded-lg bg-primary-container hover:bg-primary text-on-primary transition-colors font-label-md text-label-md shadow-[0_1px_3px_0_rgba(15,23,42,0.05)]">
                <span class="material-symbols-outlined text-[18px]">lock</span>
                <span class="hidden sm:inline">Masuk Pelaku Usaha</span>
            </a>
            {{-- Mobile hamburger --}}
            <button class="xl:hidden w-9 h-9 flex items-center justify-center rounded-lg hover:bg-surface-container transition-colors"
                    x-data x-on:click="$dispatch('toggle-mobile-menu')" aria-label="Buka menu">
                <span class="material-symbols-outlined text-on-surface-variant">menu</span>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div class="xl:hidden border-t border-surface-container" x-data="{ open: false }" x-on:toggle-mobile-menu.window="open = !open" x-show="open" x-transition>
        <nav class="flex flex-col px-margin-mobile py-space-md gap-1 bg-surface-container-lowest">
            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="px-space-md py-space-sm rounded-lg font-label-md text-label-md {{ request()->routeIs($item['route']) ? 'bg-primary-container text-on-primary' : 'text-on-surface-variant hover:bg-surface-container' }} transition-colors">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>

{{-- Main Content --}}
<main class="w-full pt-20 bg-surface min-h-[calc(100vh-20rem)]">
    <div class="flex flex-col w-full">
        {{ $slot }}
    </div>
</main>

{{-- Footer --}}
<footer class="w-full bg-surface-container-lowest shadow-[0_-1px_8px_rgba(15,23,42,0.03)] mt-space-xl">
    <div class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin py-space-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter mb-space-xl">
            <div>
                <div class="flex items-center gap-space-sm mb-space-md">
                    <img alt="Logo Si Kahayan" class="h-8 w-auto object-contain"
                         src="{{ asset('images/logo-si-kahayan.png') }}"
                         onerror="this.style.display='none'"/>
                    <span class="font-title-sm text-title-sm text-primary">Si Kahayan</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed mb-space-md">
                    Sistem Informasi Kawal Hasil Pengawasan Obat dan Makanan terpadu di wilayah Provinsi Kalimantan Tengah.
                </p>
                <div class="inline-flex items-center gap-space-xs font-label-sm text-label-sm text-primary bg-surface-container-low px-space-sm py-space-xs rounded-full">
                    <span class="material-symbols-outlined text-[16px]">verified_user</span>
                    <span>Portal Resmi BPOM RI</span>
                </div>
            </div>
            <div>
                <h3 class="font-title-sm text-title-sm text-on-surface mb-space-md">Alamat Operasional</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                    Balai Besar POM di Palangka Raya<br/>
                    Jl. Yos Sudarso No. 83, Palangka Raya,<br/>
                    Kalimantan Tengah 73111
                </p>
            </div>
            <div>
                <h3 class="font-title-sm text-title-sm text-on-surface mb-space-md">Layanan Kontak & Aduan</h3>
                <ul class="space-y-space-sm font-body-sm text-body-sm text-on-surface-variant">
                    <li><span class="font-label-sm text-label-sm text-on-surface block">Contact Center:</span>Halo BPOM 1500533</li>
                    <li><span class="font-label-sm text-label-sm text-on-surface block">Surel Resmi:</span>bapom_palangkaraya@pom.go.id</li>
                    <li><span class="font-label-sm text-label-sm text-on-surface block">Pengaduan Masyarakat:</span>ULPK BBPOM di Palangka Raya</li>
                </ul>
            </div>
            <div>
                <h3 class="font-title-sm text-title-sm text-on-surface mb-space-md">Tautan Publik</h3>
                <ul class="space-y-space-sm font-label-md text-label-md text-on-surface-variant">
                    <li><a class="hover:text-primary transition-colors" href="{{ route('publik.beranda') }}">Beranda Utama</a></li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('publik.hasil-pengawasan') }}">Laporan Pengawasan</a></li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('publik.cari') }}">Cek Produk & Izin Edar</a></li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('publik.validasi-bap') }}">Verifikasi BAP Digital</a></li>
                    <li><a class="hover:text-primary transition-colors" href="{{ route('publik.panduan') }}">Panduan Pelaku Usaha</a></li>
                </ul>
            </div>
        </div>
        <div class="pt-space-lg flex flex-col md:flex-row items-center justify-between gap-space-md font-body-sm text-body-sm text-on-surface-variant">
            <p>© {{ date('Y') }} Balai Besar POM di Palangka Raya. Hak Cipta Dilindungi Undang-Undang.</p>
            <p class="font-label-sm text-label-sm text-on-surface-variant">Integritas Pengawasan • Transparansi Publik • Bumi Tambun Bungai</p>
        </div>
    </div>
</footer>

@livewireScripts
<script>
    // Fix logo fallback
    document.querySelectorAll('img[onerror]').forEach(img => {
        if (!img.complete || img.naturalWidth === 0) {
            img.onerror();
        }
    });
</script>
</body>
</html>
