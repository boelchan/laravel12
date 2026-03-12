<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'RME') }}</title>
    <link type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" rel="icon" sizes="96x96" />
    <link type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" rel="icon" />
    <link href="{{ asset('favicon/favicon.ico') }}" rel="shortcut icon" />
    <link href="{{ asset('favicon/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180" />
    <link href="{{ asset('favicon/manifest.json') }}" rel="manifest" />
    <link href="https://fonts.bunny.net" rel="preconnect">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <meta name="apple-mobile-web-app-title" content="RME" />

    {{-- ═══════════════════════════════════════════
         SEO & GEO META TAGS
         ═══════════════════════════════════════════ --}}

    {{-- Primary SEO --}}
    <meta name="description"
        content="Praktek Dokter Kandungan dr. Wongso Suhendro, SpOG di Jl. Jendral Sudirman No.50a, Kabupaten Sumenep, Jawa Timur. Konsultasi kehamilan, USG, dan kesehatan reproduksi wanita.">
    <meta name="keywords"
        content="dokter kandungan sumenep, dokter obgyn sumenep, SpOG sumenep, dokter kehamilan sumenep, USG kehamilan sumenep, klinik kandungan sumenep, dr wongso suhendro">
    <meta name="author" content="dr. Wongso Suhendro, SpOG">
    <meta name="robots" content="index, follow">
    <link href="{{ url()->current() }}" rel="canonical">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Praktek Dokter Kandungan dr. Wongso Suhendro, SpOG - Sumenep">
    <meta property="og:description" content="Konsultasi kehamilan, USG, dan kesehatan reproduksi wanita di Kabupaten Sumenep, Jawa Timur.">
    <meta property="og:image" content="{{ asset('favicon/apple-touch-icon.png') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ config('app.name', 'RME') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Praktek Dokter Kandungan dr. Wongso Suhendro, SpOG – Sumenep">
    <meta name="twitter:description" content="Konsultasi kehamilan, USG, dan kesehatan reproduksi wanita di Kabupaten Sumenep, Jawa Timur.">
    <meta name="twitter:image" content="{{ asset('favicon/apple-touch-icon.png') }}">

    {{-- GEO Tags --}}
    <meta name="geo.region" content="ID-JI">
    <meta name="geo.placename" content="Kabupaten Sumenep, Jawa Timur, Indonesia">
    <meta name="geo.position" content="-7.0167;113.8667">
    <meta name="ICBM" content="-7.0167, 113.8667">

    {{-- Schema.org JSON-LD --}}
    <script type="application/ld+json">
    @verbatim
    {
        "@context": "https://schema.org",
        "@type": "Physician",
        "name": "dr. Wongso Suhendro, SpOG",
        "description": "Dokter Spesialis Obstetri dan Ginekologi (SpOG) di Kabupaten Sumenep, Jawa Timur",
        "medicalSpecialty": "Obstetrics and Gynecology",
        "telephone": "",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Jl. Jendral Sudirman No.50a",
            "addressLocality": "Kabupaten Sumenep",
            "addressRegion": "Jawa Timur",
            "addressCountry": "ID"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": -7.0167,
            "longitude": 113.8667
        },
        "areaServed": {
            "@type": "City",
            "name": "Sumenep"
        }
    }
    @endverbatim
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <tallstackui:script />

    <style>
        [x-cloak] { display: none !important; }

        body { font-family: 'Instrument Sans', sans-serif; }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* ══════════════════════════════
           ANIMATED BACKGROUND
        ══════════════════════════════ */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-28px) scale(1.04); }
        }
        @keyframes float-medium {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-18px) scale(1.03); }
        }
        @keyframes float-fast {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-10px) scale(1.02); }
        }
        @keyframes pulse-ring {
            0%   { transform: scale(0.85); opacity: .5; }
            70%  { transform: scale(1.35); opacity: 0; }
            100% { opacity: 0; }
        }
        @keyframes drift {
            0%   { transform: translate(0, 0) rotate(0deg); }
            33%  { transform: translate(14px, -10px) rotate(8deg); }
            66%  { transform: translate(-10px, 12px) rotate(-5deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }
        @keyframes hb {
            0%, 100% { stroke-dashoffset: 0; }
            50%       { stroke-dashoffset: -40px; }
        }
        @keyframes ecg-anim {
            0%   { transform: scaleY(1); }
            10%  { transform: scaleY(2.2); }
            20%  { transform: scaleY(0.7); }
            30%  { transform: scaleY(1.8); }
            40%  { transform: scaleY(1); }
            100% { transform: scaleY(1); }
        }
        @keyframes twinkle {
            0%, 100% { opacity: .1; }
            50%       { opacity: .5; }
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .bg-canvas { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .orb       { position: absolute; border-radius: 50%; filter: blur(55px); pointer-events: none; }
        .orb-1     { width: 440px; height: 440px; background: radial-gradient(circle, rgba(96,165,250,.22) 0%, transparent 70%);  top: -110px; left: -130px;  animation: float-slow   10s ease-in-out infinite; }
        .orb-2     { width: 340px; height: 340px; background: radial-gradient(circle, rgba(59,130,246,.15) 0%, transparent 70%);  top: 32%; right: -100px;    animation: float-medium 12s ease-in-out infinite 1.5s; }
        .orb-3     { width: 280px; height: 280px; background: radial-gradient(circle, rgba(147,197,253,.24) 0%, transparent 70%); bottom: 6%; left: 4%;       animation: float-fast    8s ease-in-out infinite 2.5s; }
        .orb-4     { width: 220px; height: 220px; background: radial-gradient(circle, rgba(186,230,253,.3) 0%, transparent 70%);  bottom: 20%; right: 10%;    animation: float-slow   14s ease-in-out infinite 3.5s; }

        .particle  { position: absolute; border-radius: 50%; pointer-events: none; animation: twinkle var(--d,4s) ease-in-out infinite var(--delay,0s); }

        .ecg-line { transform-origin: center; animation: ecg-anim 3.2s ease-in-out infinite; }

        /* ══════════════════════════════
           SCROLLBAR
        ══════════════════════════════ */
        .custom-scrollbar::-webkit-scrollbar       { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</head>

<body class="min-h-screen text-slate-900 antialiased"
    style="background: linear-gradient(145deg, #eaf4ff 0%, #f0f8ff 40%, #e6f0ff 70%, #f5fbff 100%);"
    x-data="{ selectedPost: null }" x-cloak>

    <!-- ══════════════════════════════════════════════════
         ANIMATED BACKGROUND CANVAS
    ══════════════════════════════════════════════════ -->
    <div class="bg-canvas" aria-hidden="true">

        <!-- Soft gradient orbs -->
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>

        <!-- Dot grid pattern -->
        <svg class="absolute inset-0 w-full h-full opacity-[0.035]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dotgrid" x="0" y="0" width="30" height="30" patternUnits="userSpaceOnUse">
                    <circle cx="1.5" cy="1.5" r="1.5" fill="#2563eb"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dotgrid)"/>
        </svg>

        <!-- ECG / Heartbeat line -->
        <svg class="absolute w-full opacity-[0.07]" style="top:44%;left:0" viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <g class="ecg-line">
                <polyline
                    points="0,30 100,30 130,30 148,4 163,56 178,10 193,50 210,30 310,30 410,30 440,30 458,4 473,56 488,10 503,50 520,30 620,30 720,30 750,30 768,4 783,56 798,10 813,50 830,30 930,30 1030,30 1060,30 1078,4 1093,56 1108,10 1123,50 1140,30 1240,30 1440,30"
                    fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                />
            </g>
        </svg>

        <!-- Uterus + baby silhouette (top-left floating) -->
        <svg class="absolute opacity-[0.05]"
            style="top:7%;left:2%;width:170px;animation:drift 15s ease-in-out infinite"
            viewBox="0 0 100 120" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="50" cy="72" rx="28" ry="33" fill="none" stroke="#1d4ed8" stroke-width="3.5"/>
            <path d="M22 57 Q9 42 17 28 Q25 15 34 23" fill="none" stroke="#1d4ed8" stroke-width="3" stroke-linecap="round"/>
            <path d="M78 57 Q91 42 83 28 Q75 15 66 23" fill="none" stroke="#1d4ed8" stroke-width="3" stroke-linecap="round"/>
            <circle cx="50" cy="64" r="10" fill="none" stroke="#3b82f6" stroke-width="2.5"/>
            <circle cx="50" cy="56" r="6.5" fill="none" stroke="#3b82f6" stroke-width="2.5"/>
            <path d="M41 74 Q40 84 50 86 Q60 84 59 74" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round"/>
        </svg>

        <!-- DNA double helix (bottom-right) -->
        <svg class="absolute opacity-[0.055]"
            style="bottom:5%;right:2%;width:55px;height:190px;animation:float-medium 9s ease-in-out infinite 1s"
            viewBox="0 0 60 200" xmlns="http://www.w3.org/2000/svg">
            <path d="M10,0 Q50,25 10,50 Q50,75 10,100 Q50,125 10,150 Q50,175 10,200" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M50,0 Q10,25 50,50 Q10,75 50,100 Q10,125 50,150 Q10,175 50,200" fill="none" stroke="#60a5fa" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="10" y1="12"  x2="50" y2="12"  stroke="#93c5fd" stroke-width="1.5" opacity=".6"/>
            <line x1="10" y1="37"  x2="50" y2="37"  stroke="#93c5fd" stroke-width="1.5" opacity=".6"/>
            <line x1="10" y1="62"  x2="50" y2="62"  stroke="#93c5fd" stroke-width="1.5" opacity=".6"/>
            <line x1="10" y1="87"  x2="50" y2="87"  stroke="#93c5fd" stroke-width="1.5" opacity=".6"/>
            <line x1="10" y1="112" x2="50" y2="112" stroke="#93c5fd" stroke-width="1.5" opacity=".6"/>
            <line x1="10" y1="137" x2="50" y2="137" stroke="#93c5fd" stroke-width="1.5" opacity=".6"/>
            <line x1="10" y1="162" x2="50" y2="162" stroke="#93c5fd" stroke-width="1.5" opacity=".6"/>
            <line x1="10" y1="187" x2="50" y2="187" stroke="#93c5fd" stroke-width="1.5" opacity=".6"/>
        </svg>

        <!-- Medical cross (top-right spinning) -->
        <svg class="absolute opacity-[0.05]"
            style="top:4%;right:4%;width:72px;animation:spin-slow 32s linear infinite"
            viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
            <rect x="30" y="5"  width="20" height="70" rx="7" fill="#3b82f6"/>
            <rect x="5"  y="30" width="70" height="20" rx="7" fill="#3b82f6"/>
        </svg>

        <!-- Pulse rings left-center -->
        <div class="absolute" style="top:54%;left:6%">
            <div style="width:64px;height:64px;border-radius:50%;border:2px solid rgba(59,130,246,.3);animation:pulse-ring 3s ease-out infinite"></div>
            <div style="width:64px;height:64px;border-radius:50%;border:2px solid rgba(59,130,246,.2);animation:pulse-ring 3s ease-out infinite .9s;position:absolute;top:0;left:0"></div>
            <div style="width:64px;height:64px;border-radius:50%;border:2px solid rgba(59,130,246,.1);animation:pulse-ring 3s ease-out infinite 1.8s;position:absolute;top:0;left:0"></div>
            <div style="width:14px;height:14px;border-radius:50%;background:rgba(59,130,246,.35);position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)"></div>
        </div>

        <!-- Pulse rings right-upper -->
        <div class="absolute" style="top:18%;right:5%">
            <div style="width:46px;height:46px;border-radius:50%;border:2px solid rgba(96,165,250,.3);animation:pulse-ring 4s ease-out infinite .5s"></div>
            <div style="width:46px;height:46px;border-radius:50%;border:2px solid rgba(96,165,250,.15);animation:pulse-ring 4s ease-out infinite 1.5s;position:absolute;top:0;left:0"></div>
            <div style="width:10px;height:10px;border-radius:50%;background:rgba(96,165,250,.4);position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)"></div>
        </div>

        <!-- Stethoscope (bottom-left) -->
        <svg class="absolute opacity-[0.05]"
            style="bottom:10%;left:1%;width:90px;animation:drift 18s ease-in-out infinite 2s"
            viewBox="0 0 100 130" xmlns="http://www.w3.org/2000/svg">
            <path d="M25 10 Q25 42 40 56 Q55 70 55 90 Q55 113 38 119 Q21 125 18 109" fill="none" stroke="#1d4ed8" stroke-width="4" stroke-linecap="round"/>
            <path d="M55 10 Q55 42 40 56" fill="none" stroke="#1d4ed8" stroke-width="4" stroke-linecap="round"/>
            <circle cx="25" cy="10" r="6"  fill="none" stroke="#3b82f6" stroke-width="3"/>
            <circle cx="55" cy="10" r="6"  fill="none" stroke="#3b82f6" stroke-width="3"/>
            <circle cx="18" cy="109" r="10" fill="none" stroke="#3b82f6" stroke-width="3"/>
            <circle cx="18" cy="109" r="4"  fill="#60a5fa" opacity=".4"/>
        </svg>

        <!-- USG wave lines (center-right) -->
        <svg class="absolute opacity-[0.05]"
            style="top:60%;right:8%;width:120px;animation:float-slow 11s ease-in-out infinite 4s"
            viewBox="0 0 120 80" xmlns="http://www.w3.org/2000/svg">
            <path d="M10,40 Q30,10 50,40 Q70,70 90,40 Q110,10 120,40" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M5,40 Q25,5 50,40 Q75,75 95,40 Q115,5 120,40"   fill="none" stroke="#60a5fa" stroke-width="1.5" stroke-linecap="round" opacity=".5"/>
            <path d="M15,40 Q35,18 50,40 Q65,62 85,40 Q105,18 115,40" fill="none" stroke="#93c5fd" stroke-width="1"   stroke-linecap="round" opacity=".4"/>
        </svg>

        <!-- Twinkling particles -->
        <div class="particle" style="width:5px;height:5px;background:#93c5fd;top:13%;left:22%;--d:5s;--delay:0s"></div>
        <div class="particle" style="width:4px;height:4px;background:#60a5fa;top:27%;left:57%;--d:6s;--delay:1s"></div>
        <div class="particle" style="width:6px;height:6px;background:#bfdbfe;top:61%;left:42%;--d:4.5s;--delay:2s"></div>
        <div class="particle" style="width:3px;height:3px;background:#93c5fd;top:76%;left:72%;--d:7s;--delay:.5s"></div>
        <div class="particle" style="width:5px;height:5px;background:#dbeafe;top:38%;left:87%;--d:5.5s;--delay:1.5s"></div>
        <div class="particle" style="width:4px;height:4px;background:#60a5fa;top:89%;left:32%;--d:6.5s;--delay:3s"></div>
        <div class="particle" style="width:3px;height:3px;background:#93c5fd;top:9%;left:68%;--d:4s;--delay:2.5s"></div>
        <div class="particle" style="width:5px;height:5px;background:#bfdbfe;top:50%;left:13%;--d:8s;--delay:.8s"></div>
        <div class="particle" style="width:4px;height:4px;background:#93c5fd;top:32%;left:34%;--d:5.2s;--delay:1.2s"></div>
        <div class="particle" style="width:3px;height:3px;background:#dbeafe;top:70%;left:88%;--d:6.8s;--delay:2.2s"></div>
    </div>

    <x-toast />
    <x-dialog />

    <!-- Navigation -->
    <header class="fixed left-0 right-0 top-0 z-50 flex justify-end px-6 py-3">
        @auth
            <a class="group flex items-center gap-2 text-sm font-semibold text-slate-600 transition hover:text-blue-700"
                href="{{ url('/dashboard') }}">
                Dashboard
                <i class="ti ti-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
        @else
            <a class="group flex items-center gap-2 text-sm font-semibold text-slate-600 transition hover:text-blue-700"
                href="{{ route('login') }}">
                Log in
                <i class="ti ti-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
        @endauth
    </header>

    <main class="relative z-10 min-h-screen px-4 pb-6 pt-16">
        <div class="mx-auto max-w-4xl">

            {{-- Hero --}}
            <div class="mb-4 text-center">
                <h1 class="text-md font-black leading-tight tracking-tight text-blue-800">
                    Dokter Spesialis Kandungan
                    <br>
                    <span class="relative inline-block">
                        <span class="relative z-10 text-2xl sm:text-4xl text-blue-700">dr. Wongso Suhendro, Sp.OG</span>
                        <svg viewBox="0 0 200 20" width="100%" height="20" preserveAspectRatio="none">
                            <g>
                              <path
                                d="M0,10 Q25,0 50,10 T100,10 T150,10 T200,10 T250,10 T300,10"
                                fill="none"
                                stroke="#93c5fd"
                                stroke-width="4"
                                stroke-linecap="round">
                                
                                <animateTransform
                                  attributeName="transform"
                                  type="translate"
                                  from="0 0"
                                  to="-100 0"
                                  dur="3s"
                                  repeatCount="indefinite" />
                                  
                              </path>
                            </g>
                          </svg>
                    </span>
                </h1>
                <p class="mx-auto mt-2 max-w-xl text-xs font-medium text-slate-400">
                    Jl. Jendral Sudirman No.50a Sumenep, Jawa Timur
                    <a href="https://maps.app.goo.gl/nJcEaiUD8A6VreyQ7" target="_blank" >
                        <i class="ti ti-brand-telegram text-red-500 text-lg"></i>
                    </a>
                </p>
            </div>

            @php
                $posts = \App\Models\Post::where('publish', 'ya')->latest()->take(6)->get();
            @endphp

            <div class="grid grid-cols-2 gap-3 p-5 sm:grid-cols-3">
                @forelse ($posts as $post)
                    <div class="group cursor-pointer overflow-hidden rounded-[3rem] border border-slate-100 bg-white shadow-[0_4px_15px_rgb(0,0,0,0.05)] transition-all duration-500 hover:shadow-[0_12px_30px_rgba(59,130,246,0.12)]"
                        x-on:click="selectedPost = {{ $post->toJson() }}">
                        <div class="relative aspect-square w-full overflow-hidden">
                            @if ($post->gambar)
                                <img class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                    src="{{ Storage::url($post->gambar) }}" alt="{{ $post->judul }}">
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-slate-50">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100">
                                        <i class="ti ti-photo text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="text-xs font-medium text-slate-400">No Image</p>
                                </div>
                            @endif
                            <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/60 via-transparent to-transparent p-5 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <span class="flex items-center gap-1 text-xs font-bold text-white">
                                    Lihat Detail <i class="ti ti-arrow-right text-xs"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="glass col-span-full rounded-2xl border border-white/50 py-16 text-center">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-sm">
                            <i class="ti ti-news text-3xl text-slate-200"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-400">Belum Ada Pamflet</h3>
                        <p class="mx-auto mt-1 max-w-xs text-sm text-slate-300">Nantikan informasi menarik lainnya.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    {{-- Detail Modal --}}
    <template x-if="selectedPost">
        <div
            class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 p-4 backdrop-blur-md sm:p-6"
            x-on:click.self="selectedPost = null"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div
                class="relative flex max-h-[92vh] w-full max-w-5xl flex-col overflow-hidden rounded-[3rem] bg-white shadow-[0_50px_100px_rgba(0,0,0,0.3)] md:flex-row"
                x-on:click.stop
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-90 translate-y-12"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            >
                <button
                    class="absolute right-6 top-6 z-[110] flex h-10 w-10 items-center justify-center rounded-full bg-white/80 text-slate-600 shadow-lg backdrop-blur-md transition-all duration-300 hover:bg-white hover:text-red-500"
                    x-on:click="selectedPost = null"
                >
                    <i class="ti ti-x text-xl"></i>
                </button>

                <!-- Gambar full tanpa crop -->
                <div class="flex w-full items-center aspect-square justify-center overflow-hidden bg-slate-950 md:w-[45%]">
                    <img class="h-auto max-h-[92vh] w-full object-contain" alt="" :src="'/storage/' + selectedPost.gambar">
                </div>

                <div class="custom-scrollbar flex w-full flex-col overflow-y-auto p-8 md:w-[55%]">
                    <div class="mb-5">
                        <div class="flex items-center gap-4 self-start rounded-xl bg-slate-50 text-sm font-bold text-slate-400">
                            <span class="flex items-center gap-2">
                                <i class="ti ti-calendar text-base text-blue-500"></i>
                                <span x-text="new Date(selectedPost.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span>
                            </span>
                        </div>
                        <h2 class="mb-3 text-lg font-black leading-[1.1] text-slate-900 md:text-4xl"
                            x-text="selectedPost.judul"></h2>
                    </div>

                    <div class="prose prose-slate max-w-none text-base leading-relaxed text-slate-600"
                        x-html="selectedPost.isi.replace(/\n/g, '<br>')">
                    </div>
                </div>
            </div>
        </div>
    </template>

    @livewireScripts
</body>

</html>