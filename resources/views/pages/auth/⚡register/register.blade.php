<div>
    <div class="relative flex min-h-screen w-full items-center justify-center">
        <div class="bg-base-100/60 card relative z-10 w-96 border border-slate-200 backdrop-blur-lg">
            <div class="card-body">
                <h2 class="card-title mb-3">Daftar Akun</h2>
                <form class="grid gap-4" wire:submit="cekregister">
                    <x-input label="Nama" wire:model="name" />
                    <x-input label="Email" wire:model="email" />
                    <x-password label="Password" wire:model="password" />
                    <x-password label="Confirm Password" wire:model="password_confirmation" />

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
