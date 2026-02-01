<div class="mx-auto max-w-6xl px-4 py-6">
    {{-- Top Heading --}}
    <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-end">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Profil Akun</h1>
            <p class="mt-1 font-medium italic text-slate-500">Kelola identitas dan keamanan akses sistem Anda</p>
        </div>
        <div
            class="flex items-center rounded-full border border-slate-200 bg-slate-100 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-400 shadow-sm">
            <i class="ti ti-shield-check text-primary mr-2"></i> Authorized Session Only
        </div>
    </div>

    {{-- System Alerts --}}
    <div class="mb-8 space-y-4">
        @if (auth()->user()->status == 'inactive')
            <div class="alert flex items-center gap-4 rounded-3xl border-rose-100 bg-rose-50 py-4 text-rose-800 shadow-sm">
                <div class="rounded-xl bg-rose-500 p-2 text-white shadow-md shadow-rose-200">
                    <i class="ti ti-lock-off text-xl"></i>
                </div>
                <div class="flex-1 text-sm font-semibold">Akun Anda saat ini ditangguhkan. Silakan hubungi admin IT.</div>
            </div>
        @endif

        @if (!auth()->user()->hasVerifiedEmail())
            <div class="alert flex items-center gap-4 rounded-2xl border-amber-100 bg-amber-50 py-4 text-amber-800 shadow-sm">
                <div class="rounded-xl bg-amber-500 p-2 text-white shadow-md shadow-amber-200">
                    <i class="ti ti-mail-bolt animate-pulse text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold">Email Belum Terverifikasi</p>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-amber-600">Segera verifikasi untuk akses penuh</p>
                </div>
                <button class="btn btn-sm rounded-lg border-amber-200 bg-white normal-case text-amber-700 shadow-sm hover:bg-amber-100"
                    wire:click="sendVerificationEmail" wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="sendVerificationEmail">Kirim Ulang Link</span>
                    <span class="loading loading-spinner loading-xs" wire:loading wire:target="sendVerificationEmail"></span>
                </button>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
        {{-- Profile Card Sidebar --}}
        <div class="lg:sticky lg:top-8 lg:col-span-4 xl:col-span-3">
            <div class="group overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-2xl shadow-slate-200/40">
                {{-- Cover Image --}}
                <div class="via-primary relative h-32 bg-gradient-to-tr from-indigo-600 to-violet-500">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20">
                    </div>
                </div>

                {{-- Profile Info --}}
                <div class="relative px-6 pb-8">
                    <div class="-mt-16 mb-6 flex justify-center">
                        <div class="relative inline-block">
                            <!-- Premium Avatar Frame -->
                            <div
                                class="h-32 w-32 transform rounded-[2.5rem] bg-white p-2 shadow-2xl ring-1 ring-slate-100 transition-transform duration-500 hover:rotate-3">
                                <div
                                    class="relative flex h-full w-full items-center justify-center overflow-hidden rounded-[2rem] border border-slate-100 bg-slate-50">
                                    <!-- Center Alignment Fix -->
                                    <span
                                        class="relative z-10 flex h-full w-full select-none items-center justify-center text-4xl font-black uppercase tracking-tighter text-slate-800"
                                    >
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </span>
                                    <div class="absolute inset-0 bg-gradient-to-br from-white/40 to-transparent"></div>
                                </div>
                            </div>
                            <!-- Enhanced Status Indicator -->
                            <div class="absolute bottom-0 right-0 translate-x-2 translate-y-2 transform">
                                <div
                                    class="{{ auth()->user()->status === 'active' ? 'bg-emerald-500' : 'bg-rose-500' }} animate-in zoom-in slide-in-from-bottom-2 flex h-10 w-10 items-center justify-center rounded-2xl border-4 border-white shadow-xl duration-700">
                                    <i
                                        class="ti {{ auth()->user()->status === 'active' ? 'ti-circle-check' : 'ti-circle-x' }} text-lg text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <h2 class="mb-2 text-2xl font-black leading-none tracking-tight text-slate-900">{{ auth()->user()->name }}</h2>
                        <div class="mb-4 flex items-center justify-center gap-2">
                            <span
                                class="rounded-md border border-slate-200 bg-slate-100 px-2 py-0.5 text-[9px] font-black uppercase tracking-widest text-slate-500"
                            >
                                UID: {{ str_pad(auth()->id(), 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <p
                            class="truncate rounded-xl border border-slate-100/50 bg-slate-50 px-4 py-2 text-xs font-semibold text-slate-400">
                            {{ auth()->user()->email }}</p>
                    </div>

                    {{-- Navigation Sidebar --}}
                    <div class="mt-10 space-y-2">
                        @php
                            $navs = [
                                ['id' => 'summary', 'icon' => 'ti-layout-grid-add', 'label' => 'Profil'],
                                ['id' => 'edit_name', 'icon' => 'ti-user-edit', 'label' => 'Ubah Nama'],
                                ['id' => 'edit_email', 'icon' => 'ti-mail-fast', 'label' => 'Ganti Email'],
                                ['id' => 'edit_password', 'icon' => 'ti-shield-lock', 'label' => 'Keamanan'],
                            ];
                        @endphp

                        @foreach ($navs as $nav)
                            <button
                                class="{{ $tab === $nav['id'] ? 'bg-primary text-white shadow-xl shadow-primary/30 active:scale-[0.98]' : 'hover:bg-slate-50 text-slate-500 active:scale-95' }} flex w-full items-center gap-4 rounded-2xl px-5 py-4 transition-all duration-300"
                                wire:click="setTab('{{ $nav['id'] }}')"
                            >
                                <div
                                    class="{{ $tab === $nav['id'] ? 'bg-white/20' : 'bg-slate-100 border border-slate-200/50' }} flex h-10 w-10 items-center justify-center rounded-xl shadow-sm transition-all">
                                    <i class="ti {{ $nav['icon'] }} text-xl"></i>
                                </div>
                                <span class="text-[13px] font-bold tracking-tight">{{ $nav['label'] }}</span>
                                @if ($tab === $nav['id'])
                                    <i class="ti ti-chevron-right animate-in slide-in-from-left-2 ml-auto text-white/50"></i>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Window --}}
        <div class="lg:col-span-8 xl:col-span-9">
            <div class="relative flex min-h-[620px] flex-col overflow-hidden rounded-[2.5rem] border border-slate-200 bg-white shadow-sm">
                <div class="flex-1 p-8 md:p-14">

                    {{-- Tab: Summary --}}
                    @if ($tab === 'summary')
                        <div class="flex h-full animate-[fadeIn_0.5s_ease-out] flex-col">
                            <div class="mb-16 flex flex-col justify-between gap-6 md:flex-row md:items-center">
                                <div>
                                    <h3 class="mb-3 text-3xl font-black leading-none tracking-tight text-slate-900">Informasi Utama</h3>
                                    <p class="text-sm font-medium text-slate-400">Review detail profil dan status keamanan sistem Anda.</p>
                                </div>
                                <div class="flex items-center gap-4 rounded-3xl border border-slate-100 bg-slate-50 p-4">
                                    <div
                                        class="text-primary flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-200 bg-white shadow-sm">
                                        <i class="ti ti-calendar-time text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-[9px] font-black uppercase leading-none tracking-widest text-slate-400">Dibuat
                                            Pada</p>
                                        <p class="text-sm font-black text-slate-800">{{ auth()->user()->created_at->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-10 md:grid-cols-2">
                                {{-- Left Column Details --}}
                                <div class="space-y-10">
                                    <div class="space-y-3">
                                        <label class="ml-1 text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">Profile
                                            Identity</label>
                                        <div
                                            class="hover:border-primary/20 group rounded-3xl border border-slate-100 bg-slate-50 p-6 transition-all duration-500 hover:bg-white hover:shadow-2xl hover:shadow-slate-200">
                                            <div class="mb-5 flex items-center gap-5">
                                                <div
                                                    class="group-hover:text-primary flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-md transition-colors">
                                                    <i class="ti ti-user-circle text-3xl"></i>
                                                </div>
                                                <div>
                                                    <p class="mb-2 text-xl font-black leading-none tracking-tight text-slate-800">
                                                        {{ auth()->user()->name }}</p>
                                                    <p class="text-xs font-bold text-slate-400">Nama Resmi Terdaftar</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 border-t border-slate-200/60 pt-4">
                                                <span
                                                    class="{{ auth()->user()->status == 'active' ? 'bg-emerald-500' : 'bg-rose-500' }} h-2 w-2 rounded-full"
                                                ></span>
                                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Akun
                                                    {{ auth()->user()->status }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <label class="ml-1 text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">Communication
                                            ID</label>
                                        <div
                                            class="hover:border-primary/20 group rounded-3xl border border-slate-100 bg-slate-50 p-6 transition-all duration-500 hover:bg-white hover:shadow-2xl hover:shadow-slate-200">
                                            <div class="flex items-center gap-5">
                                                <div
                                                    class="group-hover:text-primary flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-md transition-colors">
                                                    <i class="ti ti-mail-check text-3xl"></i>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="mb-2 truncate text-xl font-black tracking-tight text-slate-800">
                                                        {{ auth()->user()->email }}</p>
                                                    <p class="text-xs font-bold text-slate-400">Email Utama </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Right Column Details --}}
                                <div class="space-y-10">
                                    <div class="space-y-3">
                                        <label class="ml-1 text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">Role
                                            Privileges</label>
                                        <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                                            <div class="mb-5 flex items-center gap-5">
                                                <div
                                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-md">
                                                    <i class="ti ti-shield-half text-3xl"></i>
                                                </div>
                                                <p class="text-[13px] font-black uppercase tracking-widest text-slate-800">Otoritas Akses
                                                </p>
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach (auth()->user()->roles as $role)
                                                    <div
                                                        class="flex items-center gap-2 rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-2 text-[10px] font-black uppercase tracking-[0.1em] text-indigo-600">
                                                        <i class="ti ti-lock-access-off opacity-40"></i> {{ $role->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <label class="ml-1 text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">Verification
                                            Status</label>
                                        <div
                                            class="{{ auth()->user()->hasVerifiedEmail() ? 'bg-emerald-50/50 border-emerald-100 text-emerald-900 group' : 'bg-amber-50/50 border-amber-100 text-amber-900 shadow-amber-200/20' }} flex items-center gap-5 rounded-3xl border p-6 shadow-xl transition-all">
                                            <div
                                                class="{{ auth()->user()->hasVerifiedEmail() ? 'bg-emerald-500 text-white' : 'bg-amber-500 text-white' }} flex h-16 w-16 transform items-center justify-center rounded-2xl shadow-lg transition-transform group-hover:scale-110">
                                                <i
                                                    class="ti {{ auth()->user()->hasVerifiedEmail() ? 'ti-shield-check' : 'ti-shield-bolt' }} text-3xl"></i>
                                            </div>
                                            <div>
                                                <p class="mb-2 text-xl font-black leading-none tracking-tight">
                                                    {{ auth()->user()->hasVerifiedEmail() ? 'Identity Verified' : 'Unverified Identity' }}
                                                </p>
                                                <p
                                                    class="{{ auth()->user()->hasVerifiedEmail() ? 'text-emerald-600/60' : 'text-amber-600/60' }} text-xs font-bold">
                                                    {{ auth()->user()->hasVerifiedEmail() ? 'Lulus Otentikasi Email' : 'Resiko Akses Terbatas' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Summary Footer CTA --}}
                            <div class="mt-auto pt-16">
                                <div
                                    class="group relative flex flex-col items-center justify-between gap-6 overflow-hidden rounded-[2rem] bg-indigo-600 p-8 text-white shadow-2xl shadow-indigo-600/30 md:flex-row">
                                    <div
                                        class="absolute inset-0 animate-[shimmer_5s_infinite_linear] bg-[linear-gradient(45deg,transparent_25%,rgba(255,255,255,0.05)_50%,transparent_75%)] bg-[length:250%_250%]">
                                    </div>
                                    <div class="relative z-10 flex items-center gap-6">
                                        <div
                                            class="flex h-16 w-16 items-center justify-center rounded-2xl border border-white/20 bg-white/20 backdrop-blur-md">
                                            <i class="ti ti-edit text-3xl"></i>
                                        </div>
                                        <div class="text-center md:text-left">
                                            <h4 class="mb-1 text-xl font-black">Butuh penyesuaian data?</h4>
                                            <p class="text-xs font-medium text-indigo-100/70">Ubah nama profil atau email
                                                Anda.</p>
                                        </div>
                                    </div>
                                    <button
                                        class="btn relative z-10 h-12 rounded-2xl border-none bg-white px-8 font-black normal-case text-indigo-600 shadow-lg transition-transform hover:bg-slate-100 active:scale-95"
                                        wire:click="setTab('edit_name')"
                                    >
                                        Buka Pengaturan
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Form: Edit Name --}}
                    @if ($tab === 'edit_name')
                        <div class="max-w-xl animate-[slideRight_0.4s_ease-out]">
                            <button
                                class="hover:text-primary group mb-12 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 transition-colors"
                                wire:click="setTab('summary')"
                            >
                                <i class="ti ti-arrow-left text-xl transition-transform group-hover:-translate-x-1"></i> Kembali
                            </button>

                            <div class="mb-12 flex items-center gap-6">
                                <div
                                    class="bg-primary/10 text-primary border-primary/5 flex h-20 w-20 items-center justify-center rounded-3xl border shadow-inner">
                                    <i class="ti ti-user-edit text-4xl"></i>
                                </div>
                                <div>
                                    <h3 class="mb-3 text-3xl font-black leading-none tracking-tight text-slate-900">Profil Saya</h3>
                                    <p class="text-sm font-medium leading-relaxed text-slate-400">Pastikan nama sesuai dengan identitas
                                        resmi untuk keperluan laporan medis.</p>
                                </div>
                            </div>

                            <form class="space-y-10" wire:submit="updateName">
                                <x-input label="Nama Lengkap Baru" placeholder="Misal: John Doe" wire:model="name" />

                                <div class="flex flex-col items-center gap-4 border-t border-slate-100 pt-10 sm:flex-row">
                                    <button
                                        class="btn btn-primary shadow-primary/30 h-14 rounded-2xl px-10 font-black normal-case shadow-xl"
                                        type="submit" spinner="updateName"
                                    >
                                        Simpan Perubahan
                                    </button>
                                    <button class="btn btn-ghost h-14 rounded-2xl px-10 font-black text-slate-400" type="button"
                                        wire:click="setTab('summary')"
                                    >Batal</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    {{-- Form: Edit Email --}}
                    @if ($tab === 'edit_email')
                        <div class="max-w-xl animate-[slideRight_0.4s_ease-out]">
                            <button
                                class="hover:text-primary group mb-12 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 transition-colors"
                                wire:click="setTab('summary')"
                            >
                                <i class="ti ti-arrow-left text-xl transition-transform group-hover:-translate-x-1"></i> Kembali
                            </button>

                            <div class="mb-10 flex items-center gap-6">
                                <div
                                    class="flex h-20 w-20 items-center justify-center rounded-3xl border border-indigo-100 bg-indigo-50 text-indigo-500">
                                    <i class="ti ti-mail-fast text-4xl"></i>
                                </div>
                                <div>
                                    <h3 class="mb-3 text-3xl font-black leading-none tracking-tight text-slate-900">Update Email</h3>
                                    <p class="text-sm font-medium text-slate-400">Update email dan login utama Anda.</p>
                                </div>
                            </div>

                            <div class="alert mb-10 flex items-start gap-4 rounded-3xl border border-amber-100 bg-amber-50 p-6">
                                <i class="ti ti-shield-alert text-2xl text-amber-500"></i>
                                <div class="text-[11px] font-bold uppercase leading-relaxed tracking-wider text-amber-900">
                                    Tindakan ini akan mengakhiri semua sesi Anda. Verifikasi email baru diperlukan untuk akses kembali.
                                </div>
                            </div>

                            <form class="space-y-8" wire:submit="updateEmail">
                                <div class="space-y-6">
                                    <x-input label="Alamat Email Baru" placeholder="email@domain.com" wire:model="email" />
                                    <x-password label="Konfirmasi Password Saat Ini" placeholder="••••••••"
                                        wire:model="password_for_email"
                                    />
                                </div>

                                <div class="flex flex-col items-center gap-4 border-t border-slate-100 pt-10 sm:flex-row">
                                    <button
                                        class="btn btn-primary shadow-primary/30 h-14 rounded-2xl px-10 font-black normal-case shadow-xl"
                                        type="submit" spinner="updateEmail"
                                    >
                                        Update & Verifikasi
                                    </button>
                                    <button class="btn btn-ghost h-14 rounded-2xl px-10 font-black text-slate-400" type="button"
                                        wire:click="setTab('summary')"
                                    >Batal</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    {{-- Form: Edit Password --}}
                    @if ($tab === 'edit_password')
                        <div class="max-w-xl animate-[slideRight_0.4s_ease-out]">
                            <button
                                class="hover:text-primary group mb-12 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 transition-colors"
                                wire:click="setTab('summary')"
                            >
                                <i class="ti ti-arrow-left text-xl transition-transform group-hover:-translate-x-1"></i> Kembali
                            </button>

                            <div class="mb-12 flex items-center gap-6 text-rose-500">
                                <div
                                    class="flex h-20 w-20 items-center justify-center rounded-3xl border border-rose-100 bg-rose-50 text-rose-500">
                                    <i class="ti ti-lock-square text-4xl"></i>
                                </div>
                                <div class="text-slate-900">
                                    <h3 class="mb-3 text-3xl font-black leading-none tracking-tight">Keamanan Sandi</h3>
                                    <p class="text-sm font-medium leading-relaxed text-slate-400">Update kata sandi Anda secara berkala
                                        untuk proteksi akun maksimal.</p>
                                </div>
                            </div>

                            <form class="space-y-10" wire:submit="updatePassword">
                                <div class="space-y-8">
                                    <x-password label="Password Saat Ini" placeholder="••••••••" wire:model="current_password" />

                                    <div class="divider py-6 text-[9px] font-black uppercase tracking-[0.3em] text-slate-300">Identity
                                        Shield Protection</div>

                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <x-password label="Password Baru" placeholder="Min. 8 Karakter" wire:model="password" />
                                        <x-password label="Konfirmasi Baru" placeholder="Ulangi Sandi"
                                            wire:model="password_confirmation" />
                                    </div>
                                </div>

                                <div class="flex flex-col items-center gap-4 border-t border-slate-100 pt-12 sm:flex-row">
                                    <button
                                        class="btn btn-error h-14 rounded-2xl px-10 font-black normal-case text-white shadow-xl shadow-rose-200"
                                        type="submit" spinner="updatePassword"
                                    >
                                        Update Security Shield
                                    </button>
                                    <button class="btn btn-ghost h-14 rounded-2xl px-10 font-black text-slate-400" type="button"
                                        wire:click="setTab('summary')"
                                    >Batal</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>

                {{-- Window Footer Decorative --}}
                <div class="flex flex-col items-center justify-between gap-4 border-t border-slate-100 bg-slate-50 p-8 md:flex-row">
                    <div class="flex items-center gap-3">
                        <div class="rounded-xl border border-slate-200 bg-white p-2 text-slate-400">
                            <i class="ti ti-shield-lock text-xl"></i>
                        </div>
                        <div class="text-[9px] font-black uppercase tracking-widest text-slate-400">
                            <span class="text-emerald-500">Encrypted</span> Session Protocol v2.4
                        </div>
                    </div>
                    <div class="flex gap-4 opacity-50 grayscale">
                        <i class="ti ti-brand-google-analytics text-xl"></i>
                        <i class="ti ti-brand-carbon text-xl"></i>
                        <i class="ti ti-brand-cloudflare text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideRight {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }
    </style>
</div>
