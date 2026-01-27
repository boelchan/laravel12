<div>
    <h1 class="text-2xl font-medium text-slate-900">User</h1>
    <div class="breadcrumbs p-0 text-xs text-slate-500">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
            <li><a href="{{ route('user') }}">User</a></li>
            <li>Ubah data</li>
        </ul>
    </div>

    <div class="mt-6">
        <x-card class="w-full border border-slate-200 lg:w-96" title="Ubah User">
            <form wire:submit="update" method="post" class="grid gap-4">
                @csrf
                <x-input wire:model="name" label="Nama" />
                <x-input wire:model="email" label="Email" />
                <x-password wire:model="password" label="Password" />
                <x-password wire:model="password_confirmation" label="Konfirmasi Password" />
                <x-select wire:model="role" label="Role" placeholder="Pilih Role" multiselect :options="$this->roles" />
                <x-button type="submit">Simpan</x-button>
            </form>
        </x-card>

    </div>
</div>
