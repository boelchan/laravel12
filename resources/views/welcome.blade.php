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
    <meta name="apple-mobile-web-app-title" content="MyWebSite" />
    <link href="{{ asset('favicon/manifest.json') }}" rel="manifest" />
    <link href="https://fonts.bunny.net" rel="preconnect">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <tallstackui:script />

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="min-h-screen  bg-[#f8faff] text-slate-900 antialiased" x-data="{ selectedPost: null }" x-cloak>
    <x-toast />
    <x-dialog />

    <!-- Navigation -->
    <header class="fixed left-0 right-0 top-0 z-50 flex justify-end px-6 py-3">
        @auth
            <a class="group flex items-center gap-2 text-sm font-semibold text-slate-600 transition hover:text-blue-700"
                href="{{ url('/dashboard') }}"
            >
                Dashboard
                <i class="ti ti-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
        @else
            <a class="group flex items-center gap-2 text-sm font-semibold text-slate-600 transition hover:text-blue-700"
                href="{{ route('login') }}"
            >
                Log in
                <i class="ti ti-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
        @endauth
    </header>

    <main class="z-10 px-4 pb-6 pt-16">
        <div class="mx-auto max-w-4xl">

            {{-- Hero --}}
            <div class="mb-4 text-center">
                <h1 class="text-lg font-black leading-tight tracking-tight text-blue-900">
                    Praktek Dokter Kandungan
                    <br>
                    <span class="relative inline-block">
                        <span class="relative z-10 text-2xl text-blue-600">dr. Wongso Suhendro, SpOG</span>
                        <svg class="-z-1 absolute -bottom-1 left-0 h-2 w-full text-blue-200" viewBox="0 0 100 10"
                            preserveAspectRatio="none">
                            <path
                                d="M0,5 Q25,0 50,5 T100,5"
                                stroke="currentColor"
                                stroke-width="8"
                                fill="none"
                                stroke-linecap="round"
                            />
                        </svg>
                    </span>
                </h1>
                <p class="mx-auto mt-2 max-w-xl text-xs font-medium text-slate-400">
                    Jl. Jendral Sudirman No.50a, Kabupaten Sumenep, Jawa Timur
                </p>
            </div>

            @php
                $posts = \App\Models\Post::where('publish', 'ya')->latest()->take(6)->get();
            @endphp

            {{-- Grid scroll bebas, gambar kotak fix --}}
            <div class="grid grid-cols-2 gap-3 p-5 sm:grid-cols-3">
                @forelse ($posts as $post)
                    <div class="group cursor-pointer overflow-hidden rounded-[2rem] sm:rounded-[4rem] border border-slate-100 bg-white shadow-[0_4px_15px_rgb(0,0,0,0.05)] transition-all duration-500 hover:shadow-[0_12px_30px_rgba(59,130,246,0.12)]"
                        x-on:click="selectedPost = {{ $post->toJson() }}"
                    >
                        {{-- aspect-[3/4] agar kotak portrait konsisten di semua device --}}
                        <div class="relative aspect-square w-full overflow-hidden">
                            @if ($post->gambar)
                                <img class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                    src="{{ Storage::url($post->gambar) }}" alt="{{ $post->judul }}"
                                >
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-slate-50">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100">
                                        <i class="ti ti-photo text-2xl text-slate-300"></i>
                                    </div>
                                    <p class="text-xs font-medium text-slate-400">No Image</p>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 flex items-end bg-gradient-to-t from-black/60 via-transparent to-transparent p-3 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <span class="flex items-center gap-1 text-xs font-bold text-white m-5">
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
                    class="absolute right-6 top-6 z-[110] flex h-10 w-10 items-center justify-center rounded-full border border-white/30 bg-white/20 text-white shadow-lg backdrop-blur-md transition-all duration-300 hover:bg-white hover:text-red-500 md:border-transparent md:bg-slate-100/50 md:text-slate-500 md:hover:bg-slate-200"
                    x-on:click="selectedPost = null"
                >
                    <i class="ti ti-x text-xl"></i>
                </button>

                <div class="relative h-[40vh] w-full overflow-hidden bg-slate-100 md:h-auto md:w-[45%]">
                    <img class="h-full w-full object-cover" alt="" :src="'/storage/' + selectedPost.gambar">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>

                <div class="custom-scrollbar flex w-full flex-col overflow-y-auto p-10 md:w-[55%] md:p-14">
                    <div class="mb-8">
                        <div
                            class="mb-5 inline-flex items-center gap-2 rounded-xl bg-blue-50 px-4 py-1.5 text-xs font-black uppercase tracking-[0.2em] text-blue-600">
                            Infografis Digital
                        </div>
                        <h2 class="mb-5 text-3xl font-black leading-[1.1] text-slate-900 md:text-4xl" x-text="selectedPost.judul"></h2>
                        <div class="flex items-center gap-4 self-start rounded-xl bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-400">
                            <span class="flex items-center gap-2">
                                <i class="ti ti-calendar text-base text-blue-500"></i>
                                <span
                                    x-text="new Date(selectedPost.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"
                                ></span>
                            </span>
                        </div>
                    </div>

                    <div class="prose prose-slate max-w-none text-base leading-relaxed text-slate-600"
                        x-html="selectedPost.isi.replace(/\n/g, '<br>')"
                    ></div>

                    <div class="mt-12 border-t border-slate-100 pt-8">
                        <button
                            class="flex h-14 w-full items-center justify-center rounded-2xl bg-slate-900 text-base font-black text-white shadow-xl shadow-slate-900/10 transition-colors duration-300 hover:bg-blue-600"
                            x-on:click="selectedPost = null"
                        >
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>

    @livewireScripts
</body>

</html>
