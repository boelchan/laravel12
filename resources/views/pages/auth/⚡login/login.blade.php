<div>
    <div class="absolute left-1/2 top-1/2 w-full -translate-x-1/2 -translate-y-1/2 p-3">
        <div class="mx-auto max-w-96 align-center">
            {{-- <img src="{{ asset('icon/icon-long.png') }}" alt="logo" class="h-10 mx-auto mb-1"> --}}
            <div class="text-center">
                Rekam Medis Elektronik
            </div>
            <div class="text-center mt-5">
                Praktek Dokter
            </div>
            <div class="text-center">
                dr. WONGSO SUHENDRO, SpOG
            </div>
        </div>
        <div
            class="bg-base-100/60 card relative z-10 mx-auto mt-8 w-full max-w-96 border border-slate-200 backdrop-blur-lg">
            <div class="card-body">
                <h2 class="card-title mb-3">Login</h2>
                <form wire:submit="authenticate">
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Email</legend>
                        <input type="email" placeholder="Email" class="input input-primary w-full" wire:model="email">
                        @error('email')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    <fieldset class="fieldset">
                        <div class="flex-2 flex justify-between">
                            <legend class="fieldset-legend">Password</legend>
                            {{-- <a href="{{ route('password.request') }}" class="btn btn-link p-0 btn-sm">Lupa password ?</a> --}}
                        </div>

                        <input type="password" placeholder="Password" class="input input-primary w-full"
                            wire:model="password"
                        >
                        @error('password')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    <label class="label mt-4 cursor-pointer">
                        <span class="label-text">Remember me</span>
                        <input type="checkbox" class="toggle toggle-primary" wire:model="remember" />
                    </label>

                    <button class="btn btn-primary btn-block btn-circle mt-6">Login</button>
                </form>

                @if (Route::has('register'))
                    <div class="divider">OR</div>
                    <a href="{{ route('register') }}" class="btn btn-link">Belum punya akun? Daftar</a>
                @endif
            </div>
        </div>
        <div
            class='pointer-events-none absolute bottom-0 left-0 right-0 z-[1] h-[60vh] w-full bg-gradient-to-br from-cyan-200 via-indigo-800 to-violet-300 opacity-30 blur-[200px]'>
        </div>
    </div>

</div>
