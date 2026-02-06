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
            <form class="grid gap-4" wire:submit="update" method="post">
                @csrf
                <x-input wire:model="name" label="Nama" />
                <x-input wire:model="email" label="Email" />
                <x-password wire:model="password" label="Password" />
                <x-password wire:model="password_confirmation" label="Konfirmasi Password" />
                <x-select.styled
                    wire:model="role"
                    label="Role"
                    placeholder="Pilih Role"
                    multiple
                    :options="$this->roles"
                />
                <x-select.styled wire:model="status" label="Status" placeholder="Pilih Status" :options="[['label' => 'Active', 'value' => 'active'], ['label' => 'Inactive', 'value' => 'inactive']]" />
                <x-button type="submit">Simpan</x-button>
            </form>
        </x-card>

    </div>
</div>
