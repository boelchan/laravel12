<div>
    <div class="relative flex min-h-screen w-full items-center justify-center">
        <div class="bg-base-100/60 card relative z-10 w-96 border border-slate-200 backdrop-blur-lg">
            <div class="card-body">
                <h2 class="card-title mb-3">Register</h2>
                <form wire:submit="cekregister">
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Name</legend>
                        <input class="input input-primary w-full" type="text" placeholder="name" wire:model="name">
                        @error('name')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Email</legend>
                        <input class="input input-primary w-full" type="email" placeholder="Email" wire:model="email">
                        @error('email')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Password</legend>
                        <input class="input input-primary w-full" type="password" placeholder="Password" wire:model="password">
                        @error('password')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Confirm Password</legend>
                        <input class="input input-primary w-full" type="password" placeholder="confirm password"
                            wire:model="password_confirmation"
                        >
                        @error('password_confirmation')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>
                    <div class="form-control mt-6">
                        <button class="btn btn-primary btn-block btn-circle">Register</button>
                    </div>
                </form>
                <div class="divider">OR</div>
                <a class="btn btn-link" href="{{ route('login') }}">Sudah punya akun? Login</a>
            </div>
        </div>
        <div
            class='pointer-events-none absolute bottom-0 left-0 right-0 z-[1] h-[60vh] w-full bg-gradient-to-br from-cyan-200 via-indigo-800 to-violet-300 opacity-30 blur-[200px]'>
        </div>

    </div>

</div>
