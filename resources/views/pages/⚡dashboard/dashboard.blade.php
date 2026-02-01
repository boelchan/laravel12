<div class="space-y-6">
    <h1 class="text-2xl font-medium">{{ $title }}</h1>

    @if (!auth()->user()->hasVerifiedEmail())
        <div class="alert alert-vertical alert-warning sm:alert-horizontal shadow-sm" role="alert">
            <i class="ti ti-mail-exclamation text-2xl"></i>
            <div class="flex-1">
                <h3 class="font-bold">Verifikasi Email Diperlukan</h3>
                <div class="text-xs">Email Anda belum diverifikasi. Silahkan verifikasi untuk menikmati akses penuh.</div>
            </div>
            <a class="btn btn-warning btn-sm" href="{{ route('account') }}" wire:navigate>
                Ke Halaman Akun
            </a>
        </div>
    @endif

    @island(lazy: true)
        <div>
            Revenue

            <button class="btn" type="button" wire:click="$refresh">Refresh</button>
        </div>
    @endisland

</div>
