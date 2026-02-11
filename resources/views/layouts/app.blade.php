<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <tallstackui:script />
</head>

<body style="background: 
    radial-gradient(ellipse at 50% 0%, oklch(74% 0.20 232.661 / 0.12) 0%, transparent 50%),
    radial-gradient(ellipse at 0% 100%, oklch(70% 0.22 232.661 / 0.18) 0%, transparent 60%),
    radial-gradient(ellipse at 20% 80%, oklch(78% 0.18 232.661 / 0.14) 0%, transparent 50%),
    radial-gradient(ellipse at 0% 60%, oklch(68% 0.16 232.661 / 0.10) 0%, transparent 45%),
    linear-gradient(
        160deg,
        transparent 40%,
        oklch(74% 0.20 232.661 / 0.08) 70%,
        oklch(70% 0.22 232.661 / 0.12) 100%
    );
">
    <x-toast />
    <x-dialog />

    <div class="relative min-h-screen w-full items-stretch bg-white lg:flex">
        <!-- Sidebar -->
        @if (Auth::check())
            <aside
                class="top-18 fixed bottom-3 left-0 z-30 h-[90vh] w-60 -translate-x-full transform flex-col overflow-hidden rounded-3xl border border-white/30 bg-white/20 p-4 pr-0 backdrop-blur-3xl transition-transform duration-300 ease-in-out lg:sticky lg:left-3 lg:top-3 lg:flex lg:h-[96vh] lg:translate-x-0 lg:border-white/40 lg:bg-white/25 lg:shadow-[0_2px_12px_rgba(99,102,241,0.08),0_4px_20px_rgba(0,0,0,0.06)]"
                id="sidebar"
            >
                {{-- Glass gradient overlay --}}
                <div class="pointer-events-none absolute inset-0 rounded-3xl"></div>
                <div
                    class="bg-linear-to-r pointer-events-none absolute left-0 top-0 h-px w-full from-transparent via-white/60 to-transparent">
                </div>
                {{-- Scrollable content wrapper --}}
                <div class="relative z-10 flex h-full flex-col overflow-y-auto">
                    <div class="mb-4 hidden sm:block">
                        <img class="h-10" src="{{ asset('icon/icon-long.png') }}" alt="logo">
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
                                <a><i class="ti ti-user-plus"></i>Parent</a>
                                <ul>
                                    <li><a>Submenu 1</a></li>
                                    <li><a>Submenu 1</a></li>
                                    <li><a>Submenu 2</a></li>
                                </ul>
                            </li>
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
                        </ul>
                    </nav>

                    <div class="mt-auto hidden pr-4 pt-4 lg:block">
                        <div class="dropdown dropdown-top w-full rounded-lg border border-slate-300">
                            <div class="flex w-full cursor-pointer items-center justify-between rounded-lg hover:bg-slate-200"
                                role="button" tabindex="0"
                            >
                                <div class="flex items-center gap-2">
                                    <div class="bg-base-600 flex h-8 w-8 items-center justify-center">
                                        <i class="ti ti-user text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">{{ Auth::user()?->name }}</p>
                                    </div>
                                </div>
                                <div class="pr-2">
                                    <i class="ti ti-chevron-up"></i>
                                </div>
                            </div>

                            <ul class="z-100 menu dropdown-content menu-sm rounded-box bg-base-100 my-3 w-full border border-slate-200 p-2"
                                tabindex="0"
                            >
                                <li>
                                    <a href="{{ route('account') }}" wire:navigate> <i class="ti ti-user-edit text-lg"></i> Pengaturan Akun
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
            <header
                class="sticky left-0 right-0 top-2 z-20 m-2 flex items-center justify-between rounded-3xl border-slate-200/50 bg-blue-100/30 p-2 shadow-[0_2px_12px_rgba(99,102,241,0.08),0_4px_20px_rgba(0,0,0,0.06)] backdrop-blur-2xl lg:hidden"
            >
                <button class="btn btn-ghost btn-circle" id="hamburger-btn">
                    <svg
                        class="h-5 w-5"
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
                            <img class="h-8" src="{{ asset('icon/icon-long.png') }}" alt="logo">
                        </div>
                    </a>
                </div>
                <div class="dropdown dropdown-end z-50">
                    <div class="btn btn-ghost btn-circle border-0" role="button" tabindex="0">
                        <i class="ti ti-user text-xl"></i>
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
                                <a href="{{ route('account') }}" wire:navigate> <i class="ti ti-user-edit text-lg"></i> Pengaturan Akun </a>
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

            <!-- Main Content -->
            <main class="w-full flex-1 overflow-y-auto p-6 lg:px-[64px]">

                {{ $slot }}

            </main>
        </div>

        @livewireScripts

    </div>
</body>

</html>
