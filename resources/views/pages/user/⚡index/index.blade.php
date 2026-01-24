<div>
    <h1 class="text-2xl font-bold ">{{ $title }}</h1>

    <div>
        <x-table.filter :open="$open">
            <x-slot:action>
                <a href="/" class="btn btn-soft btn-primary w-10 h-10 lg:w-auto">
                    <i class="ti ti-plus text-lg"></i> <span class="hidden lg:inline">Tambah</span>
                </a>
            </x-slot:action>

            <x-input label="Nama" wire:model.live="search_name" />
            <x-input label="Email" wire:model.live="search_email" />

        </x-table.filter>

        <x-table :paginate="$data">
            <x-table.thead :sortField="$sortField" :sortDirection="$sortDirection">
                <x-table.th width="5%" />
                <x-table.th label="Nama" sort="name" width="20%" />
                <x-table.th label="Email" sort="email" width="20%" />
                <x-table.th label="Verifikasi Email" sort="email_verified_at" />
                <x-table.th />
            </x-table.thead>

            <tbody>
                @forelse ($data as $index => $d)
                    <x-table.tr>
                        <td class="p-2"> {{ $index + 1 }} </td>
                        <td class="p-2"> {{ $d->name }} </td>
                        <td class="p-2"> {{ $d->email }} </td>
                        <td class="p-2"> {{ $d->email_vrified_at }} </td>
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
