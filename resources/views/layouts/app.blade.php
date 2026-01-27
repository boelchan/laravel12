<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <wireui:scripts />
</head>

<body>
    <x-notifications position="top" solid />
    <x-dialog z-index="z-50" />

    <div class="relative min-h-screen w-full items-stretch md:flex xl:flex">
        <!-- Sidebar -->
        @if (Auth::check())
            <aside
                class="fixed left-0 top-0 z-30 h-screen w-64 -translate-x-full transform flex-col overflow-y-auto border-r border-slate-200 bg-slate-50 p-4 pr-0 transition-transform duration-300 ease-in-out md:sticky md:flex md:translate-x-0"
                id="sidebar"
            >
                <div class="mb-4 flex items-center">
                    <img class="h-10" src="{{ asset('icon/icon-long.png') }}" alt="logo">
                </div>

                <nav class="flex-1 overflow-y-auto">
                    <ul class="menu w-full">
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
                            <a class="{{ Str::startsWith(url()->current(), url('user')) ? 'menu-active' : '' }}" href={{ route('user') }}
                                wire:navigate
                            >
                                <i class="ti ti-users text-lg"></i>User</a>
                        </li>
                        <li>
                            <a class="{{ Str::startsWith(url()->current(), url('permission')) ? 'menu-active' : '' }}"
                                href={{ route('permission') }} wire:navigate
                            >
                                <i class="ti ti-lock-access text-lg"></i>Hak Akses</a>
                        </li>
                    </ul>
                </nav>

                <div class="mt-auto hidden pr-4 pt-4 sm:block">
                    <div class="dropdown dropdown-top w-full rounded-lg border border-slate-300">
                        <div class="flex w-full cursor-pointer items-center justify-between rounded-lg hover:bg-slate-200" role="button"
                            tabindex="0"
                        >
                            <div class="flex items-center gap-2">
                                <div class="bg-base-600 flex h-8 w-8 items-center justify-center">
                                    <i class="ti ti-user-circle text-xl"></i>
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
                            <li> <a href="" wire:navigate> <i class="ti ti-user text-lg"></i> Profil </a> </li>
                            <li> <a href="" wire:navigate> <i class="ti ti-lock text-lg"></i> Ubah Password </a>
                            </li>
                            <div class="divider m-0"></div>
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
            </aside>
        @endif

        <!-- Form logout tersembunyi -->
        <form class="hidden" id="logout-form" action="/logout" method="POST">
            @csrf
        </form>

        <!-- Overlay for mobile -->
        <div class="z-25 fixed inset-0 hidden bg-black/50 md:hidden" id="sidebar-overlay"></div>

        <div class="flex flex-1 flex-col">
            <!-- Mobile Header -->
            <header
                class="sticky left-0 right-0 top-0 z-20 flex items-center justify-between border-b border-slate-200 bg-white/30 p-2 backdrop-blur-lg md:hidden"
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
                            <li> <a href="" wire:navigate> <i class="ti ti-user text-lg"></i> Profil
                                </a> </li>
                            <li> <a href="" wire:navigate> <i class="ti ti-lock text-lg"></i> Ubah
                                    Password </a> </li>
                            <div class="divider m-0"></div>
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
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">

                {{ $slot }}

            </main>
        </div>

        @livewireScripts
    </div>
</body>

</html>
