<div>
    <h1 class="text-2xl font-medium text-slate-900"> Akun Saya </h1>
    <div class="breadcrumbs p-0 text-xs text-slate-500">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
            <li>Akun</li>
            <li>Edit</li>
        </ul>
    </div>

    @if (auth()->user()->status == 'inactive')
        <div class="alert alert-vertical alert-error sm:alert-horizontal mt-6" role="alert">
            <i class="ti ti-alert-triangle text-2xl"></i>
            <div>
                <h3 class="font-bold">Akun Anda Tidak Aktif</h3>
                <div class="text-xs">Silahkan hubungi admin untuk mengaktifkan akun Anda.</div>
            </div>
        </div>
    @endif

    @if (!auth()->user()->hasVerifiedEmail())
        <div class="alert alert-vertical alert-warning sm:alert-horizontal mt-6" role="alert">
            <i class="ti ti-mail-exclamation text-2xl"></i>
            <div class="flex-1">
                <h3 class="font-bold">Email Belum Terverifikasi</h3>
                <div class="text-xs">Silahkan verifikasi email Anda untuk mengaktifkan semua fitur.</div>
            </div>
            <button class="btn btn-warning btn-sm" type="button" wire:click="sendVerificationEmail" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="sendVerificationEmail">Kirim Ulang Verifikasi</span>
                <span wire:loading wire:target="sendVerificationEmail">Mengirim...</span>
            </button>
        </div>
    @endif

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
