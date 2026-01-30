<div>
    <!-- Modal Edit Permission -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: @entangle('showModal') }" x-show="open" x-cloak>
        <!-- Backdrop -->
        <div
            class="fixed inset-0 bg-black/50 backdrop-blur-sm"
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="$wire.closeModal()"
        ></div>

        <!-- Modal Content -->
        <div class="flex min-h-screen items-center justify-center p-4">
            <div
                class="relative w-full max-w-2xl rounded-xl bg-white shadow-2xl"
                x-show="open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.away="$wire.closeModal()"
            >
                <!-- Header -->
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Edit Permission</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Atur permission untuk role <span class="text-primary-600 font-semibold">{{ $role_name }}</span>
                        </p>
                    </div>
                    <button class="btn btn-ghost btn-circle btn-sm" type="button" wire:click="closeModal">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="max-h-[60vh] overflow-y-auto px-6 py-4">
                    <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($allPermissions as $id => $name)
                            <label
                                class="hover:border-primary-300 hover:bg-primary-50 group flex cursor-pointer items-center gap-3 rounded-lg border border-slate-200 p-3 transition-all duration-200"
                                :class="{
                                    'border-primary-500 bg-primary-50 ring-1 ring-primary-500': $wire.selectedPermissions.includes(
                                        {{ $id }}),
                                    'border-slate-200': !$wire.selectedPermissions.includes({{ $id }})
                                }"
                            >
                                <input class="checkbox checkbox-primary checkbox-sm" type="checkbox" value="{{ $id }}"
                                    wire:model="selectedPermissions"
                                >
                                <span class="group-hover:text-primary-700 text-sm font-medium text-slate-700">
                                    {{ $name }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                    @if (count($allPermissions) === 0)
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <i class="ti ti-lock-off text-4xl text-slate-300"></i>
                            <p class="mt-2 text-sm text-slate-500">Belum ada permission tersedia</p>
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-between border-t border-slate-200 px-6 py-4">
                    <p class="text-sm text-slate-500">
                        <span class="text-primary-600 font-semibold" wire:text="selectedPermissions.length">0</span>
                        permission dipilih
                    </p>
                    <div class="flex gap-2">
                        <button class="btn btn-soft btn-secondary" type="button" wire:click="closeModal">
                            Batal
                        </button>
                        <button
                            class="btn btn-primary"
                            type="button"
                            wire:click="save"
                            wire:loading.attr="disabled"
                            wire:loading.class="loading"
                        >
                            <span wire:loading.remove>Simpan</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
