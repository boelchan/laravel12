<div class="min-h-screen bg-base-200">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-base-content">Akun Saya</h1>
            <p class="text-base-content/60 mt-1">Kelola informasi profil dan keamanan akun Anda</p>
        </div>

        {{-- Alerts --}}
        <div class="mb-6 space-y-3">
            @if (auth()->user()->status == 'inactive')
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle"></i>
                    <span>Akun Anda ditangguhkan. Hubungi admin untuk bantuan.</span>
                </div>
            @endif

            @if (!auth()->user()->hasVerifiedEmail())
                <div class="alert alert-info">
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

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            {{-- Profile Sidebar --}}
            <div class="lg:col-span-1">
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-body p-6">
                        {{-- Avatar --}}
                        <div class="flex flex-col items-center text-center">
                            <div class="avatar">
                                <div class="w-20 rounded-full bg-primary/10 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-primary">
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h2 class="text-lg font-semibold">{{ auth()->user()->name }}</h2>
                                <p class="text-sm text-base-content/60">{{ auth()->user()->email }}</p>
                                <div class="badge badge-ghost badge-sm mt-2">
                                    {{ auth()->user()->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </div>
                            </div>
                        </div>

                        {{-- Navigation --}}
                        <div class="mt-6 space-y-1">
                            @php
                                $navs = [
                                    ['id' => 'summary', 'icon' => 'ti-user', 'label' => 'Profil'],
                                    ['id' => 'edit_name', 'icon' => 'ti-edit', 'label' => 'Ubah Nama'],
                                    ['id' => 'edit_email', 'icon' => 'ti-mail', 'label' => 'Email'],
                                    ['id' => 'edit_password', 'icon' => 'ti-lock', 'label' => 'Password'],
                                ];
                            @endphp

                            @foreach ($navs as $nav)
                                <button
                                    class="{{ $tab === $nav['id'] ? 'btn-primary' : 'btn-ghost' }} btn btn-sm w-full justify-start"
                                    wire:click="setTab('{{ $nav['id'] }}')"
                                >
                                    <i class="ti {{ $nav['icon'] }} mr-2"></i>
                                    {{ $nav['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-3">
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-body p-6">

                    {{-- Tab: Summary --}}
                        @if ($tab === 'summary')
                            <div>
                                <h3 class="text-xl font-semibold mb-4">Informasi Profil</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="stat bg-base-200 rounded-lg">
                                        <div class="stat-figure text-primary">
                                            <i class="ti ti-user text-2xl"></i>
                                        </div>
                                        <div class="stat-title">Nama Lengkap</div>
                                        <div class="stat-value text-lg">{{ auth()->user()->name }}</div>
                                        <div class="stat-desc">Identitas resmi terdaftar</div>
                                    </div>
                                    
                                    <div class="stat bg-base-200 rounded-lg">
                                        <div class="stat-figure text-info">
                                            <i class="ti ti-mail text-2xl"></i>
                                        </div>
                                        <div class="stat-title">Email</div>
                                        <div class="stat-value text-lg truncate">{{ auth()->user()->email }}</div>
                                        <div class="stat-desc">{{ auth()->user()->hasVerifiedEmail() ? 'Terverifikasi' : 'Belum verifikasi' }}</div>
                                    </div>
                                    
                                    <div class="stat bg-base-200 rounded-lg">
                                        <div class="stat-figure text-success">
                                            <i class="ti ti-shield-check text-2xl"></i>
                                        </div>
                                        <div class="stat-title">Status Akun</div>
                                        <div class="stat-value text-lg">{{ auth()->user()->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}</div>
                                        <div class="stat-desc">Status akses sistem</div>
                                    </div>
                                    
                                    <div class="stat bg-base-200 rounded-lg">
                                        <div class="stat-figure text-warning">
                                            <i class="ti ti-calendar text-2xl"></i>
                                        </div>
                                        <div class="stat-title">Bergabung</div>
                                        <div class="stat-value text-lg">{{ auth()->user()->created_at->format('d M Y') }}</div>
                                        <div class="stat-desc">Tanggal pendaftaran</div>
                                    </div>
                                </div>

                                @if (auth()->user()->roles->count() > 0)
                                    <div class="mt-6">
                                        <h4 class="text-lg font-semibold mb-3">Peran Akses</h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach (auth()->user()->roles as $role)
                                                <div class="badge badge-primary">{{ $role->name }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-8">
                                    <button class="btn btn-primary" wire:click="setTab('edit_name')">
                                        <i class="ti ti-edit mr-2"></i>
                                        Edit Profil
                                    </button>
                                </div>
                            </div>
                    @endif

                    {{-- Form: Edit Name --}}
                        @if ($tab === 'edit_name')
                            <div>
                                <button class="btn btn-ghost btn-sm mb-4" wire:click="setTab('summary')">
                                    <i class="ti ti-arrow-left mr-2"></i>Kembali
                                </button>
                                
                                <h3 class="text-xl font-semibold mb-2">Ubah Nama</h3>
                                <p class="text-base-content/60 mb-6">Perbarui nama lengkap profil Anda</p>

                                <form class="space-y-4" wire:submit="updateName">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Nama Lengkap</span>
                                        </label>
                                        <input type="text" 
                                               class="input input-bordered w-full" 
                                               placeholder="Masukkan nama baru"
                                               wire:model="name" />
                                    </div>

                                    <div class="flex gap-3 pt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-check mr-2"></i>Simpan
                                        </button>
                                        <button type="button" class="btn btn-ghost" wire:click="setTab('summary')">
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
                                
                                <h3 class="text-xl font-semibold mb-2">Ubah Email</h3>
                                <p class="text-base-content/60 mb-6">Perbarui alamat email utama Anda</p>

                                <div class="alert alert-warning mb-6">
                                    <i class="ti ti-alert-triangle"></i>
                                    <span>Mengubah email akan mengakhiri semua sesi login</span>
                                </div>

                                <form class="space-y-4" wire:submit="updateEmail">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Email Baru</span>
                                        </label>
                                        <input type="email" 
                                               class="input input-bordered w-full" 
                                               placeholder="email@domain.com"
                                               wire:model="email" />
                                    </div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Password Saat Ini</span>
                                        </label>
                                        <input type="password" 
                                               class="input input-bordered w-full" 
                                               placeholder="Masukkan password"
                                               wire:model="password_for_email" />
                                    </div>

                                    <div class="flex gap-3 pt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-check mr-2"></i>Update Email
                                        </button>
                                        <button type="button" class="btn btn-ghost" wire:click="setTab('summary')">
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
                                
                                <h3 class="text-xl font-semibold mb-2">Ubah Password</h3>
                                <p class="text-base-content/60 mb-6">Perbarui password keamanan akun Anda</p>

                                <form class="space-y-4" wire:submit="updatePassword">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Password Saat Ini</span>
                                        </label>
                                        <input type="password" 
                                               class="input input-bordered w-full" 
                                               placeholder="Masukkan password lama"
                                               wire:model="current_password" />
                                    </div>

                                    <div class="divider">Password Baru</div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Password Baru</span>
                                        </label>
                                        <input type="password" 
                                               class="input input-bordered w-full" 
                                               placeholder="Minimal 8 karakter"
                                               wire:model="password" />
                                    </div>

                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Konfirmasi Password</span>
                                        </label>
                                        <input type="password" 
                                               class="input input-bordered w-full" 
                                               placeholder="Ulangi password baru"
                                               wire:model="password_confirmation" />
                                    </div>

                                    <div class="flex gap-3 pt-4">
                                        <button type="submit" class="btn btn-error">
                                            <i class="ti ti-lock mr-2"></i>Update Password
                                        </button>
                                        <button type="button" class="btn btn-ghost" wire:click="setTab('summary')">
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
