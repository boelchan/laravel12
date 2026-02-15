<div>
    <div class="absolute left-1/2 top-1/2 w-full -translate-x-1/2 -translate-y-1/2 p-3">
        <div class="align-center mx-auto max-w-96">
            {{-- <img src="{{ asset('icon/icon-long.png') }}" alt="logo" class="h-10 mx-auto mb-1"> --}}
            <div class="text-center">
                Rekam Medis Elektronik
            </div>
        </div>
        <div class="bg-base-100/60 card relative z-10 mx-auto mt-8 w-full max-w-96 border border-slate-200 backdrop-blur-lg">
            <div class="card-body">
                <h2 class="card-title mb-3">Login</h2>
                <form class="grid gap-4" wire:submit="authenticate">

                    <x-input type="email" label="Email" wire:model="email" />
                    <x-password label="Password" wire:model="password" />
                    <x-checkbox label="Remember me" wire:model="remember" />
                    <button class="btn btn-primary btn-block btn-circle">
                        Login
                        <div class="loading loading-spinner" wire:loading>Loading...</div>
                    </button>
                </form>

                @if (Route::has('register'))
                    <div class="divider">OR</div>
                    <a class="btn btn-link" href="{{ route('register') }}">Belum punya akun? Daftar</a>
                @endif
            </div>
        </div>
        <div
            class='z-1 pointer-events-none absolute bottom-0 left-0 right-0 h-[60vh] w-full bg-gradient-to-br from-cyan-200 via-indigo-800 to-violet-300 opacity-30 blur-[200px]'>
        </div>
    </div>

</div>
