<div>
    <div class="relative flex min-h-screen w-full items-center justify-center">
        <div class="bg-base-100/60 card relative z-10 w-96 border border-slate-200 backdrop-blur-lg">
            <div class="card-body">
                <h2 class="card-title mb-3">Register</h2>
                <form wire:submit="cekregister">
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Name</legend>
                        <input type="text" placeholder="name" class="input input-primary w-full" wire:model="name">
                        @error('name')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Email</legend>
                        <input type="email" placeholder="Email" class="input input-primary w-full" wire:model="email">
                        @error('email')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Password</legend>
                        <input type="password" placeholder="Password" class="input input-primary w-full"
                            wire:model="password"
                        >
                        @error('password')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Confirm Password</legend>
                        <input type="password" placeholder="confirm password" class="input input-primary w-full"
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
                <a href="{{ route('login') }}" class="btn btn-link">Sudah punya akun? Login</a>
            </div>
        </div>
        <div
            class='pointer-events-none absolute bottom-0 left-0 right-0 z-[1] h-[60vh] w-full bg-gradient-to-br from-cyan-200 via-indigo-800 to-violet-300 opacity-30 blur-[200px]'>
        </div>

    </div>

</div>
