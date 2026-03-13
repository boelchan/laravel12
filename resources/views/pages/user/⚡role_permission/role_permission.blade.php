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
            <div class="card col-span-3 border border-slate-200 lg:col-span-1">
                <div class="card-body">
                    <h2 class="card-title">Role</h2>
                    @foreach ($roles as $role)
                        <div class="flex items-center gap-2 rounded-lg border border-slate-100 p-1 hover:border-slate-300">
                            <div class="flex gap-1">
                                <button class="btn btn-success btn-soft btn-xs btn-square tooltip tooltip-top" data-tip="Edit Permission"
                                    wire:click="dispatch('role-permission-edit', { role_id: {{ $role->id }} })"
                                >
                                    <i class="ti ti-key text-lg"></i>
                                </button>
                                <button class="btn btn-info btn-soft btn-xs btn-square tooltip tooltip-top" data-tip="Lihat User"
                                    wire:click="lihatUser({{ $role->id }})"
                                >
                                    <i class="ti ti-users text-lg"></i>
                                </button>

                                @if (env('APP_ENV') != 'production' || !in_array($role->name, ['administrator', 'dokter', 'bidan', 'apoteker']))
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
                                @endif
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

            <div class="card col-span-3 border border-slate-200 lg:col-span-2">
                <div class="card-body">
                    <h2 class="card-title">Permission</h2>
                    <div class="grid grid-cols-1 gap-2 md:grid-flow-col md:grid-rows-10">
                        @foreach ($permissions as $permission)
                            <div class="flex items-center gap-2 rounded-lg border border-white p-1 hover:border-slate-300">
                                <div>
                                    @if (env('APP_ENV') != 'production')
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
                                    @endif
                                    <button class="btn btn-success btn-soft btn-xs btn-square tooltip tooltip-top" data-tip="Lihat Role"
                                        wire:click="lihatRole({{ $permission->id }})">
                                        <i class="ti ti-list text-lg"></i>
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

    {{-- Modal: Lihat Role yang menggunakan Permission --}}
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: @entangle('showRolesModal') }" x-show="open" x-cloak>
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" x-show="open" @click="$wire.closeRolesModal()"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-md rounded-xl bg-white shadow-2xl" x-show="open" @click.away="$wire.closeRolesModal()">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Role yang Menggunakan <span class="text-primary-600">{{ $permissionName }}</span></h3>
                    </div>
                    <button class="btn btn-ghost btn-circle btn-sm" type="button" wire:click="closeRolesModal">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>
                <div class="max-h-[60vh] overflow-y-auto px-6 py-4">
                    @if (count($permissionRoles) > 0)
                        <div class="space-y-2">
                            @foreach ($permissionRoles as $pr)
                                <div class="flex items-center justify-between rounded-lg border border-slate-200 p-3">
                                    <div class="flex items-center gap-2">
                                        <i class="ti ti-shield text-lg text-primary-500"></i>
                                        <span class="font-medium text-slate-800">{{ $pr['name'] }}</span>
                                    </div>
                                    <span class="badge badge-soft badge-info badge-sm">{{ $pr['users_count'] }} user</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <i class="ti ti-shield-off text-4xl text-slate-300"></i>
                            <p class="mt-2 text-sm text-slate-500">Tidak ada role yang menggunakan permission ini</p>
                        </div>
                    @endif
                </div>
                <div class="flex justify-end border-t border-slate-200 px-6 py-4">
                    <button class="btn btn-soft btn-secondary" type="button" wire:click="closeRolesModal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal: Lihat User yang Memiliki Role --}}
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: @entangle('showUsersModal') }" x-show="open" x-cloak>
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" x-show="open" @click="$wire.closeUsersModal()"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-md rounded-xl bg-white shadow-2xl" x-show="open" @click.away="$wire.closeUsersModal()">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">User dengan Role <span class="text-primary-600">{{ $roleName }}</span></h3>
                    </div>
                    <button class="btn btn-ghost btn-circle btn-sm" type="button" wire:click="closeUsersModal">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>
                <div class="max-h-[60vh] overflow-y-auto px-6 py-4">
                    @if (count($roleUsers) > 0)
                        <div class="space-y-2">
                            @foreach ($roleUsers as $user)
                                <div class="flex items-center gap-3 rounded-lg border border-slate-200 p-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 text-primary-600">
                                        <i class="ti ti-user text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ $user['name'] }}</div>
                                        <div class="text-xs text-slate-500">{{ $user['email'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <i class="ti ti-user-off text-4xl text-slate-300"></i>
                            <p class="mt-2 text-sm text-slate-500">Tidak ada user yang memiliki role ini</p>
                        </div>
                    @endif
                </div>
                <div class="flex justify-end border-t border-slate-200 px-6 py-4">
                    <button class="btn btn-soft btn-secondary" type="button" wire:click="closeUsersModal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

