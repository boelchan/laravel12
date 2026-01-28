<div>
    <h1 class="text-2xl font-medium text-slate-900">Role dan Permission</h1>
    <div class="breadcrumbs p-0 text-xs text-slate-500">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
            <li>Role dan Permission</li>
        </ul>
    </div>

    <div class="mt-6">
        <div class="grid gap-4 lg:grid-cols-3">
            <x-card class="col-span-3 border border-slate-200 lg:col-span-1" title="Role">
                @foreach ($roles as $role)
                    <div class="mb-2 flex items-center justify-between">
                        <span>{{ $role->name }}</span>
                        <div>
                            <button class="btn btn-primary btn-soft btn-sm btn-square"
                                wire:click="dispatch('role-edit', { role_id: {{ $role->id }} })"
                            >
                                <i class="ti ti-edit text-lg"></i>
                            </button>
                            <button class="btn btn-error btn-soft btn-sm btn-square" wire:click="deleteRole({{ $role->id }})">
                                <i class="ti ti-trash text-lg"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </x-card>
            <x-card class="col-span-3 border border-slate-200 lg:col-span-2" title="Permission">
                @foreach ($permissions as $permission)
                    <div>{{ $permission->name }}</div>
                @endforeach
            </x-card>

            <livewire:permission.create />

        </div>
    </div>
</div>
