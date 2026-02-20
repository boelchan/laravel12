<div>
    <div class="flex justify-between align-middle">
        <div>
            <h1 class="text-2xl font-medium text-slate-900">Kunjungan</h1>
            <div class="breadcrumbs p-0 text-xs text-slate-500">
                <ul>
                    <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
                    <li>Kunjungan</li>
                    <li>Data</li>
                </ul>
            </div>
        </div>
        <a class="btn btn-soft btn-primary btn-sm" href="{{ route('encounter.create') }}" wire:navigate>
            <i class="ti ti-plus text-lg"></i> Tambah
        </a>
    </div>

    <div class="mt-6">
        {{-- filter --}}
        <div>
            <div class="flex justify-between">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-800">Pencarian</span>
                    <button class="btn btn-soft btn-error btn-xs w-6" type="button" wire:click="resetFilters">
                        <i class="ti ti-filter-x text-lg"></i>
                    </button>
                </div>
            </div>
            <div>
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 xl:grid-cols-5">
                    <x-date clearable label="Tanggal" placeholder="cari tanggal..." wire:model.live.debounce.500ms="search_visit_date" />
                    <x-input clearable label="Nama Pasien" placeholder="cari nama..." wire:model.live.debounce.500ms="search_full_name" />
                    <x-input clearable label="No. RM" placeholder="cari No. RM..."
                        wire:model.live.debounce.500ms="search_medical_record_number"
                    />
                </div>
            </div>
        </div>
        {{-- end filter --}}

        <x-table :paginate="$this->dataTable">
            <x-table.thead class="bg-slate-50" :sortDirection="$sortDirection" :sortField="$sortField">
                <x-table.th width="5%" />
                <x-table.th label="Tanggal" sort="created_at" width="10%" />
                <x-table.th label="Pasien" sort="full_name" width="20%" />
                <x-table.th label="Umur" />
                <x-table.th label="Tekanan Darah" />
                <x-table.th label="Antropometri" />
                <x-table.th label="Status"/>
                <x-table.th />
            </x-table.thead>

            <tbody>
                @forelse ($this->dataTable as $index => $d)
                    <tr class="bg-white hover:bg-neutral-50" wire:key="encounter-{{ $d->id }}">
                        <td class="p-2 text-center"> {{ $perPage * ($this->dataTable->currentPage() - 1) + $index + 1 }} </td>
                        <td class="p-2"> {{ $d->visit_date }} </td>
                        <td class="p-2">
                            {{ $d->patient->medical_record_number }}<br>
                            {{ $d->patient->full_name }}
                        </td>
                        <td class="p-2">
                            {{ $d->patient->umur_sekarang }}
                        </td>
                        <td class="p-2">
                            {{ $d->vitalSign->systolic }} / {{ $d->vitalSign->diastolic }}
                        </td>
                        <td class="p-2">
                            TB : {{ $d->anthropometry->body_height }}<br>
                            BB : {{ $d->anthropometry->body_weight }}
                        </td>
                        <td class="p-2">
                            @if ($d->status == 'registered')
                                <div class="badge badge-success badge-soft">Baru</div>
                            @elseif ($d->status == 'arrived')
                                <div class="badge badge-warning badge-soft">Datang</div>
                            @elseif ($d->status == 'inprogress')
                                <div class="badge badge-info badge-soft">Dalam Proses</div>
                            @elseif ($d->status == 'finished')
                                <div class="badge badge-info badge-soft">Selesai</div>
                            @elseif ($d->status == 'cancelled')
                                <div class="badge badge-error badge-soft">Batal</div>
                            @endif
                        </td>
                        <td class="flex gap-2 p-2">
                            <a class="btn btn-xs btn-primary btn-square btn-soft" href="{{ route('encounter.edit', [$d->id, $d->uuid]) }}"
                                wire:navigate
                            >
                                <i class="ti ti-edit text-lg"></i></a>

                            <button class="btn btn-xs btn-square btn-error btn-soft"
                                wire:click="$js.confirmDelete({{ $d->id }}, '{{ $d->full_name }}')"
                            >
                                <i class="ti ti-trash text-lg"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-4 text-center text-slate-500" colspan="9">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>
    </div>

</div>
