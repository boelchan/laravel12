<div>
    <h1 class="text-2xl font-medium text-slate-900">User</h1>
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
            <li><a href="{{ route('user') }}">User</a></li>
            <li>Tambah data baru</li>
        </ul>
    </div>

    <div class="mt-10">
        <x-card class="w-full lg:w-96" title="Tambah User">
            <form wire:submit="store" method="post">
                @csrf
                <x-input class="mb-4" wire:model="name" label="Nama" />
                <x-input class="mb-4" wire:model="email" label="Email" />
                <x-input class="mb-4" type="password" wire:model="password" label="Password" />
                <x-input class="mb-4" type="password" wire:model="password_confirmation" label="Konfirmasi Password" />
                <x-select
                    class="mb-4"
                    wire:model="role"
                    label="Role"
                    placeholder="Pilih Role"
                    searchable
                    multiselect
                    :options="$this->roles"
                />
                <x-button type="submit">Simpan</x-button>
            </form>
        </x-card>
    </div>
</div>
