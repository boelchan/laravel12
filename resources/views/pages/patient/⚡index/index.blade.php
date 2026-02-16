<div>
    <div class="flex justify-between align-middle">
        <div>
            <h1 class="text-2xl font-medium text-slate-900">Pasien</h1>
            <div class="breadcrumbs p-0 text-xs text-slate-500">
                <ul>
                    <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
                    <li>Pasien</li>
                    <li>Data</li>
                </ul>
            </div>
        </div>
        <a class="btn btn-soft btn-primary btn-sm" href="{{ route('patient.create') }}" wire:navigate>
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
                    <x-input clearable label="Nama" placeholder="cari nama..." wire:model.live.debounce.500ms="search_full_name" />
                    <x-input clearable label="No. RM" placeholder="cari No. RM..."
                        wire:model.live.debounce.500ms="search_medical_record_number"
                    />
                    <x-input clearable label="NIK" placeholder="cari nik..." wire:model.live.debounce.500ms="search_nik" />
                    <x-input clearable label="No. Telepon" placeholder="cari telepon..." wire:model.live.debounce.500ms="search_phone" />
                </div>
            </div>
        </div>
        {{-- end filter --}}

        <x-table :paginate="$this->dataTable">
            <x-table.thead class="bg-slate-50" :sortDirection="$sortDirection" :sortField="$sortField">
                <x-table.th width="5%" />
                <x-table.th label="No. RM" sort="medical_record_number" width="10%" />
                <x-table.th label="Nama" sort="full_name" width="20%" />
                <x-table.th label="NIK" width="15%" />
                <x-table.th label="Gender" />
                <x-table.th label="Tgl Lahir" sort="birth_date" />
                <x-table.th label="Telepon" />
                <x-table.th label="Status" />
                <x-table.th />
            </x-table.thead>

            <tbody>
                @forelse ($this->dataTable as $index => $d)
                    <tr class="bg-white hover:bg-neutral-50" wire:key="patient-{{ $d->id }}">
                        <td class="p-2 text-center"> {{ $perPage * ($this->dataTable->currentPage() - 1) + $index + 1 }} </td>
                        <td class="p-2 font-medium"> {{ $d->medical_record_number }} </td>
                        <td class="p-2"> {{ $d->full_name }} </td>
                        <td class="p-2 text-xs"> {{ $d->nik ?? '-' }} </td>
                        <td class="p-2"> {{ $d->gender?->label() ?? '-' }} </td>
                        <td class="p-2 text-xs">
                            {{ $d->birth_date?->format('d-m-Y') }}
                            <div class="text-[10px] text-slate-400">{{ $d->birth_place }}</div>
                        </td>
                        <td class="p-2 text-xs"> {{ $d->mobile_phone ?? ($d->phone ?? '-') }} </td>
                        <td class="p-2 text-center">
                            @if ($d->is_active)
                                <div class="badge badge-success badge-soft">Active</div>
                            @else
                                <div class="badge badge-error badge-soft">Inactive</div>
                            @endif
                        </td>
                        <td class="flex gap-2 p-2">
                            <a class="btn btn-xs btn-primary btn-square btn-soft" href="{{ route('patient.edit', $d->id) }}" wire:navigate>
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
