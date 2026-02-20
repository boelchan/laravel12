<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" rel="icon" sizes="96x96" />
    <link type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" rel="icon" />
    <link href="{{ asset('favicon/favicon.ico') }}" rel="shortcut icon" />
    <link href="{{ asset('favicon/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180" />
    <meta name="apple-mobile-web-app-title" content="MyWebSite" />
    <link href="{{ asset('favicon/manifest.json') }}" rel="manifest" />

    <title>{{ $title ?? config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <tallstackui:script />
</head>

<body>
    <x-toast />
    <x-dialog />

    <div class="relative min-h-screen w-full items-stretch bg-white lg:flex">
        <!-- Sidebar -->
        @if (Auth::check())
            <aside
                class="top-18 bg-white-100/30 fixed bottom-3 left-0 z-30 h-[90vh] w-60 -translate-x-full transform flex-col overflow-hidden rounded-3xl border border-white p-4 backdrop-blur-3xl transition-transform duration-300 ease-in-out lg:sticky lg:left-3 lg:top-3 lg:flex lg:h-[96vh] lg:translate-x-0 lg:border-blue-300 lg:bg-blue-50"
                id="sidebar"
            >
                {{-- Glass gradient overlay --}}
                <div class="pointer-events-none absolute inset-0 rounded-3xl"></div>
                <div
                    class="bg-linear-to-r pointer-events-none absolute left-0 top-0 h-px w-full from-transparent via-white/60 to-transparent">
                </div>
                {{-- Scrollable content wrapper --}}
                <div class="relative z-10 flex h-full flex-col overflow-y-auto">
                    <div class="mb-4 hidden justify-center sm:block">
                        <img class="h-10" src="{{ asset('logo/rme-logo.png') }}" alt="logo">
                    </div>

                    <nav class="flex-1 overflow-y-auto">
                        <ul class="menu w-full ps-0">
                            <li>
                                <a class="{{ Str::startsWith(url()->current(), url('dashboard')) ? 'menu-active' : '' }}"
                                    href={{ route('dashboard') }} wire:navigate
                                >
                                    <i class="ti ti-home text-lg"></i>Dashboard</a>
                            </li>
                            <li>
                                <a class="{{ Str::startsWith(url()->current(), url('patient')) ? 'menu-active' : '' }}"
                                    href={{ route('patient.index') }} wire:navigate
                                >
                                    <i class="ti ti-user-plus text-lg"></i>Pasien</a>
                            </li>
                            <li>
                                <a class="{{ Str::startsWith(url()->current(), url('encounter')) ? 'menu-active' : '' }}"
                                    href={{ route('encounter.index') }} wire:navigate
                                >
                                    <i class="ti ti-calendar text-lg"></i>Kunjungan</a>
                            </li>

                            @role('administrator')
                                <h2 class="menu-title mt-4">Administrator</h2>
                                <li>
                                    <a class="{{ Str::startsWith(url()->current(), url('user')) ? 'menu-active' : '' }}"
                                        href={{ route('user') }} wire:navigate
                                    >
                                        <x-icon class="h-5 w-5" name="users" outline /> User</a>
                                </li>
                                <li>
                                    <a class="{{ Str::startsWith(url()->current(), url('role-permission')) ? 'menu-active' : '' }}"
                                        href={{ route('user.role_permission') }} wire:navigate
                                    >
                                        <i class="ti ti-lock-access text-lg"></i>ACL</a>
                                </li>
                            @endrole
                        </ul>
                    </nav>

                    <div class="mt-auto hidden pt-4 lg:block">
                        <div class="dropdown dropdown-top w-full rounded-lg ">
                            <div class="flex w-full cursor-pointer items-center justify-between rounded-lg bg-slate-200 hover:bg-slate-300"
                                role="button" tabindex="0"
                            >
                                <div class="flex items-center gap-2">
                                    <div class="bg-slate-300 flex h-8 w-8 items-center justify-center rounded-lg">
                                        <span class="text-black text-md font-bold uppercase">
                                            {{ substr(auth()->user()->name, 0, 2) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">{{ Auth::user()?->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <ul class="z-100 menu dropdown-content menu-sm rounded-box bg-base-100 my-3 w-full border border-slate-200 p-2"
                                tabindex="0"
                            >
                                <li>
                                    <a href="{{ route('account') }}" wire:navigate> <i class="ti ti-user-edit text-lg"></i> Akun
                                    </a>
                                </li>
                                <li>
                                    <a class="text-red-500 hover:bg-red-50 hover:text-red-600" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    >
                                        <i class="ti ti-logout text-lg"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>
        @endif

        <!-- Form logout tersembunyi -->
        <form class="hidden" id="logout-form" action="/logout" method="POST">
            @csrf
        </form>

        <!-- Overlay for mobile -->
        <div class="z-25 fixed inset-0 hidden lg:hidden" id="sidebar-overlay"></div>

        <div class="flex flex-1 flex-col">
            <!-- Mobile Header -->
            @auth()
                <header
                    class="sticky left-0 right-0 top-0 z-20 m-2 flex items-center justify-between rounded-3xl bg-white/10 p-1 shadow-[0_2px_6px_rgba(99,102,241,0.08),0_4px_10px_rgba(0,0,0,0.06)] backdrop-blur-2xl lg:hidden"
                >
                    <button class="btn btn-ghost btn-circle" id="hamburger-btn">
                        <svg
                            class="h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2 text-xl font-bold text-slate-900">
                        <a href="{{ route('dashboard') }}">
                            <div class="flex items-center justify-center">
                                <img class="h-8" src="{{ asset('logo/rme-logo.png') }}" alt="logo">
                            </div>
                        </a>
                    </div>
                    <div class="dropdown dropdown-end z-50">
                        <div class="btn btn-ghost btn-circle border-0" role="button" tabindex="0">
                            <x-icon class="h-6 w-6" name="user-circle" outline />
                        </div>
                        @auth
                            <ul class="z-100 menu dropdown-content menu-sm rounded-box bg-base-100 my-3 w-48 border border-slate-200 p-2"
                                tabindex="0"
                            >
                                <!-- User Info -->
                                <li class="py-1">
                                    <span class="my-0 font-semibold uppercase">{{ Auth::user()?->name }}</span>
                                    <span class="text-xs text-slate-500">{{ Auth::user()?->email }}</span>
                                </li>
                                <div class="divider m-0"></div>
                                <li>
                                    <a href="{{ route('account') }}" wire:navigate> <i class="ti ti-user-edit text-lg"></i> Akun </a>
                                </li>
                                <li>
                                    <a class="text-red-500 hover:bg-red-50 hover:text-red-600" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    >
                                        <i class="ti ti-logout text-lg"></i> Log out
                                    </a>
                                </li>
                            </ul>
                        @endauth
                    </div>
                </header>
            @endauth

            <!-- Main Content -->
            <main class="w-full flex-1 overflow-y-auto p-6 lg:ps-[64px]">

                {{ $slot }}

            </main>
        </div>

        @livewireScripts

    </div>
</body>

</html>
