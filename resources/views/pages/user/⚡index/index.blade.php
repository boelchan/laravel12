<div>
    <h1 class="mb-10 text-2xl font-medium text-slate-900">{{ $title }}</h1>

    <div>
        {{-- filter --}}
        <div>
            <div class="flex justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-lg font-semibold text-slate-800">Pencarian</span>
                    <button class="btn btn-soft btn-primary btn-sm w-8 lg:w-auto" type="button" wire:click="resetFilters">
                        <i class="ti ti-filter-2-x text-lg"></i>
                        <span class="hidden lg:inline">Reset</span>
                    </button>
                </div>

                <div class="flex gap-2">
                    <a class="btn btn-soft btn-primary btn-sm w-8 lg:w-auto" href="/">
                        <i class="ti ti-plus text-lg"></i> <span class="hidden lg:inline">Tambah</span>
                    </a>
                </div>
            </div>
            <div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-0 lg:grid-cols-4 lg:gap-4 xl:grid-cols-5">
                    <x-input-search label="Nama" placeholder="cari nama..." wire:model.live.debounce.500ms="search_name" />
                    <x-input-search label="Email" placeholder="cari email..." wire:model.live.debounce.500ms="search_email" />
                </div>
            </div>
        </div>
        {{-- end filter --}}

        <x-table :paginate="$this->dataTable">
            <x-table.thead class="bg-slate-50" :sortDirection="$sortDirection" :sortField="$sortField">
                <x-table.th width="5%" />
                <x-table.th label="Nama" sort="name" width="20%" />
                <x-table.th label="Email" sort="email" width="20%" />
                <x-table.th label="Verifikasi Email" />
                <x-table.th />
            </x-table.thead>

            <tbody>
                @forelse ($this->dataTable as $index => $d)
                    <tr class="hover:bg-neutral-50" wire:key="user-{{ $d->id }}">
                        <td class="p-2"> {{ $index + 1 }} </td>
                        <td class="p-2"> {{ $d->name }} </td>
                        <td class="p-2"> {{ $d->email }} </td>
                        <td class="p-2"> {{ $d->email_verified_at->format('d-m-Y H:i') }} </td>
                        <td class="p-2">
                            <button class="btn btn-xs btn-warning btn-square btn-soft" wire:click="edit({{ $d->id }})">
                                <i class="ti ti-pencil text-lg"></i></button>

                            <button class="btn btn-xs btn-square btn-error btn-soft"
                                x-on:confirm="{
                                    title: 'Hapus {{ $d->name }}?',
                                    icon: 'warning',
                                    description: 'Data yang dihapus tidak dapat dikembalikan',
                                    method: 'delete',
                                    params: {{ $d->id }}
                                }"
                            >
                                <i class="ti ti-trash text-lg"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-4 text-center text-slate-500" colspan="5">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>
    </div>

</div>
