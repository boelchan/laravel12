<div>
    <h1 class="text-2xl font-medium text-slate-900">Akun Saya</h1>
    <div class="breadcrumbs p-0 text-xs text-slate-500">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
            <li>Profil</li>
        </ul>
    </div>

    <div class="mt-6">
        {{-- Alerts --}}
        <div class="mb-6 space-y-3">
            @if (auth()->user()->status == 'inactive')
                <div class="alert alert-error">
                    <i class="ti ti-alert-triangle"></i>
                    <span>Akun Anda ditangguhkan. Hubungi admin untuk bantuan.</span>
                </div>
            @endif

            @if (!auth()->user()->hasVerifiedEmail())
                <div class="alert alert-warning">
                    <i class="ti ti-mail"></i>
                    <div class="flex-1">
                        <span>Email belum terverifikasi</span>
                        <div class="text-xs opacity-75">Verifikasi untuk akses penuh</div>
                    </div>
                    <button class="btn btn-sm btn-outline" wire:click="sendVerificationEmail" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="sendVerificationEmail">Kirim Ulang</span>
                        <span class="loading loading-spinner loading-xs" wire:loading wire:target="sendVerificationEmail"></span>
                    </button>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
            {{-- Profile Sidebar --}}
            <div class="lg:col-span-1">
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-body p-6">
                        {{-- Avatar --}}
                        <div class="flex flex-col items-center text-center">
                            <div class="avatar">
                                <div class="bg-primary/10 flex w-20 items-center justify-center rounded-full">
                                    <span class="text-primary text-2xl font-bold uppercase">
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h2 class="text-lg font-semibold">{{ auth()->user()->name }}</h2>
                                <p class="text-base-content/60 text-sm">{{ auth()->user()->email }}</p>
                                <div class="badge badge-soft {{ auth()->user()->status == 'active' ? 'badge-success' : 'badge-error' }}">
                                    {{ auth()->user()->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </div>
                            </div>
                        </div>

                        {{-- Navigation --}}
                        <div class="mt-6 space-y-1">
                            @php
                                $navs = [
                                    ['id' => 'summary', 'icon' => 'ti-user', 'label' => 'Profil'],
                                    ['id' => 'edit_name', 'icon' => 'ti-edit', 'label' => 'Ubah Profil'],
                                    ['id' => 'edit_email', 'icon' => 'ti-mail', 'label' => 'Email'],
                                    ['id' => 'edit_password', 'icon' => 'ti-lock', 'label' => 'Password'],
                                ];
                            @endphp

                            @foreach ($navs as $nav)
                                <button
                                    class="{{ $tab === $nav['id'] ? 'btn-primary' : 'btn-soft btn-primary' }} btn btn-sm w-full justify-start"
                                    wire:click="setTab('{{ $nav['id'] }}')"
                                >
                                    <i class="ti {{ $nav['icon'] }} mr-2 text-lg"></i>
                                    {{ $nav['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-body p-6">

                        {{-- Tab: Summary --}}
                        @if ($tab === 'summary')
                            <div>
                                <h3 class="mb-4 text-xl font-semibold">Informasi Profil</h3>

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div class="stat bg-base-200 rounded-lg">
                                        <div class="stat-figure text-primary">
                                            <i class="ti ti-user-circle text-2xl"></i>
                                        </div>
                                        <div class="stat-title">Nama Lengkap</div>
                                        <div class="font-bold">{{ auth()->user()->name }}</div>
                                    </div>

                                    <div class="stat bg-base-200 rounded-lg">
                                        <div class="stat-figure text-primary">
                                            <i class="ti ti-id text-2xl"></i>
                                        </div>
                                        <div class="stat-title">NIK</div>
                                        <div class="font-bold">{{ auth()->user()->nik ?? '-' }}</div>
                                    </div>

                                    <div class="stat bg-base-200 rounded-lg">
                                        <div class="stat-figure text-info">
                                            <i class="ti ti-mail text-2xl"></i>
                                        </div>
                                        <div class="stat-title">Email</div>
                                        <div class="font-bold">{{ auth()->user()->email }}</div>
                                        <div class="stat-desc">
                                            {{ auth()->user()->hasVerifiedEmail() ? 'Terverifikasi' : 'Belum verifikasi' }}</div>
                                    </div>

                                    <div class="stat bg-base-200 rounded-lg">
                                        <div class="stat-figure text-success">
                                            <i class="ti ti-shield-check text-2xl"></i>
                                        </div>
                                        <div class="stat-title">Status Akun</div>
                                        <div class="font-bold">{{ auth()->user()->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                        </div>
                                    </div>

                                    <div class="stat bg-base-200 rounded-lg">
                                        <div class="stat-figure text-warning">
                                            <i class="ti ti-calendar text-2xl"></i>
                                        </div>
                                        <div class="stat-title">Bergabung</div>
                                        <div class="font-bold">{{ auth()->user()->created_at->format('d M Y h:i') }}</div>
                                    </div>
                                </div>

                                @if (auth()->user()->roles->count() > 0)
                                    <div class="mt-6">
                                        <h4 class="mb-3 text-lg font-semibold">Peran Akses</h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach (auth()->user()->roles as $role)
                                                <div class="badge badge-soft badge-primary uppercase">{{ $role->name }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Form: Edit Name --}}
                        @if ($tab === 'edit_name')
                            <div>
                                <button class="btn btn-ghost btn-sm mb-4" wire:click="setTab('summary')">
                                    <i class="ti ti-arrow-left mr-2"></i>Kembali
                                </button>

                                <h3 class="mb-2 text-xl font-semibold">Ubah Profil</h3>
                                <p class="text-base-content/60 mb-6">Perbarui informasi profil Anda</p>

                                <form class="space-y-4" wire:submit="updateName">
                                    <x-input wire:model="name" label="Nama" />
                                    <x-input wire:model="nik" label="NIK" />

                                    <div class="flex gap-3 pt-4">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="ti ti-check mr-2"></i>Simpan
                                        </button>
                                        <button class="btn btn-ghost" type="button" wire:click="setTab('summary')">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        {{-- Form: Edit Email --}}
                        @if ($tab === 'edit_email')
                            <div>
                                <button class="btn btn-ghost btn-sm mb-4" wire:click="setTab('summary')">
                                    <i class="ti ti-arrow-left mr-2"></i>Kembali
                                </button>

                                <h3 class="mb-2 text-xl font-semibold">Ubah Email</h3>
                                <p class="text-base-content/60 mb-6">Perbarui alamat email utama Anda</p>

                                <div class="alert alert-warning mb-6">
                                    <i class="ti ti-alert-triangle"></i>
                                    <span>Mengubah email akan mengakhiri semua sesi login</span>
                                </div>

                                <form class="grid gap-4" wire:submit="updateEmail">
                                    <x-input type="email" label="Email Baru" placeholder="email@domain.com" wire:model="email" />

                                    <x-password placeholder="Masukkan password Anda" label="Masukkan Password saat ini"
                                        wire:model="password_for_email"
                                    />

                                    <div class="flex gap-3 pt-4">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="ti ti-check mr-2"></i>Update Email
                                        </button>
                                        <button class="btn btn-ghost" type="button" wire:click="setTab('summary')">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        {{-- Form: Edit Password --}}
                        @if ($tab === 'edit_password')
                            <div>
                                <button class="btn btn-ghost btn-sm mb-4" wire:click="setTab('summary')">
                                    <i class="ti ti-arrow-left mr-2"></i>Kembali
                                </button>

                                <h3 class="mb-2 text-xl font-semibold">Ubah Password</h3>
                                <p class="text-base-content/60 mb-6">Perbarui password keamanan akun Anda</p>

                                <form class="space-y-4" wire:submit="updatePassword">
                                    <x-password label="Password saat ini" wire:model="current_password" />

                                    <div class="divider">Password Baru</div>

                                    <x-password label="Password Baru" wire:model="password" />
                                    <x-password label="Konfirmasi Password" wire:model="password_confirmation" />

                                    <div class="flex gap-3 pt-4">
                                        <button class="btn btn-error" type="submit">
                                            <i class="ti ti-lock mr-2"></i>Update Password
                                        </button>
                                        <button class="btn btn-ghost" type="button" wire:click="setTab('summary')">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
