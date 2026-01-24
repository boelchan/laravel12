<div>
    <h1 class="text-2xl font-medium text-slate-900 mb-10">{{ $title }}</h1>

    <div>
        <x-table.filter>
            <x-slot:action>
                <a href="/" class="btn btn-soft btn-primary w-10 h-10 lg:w-auto btn-sm">
                    <i class="ti ti-plus text-lg"></i> <span class="hidden lg:inline">Tambah</span>
                </a>
            </x-slot:action>

            <x-input-search label="Nama" wire:model.live.debounce.500ms="search_name" placeholder="cari nama..." />
            <x-input-search label="Email" wire:model.live.debounce.500ms="search_email" placeholder="cari email..." />

        </x-table.filter>

        <x-table :paginate="$this->dataTable">
            <x-table.thead :sortField="$sortField" :sortDirection="$sortDirection">
                <x-table.th width="5%" />
                <x-table.th label="Nama" sort="name" width="20%" />
                <x-table.th label="Email" sort="email" width="20%" />
                <x-table.th label="Verifikasi Email" />
                <x-table.th />
            </x-table.thead>

            <tbody>
                @forelse ($this->dataTable as $index => $d)
                    <x-table.tr wire:key="user-{{ $d->id }}">
                        <td class="p-2"> {{ $index + 1 }} </td>
                        <td class="p-2"> {{ $d->name }} </td>
                        <td class="p-2"> {{ $d->email }} </td>
                        <td class="p-2"> {{ $d->email_verified_at }} </td>
                        <td class="p-2">
                            <button class="btn btn-xs btn-warning btn-soft btn-square"
                                wire:click="edit({{ $d->id }})"
                            ><i class="ti ti-pencil text-lg"></i></button>
                            <button class="btn btn-soft btn-xs btn-error btn-square"
                                wire:click="delete({{ $d->id }})" wire:confirm="Hapus ?"
                            >
                                <i class="ti ti-trash text-lg"></i></button>
                        </td>
                    </x-table.tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-slate-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>
    </div>

</div>
