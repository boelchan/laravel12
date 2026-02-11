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
            <div class="card bg-base-100 col-span-3 shadow-sm lg:col-span-1">
                <div class="card-body">
                    <h2 class="card-title">Role</h2>
                    @foreach ($roles as $role)
                        <div class="flex items-center gap-2 rounded-lg border border-white p-1 hover:border-slate-300">
                            <div class="flex gap-1">
                                <button class="btn btn-success btn-soft btn-xs btn-square tooltip tooltip-top" data-tip="Edit Permission"
                                    wire:click="dispatch('role-permission-edit', { role_id: {{ $role->id }} })"
                                >
                                    <i class="ti ti-key text-lg"></i>
                                </button>
                                <button class="btn btn-primary btn-soft btn-xs btn-square tooltip tooltip-top" data-tip="Edit Role"
                                    wire:click="dispatch('role-edit', { role_id: {{ $role->id }} })"
                                >
                                    <i class="ti ti-edit text-lg"></i>
                                </button>
                                <button class="btn btn-error btn-soft btn-xs btn-square tooltip tooltip-top" data-tip="Hapus Role"
                                    wire:click="deleteRole({{ $role->id }})"
                                >
                                    <i class="ti ti-trash text-lg"></i>
                                </button>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-medium text-slate-800">{{ $role->name }}</span>
                                <span class="text-xs text-slate-500">{{ $role->permissions->count() }} permission</span>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-auto">
                        <livewire:user.role_form />
                    </div>

                </div>
            </div>

            <div class="card bg-base-100 col-span-3 shadow-sm lg:col-span-2">
                <div class="card-body">
                    <h2 class="card-title">Permission</h2>
                    <div class="grid grid-cols-1 gap-2 md:grid-flow-col md:grid-rows-10">
                        @foreach ($permissions as $permission)
                            <div class="flex items-center gap-2 rounded-lg border border-white p-1 hover:border-slate-300">
                                <div>
                                    <button class="btn btn-primary btn-soft btn-xs btn-square"
                                        wire:click="dispatch('permission-edit', { permission_id: {{ $permission->id }} })"
                                    >
                                        <i class="ti ti-edit text-lg"></i>
                                    </button>
                                    <button class="btn btn-error btn-soft btn-xs btn-square"
                                        wire:click="deletePermission({{ $permission->id }})"
                                    >
                                        <i class="ti ti-trash text-lg"></i>
                                    </button>
                                </div>
                                <div>{{ $permission->name }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-auto">
                        <livewire:user.permission_form />
                    </div>
                </div>
            </div>

        </div>

        <livewire:user.role_permission_form />

    </div>

</div>
