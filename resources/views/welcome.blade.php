<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Pamflet Digital') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
        
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
        </style>
    </head>
    <body class="bg-[#f8faff] text-slate-900 antialiased" x-data="{ selectedPost: null }" x-cloak>
        <x-toast />
        <x-dialog />

        {{-- Background Decorations --}}
        <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-blue-200/30 rounded-full blur-[120px]"></div>
            <div class="absolute top-[20%] -right-[5%] w-[30%] h-[30%] bg-indigo-200/20 rounded-full blur-[100px]"></div>
            <div class="absolute -bottom-[10%] left-[20%] w-[50%] h-[50%] bg-purple-200/20 rounded-full blur-[150px]"></div>
        </div>

        <!-- Navigation -->
        <header class="fixed top-4 left-1/2 -translate-x-1/2 w-[95%] max-w-7xl z-50 glass border border-white/50 rounded-full shadow-lg">
            <div class="px-6 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-white p-1.5 rounded-xl shadow-sm">
                        <img src="{{ asset('logo/rme-logo.png') }}" alt="Logo" class="h-7 w-auto">
                    </div>
                    <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-blue-700 to-indigo-700 bg-clip-text text-transparent hidden sm:block">Pamflet Digital</span>
                </div>
                <nav class="flex items-center gap-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm rounded-full px-8 shadow-md shadow-blue-500/20">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-700 transition flex items-center gap-2 group">
                            Log in
                            <i class="ti ti-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="relative z-10 pt-32 pb-24 px-4">
            <div class="max-w-7xl mx-auto">
                {{-- Hero Section --}}
                <div class="text-center mb-20">
                    <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 px-4 py-1.5 rounded-full mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        <span class="text-xs font-bold text-blue-700 uppercase tracking-widest">Informasi Terbaru</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black mb-6 tracking-tight text-slate-900 leading-[1.1]">
                        Katalog <span class="relative">
                            <span class="relative z-10 text-blue-600">Pamflet</span>
                            <svg class="absolute -bottom-2 left-0 w-full h-3 text-blue-200 -z-1" viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path d="M0,5 Q25,0 50,5 T100,5" stroke="currentColor" stroke-width="8" fill="none" stroke-linecap="round"/>
                            </svg>
                        </span> Digital
                    </h1>
                    <p class="text-slate-500 text-lg md:text-xl max-w-2xl mx-auto font-medium">
                        Temukan berbagai informasi penting, pengumuman, dan promosi terkini yang kami rangkum dalam bentuk pamflet digitalinteraktif.
                    </p>
                </div>

                @php
                    $posts = \App\Models\Post::where('publish', 'ya')->latest()->take(6)->get();
                    $storage_url = asset('storage');
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    @forelse ($posts as $post)
                        <div 
                            class="group relative bg-white rounded-[2.5rem] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_50px_rgba(59,130,246,0.1)] transition-all duration-700 border border-slate-100 cursor-pointer flex flex-col"
                            x-on:click="selectedPost = {{ $post->toJson() }}"
                        >
                            <div class="aspect-[4/5] overflow-hidden relative">
                                @if($post->gambar)
                                    <img src="{{ Storage::url($post->gambar) }}" alt="{{ $post->judul }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000 ease-out">
                                @else
                                    <div class="w-full h-full bg-slate-50 flex flex-col items-center justify-center gap-3">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                                            <i class="ti ti-photo text-4xl text-slate-300"></i>
                                        </div>
                                        <p class="text-slate-400 font-medium text-sm">No Image Available</p>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-8">
                                    <span class="text-white font-bold flex items-center gap-2">
                                        Lihat Detail <i class="ti ti-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="p-8 flex-1 flex flex-col">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg">Infographic</span>
                                    <span class="text-[11px] text-slate-400 font-bold">{{ $post->created_at->translatedFormat('d M Y') }}</span>
                                </div>
                                <h3 class="font-black text-xl leading-tight text-slate-800 group-hover:text-blue-600 transition-colors mb-4 line-clamp-2">{{ $post->judul }}</h3>
                                <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 mt-auto">
                                    {{ Str::limit(strip_tags($post->isi), 80) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-32 text-center glass border border-white/50 rounded-[3rem]">
                            <div class="w-24 h-24 bg-white rounded-3xl shadow-sm flex items-center justify-center mx-auto mb-6">
                                <i class="ti ti-news text-4xl text-slate-200"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-400">Belum Ada Pamflet</h3>
                            <p class="text-slate-300 max-w-xs mx-auto mt-2">Nantikan informasi menarik lainnya yang akan segera kami terbitkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>

        {{-- Detail Modal --}}
        <template x-if="selectedPost">
            <div 
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-slate-900/40 backdrop-blur-md"
                x-on:click.self="selectedPost = null"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div 
                    class="bg-white rounded-[3rem] w-full max-w-5xl max-h-[92vh] overflow-hidden shadow-[0_50px_100px_rgba(0,0,0,0.3)] flex flex-col md:flex-row relative"
                    x-on:click.stop
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-90 translate-y-12"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                >
                    {{-- Close Button --}}
                    <button x-on:click="selectedPost = null" class="absolute top-8 right-8 z-[110] w-12 h-12 flex items-center justify-center bg-white/20 backdrop-blur-md hover:bg-white hover:text-red-500 text-white rounded-full transition-all duration-300 shadow-lg border border-white/30 md:bg-slate-100/50 md:text-slate-500 md:hover:bg-slate-200 md:border-transparent">
                        <i class="ti ti-x text-2xl"></i>
                    </button>

                    <div class="w-full md:w-[45%] h-[40vh] md:h-auto overflow-hidden bg-slate-100 relative group">
                        <img :src="'/storage/' + selectedPost.gambar" class="w-full h-full object-cover" alt="">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>

                    <div class="w-full md:w-[55%] p-10 md:p-16 overflow-y-auto custom-scrollbar flex flex-col">
                        <div class="mb-10">
                            <div class="inline-flex items-center gap-2 text-blue-600 bg-blue-50 px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-[0.2em] mb-6">
                                Infografis Digital
                            </div>
                            <h2 class="text-4xl md:text-5xl font-black text-slate-900 leading-[1.1] mb-6" x-text="selectedPost.judul"></h2>
                            <div class="flex items-center gap-6 text-slate-400 text-sm font-bold bg-slate-50 self-start px-5 py-3 rounded-2xl">
                                <span class="flex items-center gap-2"><i class="ti ti-calendar text-lg text-blue-500"></i> <span x-text="new Date(selectedPost.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span></span>
                            </div>
                        </div>

                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-lg" x-html="selectedPost.isi.replace(/\n/g, '<br>')"></div>
                        
                        <div class="mt-20 pt-10 border-t border-slate-100">
                            <button x-on:click="selectedPost = null" class="w-full h-16 flex items-center justify-center bg-slate-900 text-white text-lg font-black rounded-2xl hover:bg-blue-600 transition-colors duration-300 shadow-xl shadow-slate-900/10">
                                Kembali ke Katalog
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 6px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
        </style>

        @livewireScripts
    </body>
</html>
