<div>
    <h1 class="text-2xl font-medium text-slate-900">
        Akun Saya
        @if (auth()->user()->status == 'active')
            <span class="badge badge-success badge-soft">Aktif</span>
        @else
            <span class="badge badge-error badge-soft">Tidak Aktif</span>
        @endif
    </h1>
    <div class="breadcrumbs p-0 text-xs text-slate-500">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
            <li>Akun</li>
            <li>Edit</li>
        </ul>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
        <!-- Edit Profile -->
        <div class="card border border-slate-200 bg-white shadow-sm">
            <div class="card-body p-6">
                <h2 class="card-title mb-4 text-lg font-medium text-slate-900">Edit Profil</h2>

                <form class="space-y-4" wire:submit="updateProfile">
                    <x-input label="Nama" wire:model="name" />
                    <x-input type="email" label="Email" wire:model="email" />

                    <div class="mt-4 flex justify-end">
                        <x-button type="submit" primary label="Simpan Perubahan" spinner="updateProfile" />
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Password -->
        <div class="card border border-slate-200 bg-white shadow-sm">
            <div class="card-body p-6">
                <h2 class="card-title mb-4 text-lg font-medium text-slate-900">Ubah Password</h2>

                <form class="space-y-4" wire:submit="updatePassword">
                    <x-input type="password" label="Password Saat Ini" wire:model="current_password" />
                    <x-input type="password" label="Password Baru" wire:model="password" />
                    <x-input type="password" label="Konfirmasi Password Baru" wire:model="password_confirmation" />

                    <div class="mt-4 flex justify-end">
                        <x-button type="submit" warning label="Ubah Password" spinner="updatePassword" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
