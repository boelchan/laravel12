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
        <a class="btn btn-primary btn-sm" href="{{ route('patient.create') }}" wire:navigate>
            <i class="ti ti-plus text-lg"></i> Tambah
        </a>
    </div>

    <div class="mt-6">
        {{-- filter --}}
        <div>
            <div class="flex justify-between">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-800">Pencarian</span>
                    <button class="btn btn-error btn-sm btn-square btn-ghost" type="button" wire:click="resetFilters">
                        <i class="ti ti-filter-x text-lg"></i>
                    </button>
                </div>
            </div>
            <div>
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 xl:grid-cols-5">
                    <x-input clearable label="No. RM" placeholder="cari No. RM..."
                        wire:model.live.debounce.500ms="search_medical_record_number"
                    />
                    <x-input clearable label="Nama" placeholder="cari nama..." wire:model.live.debounce.500ms="search_full_name" />
                    <x-input clearable label="Desa" placeholder="cari desa..." wire:model.live.debounce.500ms="search_village" />
                    <x-select.native
                        label="Status"
                        :options="[['label' => 'Semua', 'value' => ''],['label' => 'Aktif', 'value' => 'aktif'], ['label' => 'Tidak Aktif', 'value' => 'tidak_aktif']]"
                        wire:model.live="search_status"
                        placeholder="Pilih status"
                    />
                </div>
            </div>
        </div>
        {{-- end filter --}}

        <x-table :paginate="$this->dataTable">
            <x-table.thead class="bg-slate-50" :sortDirection="$sortDirection" :sortField="$sortField">
                <x-table.th width="5%" />
                <x-table.th label="No. RM" sort="medical_record_number" width="10%" />
                <x-table.th label="Nama" sort="full_name" width="20%" />
                <x-table.th label="Keluarga" width="15%" />
                <x-table.th label="Desa" />
                <x-table.th label="Telepon" />
                <x-table.th label="Status" />
                <x-table.th />
            </x-table.thead>

            <tbody>
                @forelse ($this->dataTable as $index => $d)
                    <tr class="bg-white hover:bg-neutral-50" wire:key="patient-{{ $d->id }}">
                        <td class="p-2 text-center"> {{ $perPage * ($this->dataTable->currentPage() - 1) + $index + 1 }} </td>
                        <td class="p-2"> {{ $d->medical_record_number }} </td>
                        <td class="p-2"> {{ $d->full_name }} ({{ $d->gender?->singkatan() ?? '-' }})</td>
                        <td class="p-2"> {{ $d->family_name }} </td>
                        <td class="p-2"> {{ $d->village?->name ?? '-' }} </td>
                        <td class="p-2"> {{ $d->mobile_phone ?? ($d->phone ?? '-') }} </td>
                        <td class="p-2">
                            @if ($d->is_active)
                                <div class="badge badge-soft badge-success">Aktif</div>
                            @else
                                <div class="badge badge-soft badge-error">Tidak Aktif</div>
                            @endif
                        </td>
                        <td class="flex gap-1 p-2">
                            <button class="btn btn-sm btn-primary btn-square btn-soft" title="Riwayat"
                                wire:click="$dispatch('open-history-modal', [{{ $d->id }}])"
                            >
                                <i class="ti ti-history text-lg"></i></button>

                            @if ($d->is_active)
                                <a class="btn btn-sm btn-primary btn-square" href="{{ route('patient.edit', [$d->id, $d->uuid]) }}"
                                    title="Ubah"
                                >
                                    <i class="ti ti-edit text-lg"></i></a>

                                <button class="btn btn-sm btn-square btn-error btn-soft" title="Hapus"
                                    wire:click="$js.confirmDelete({{ $d->id }}, '{{ addslashes($d->full_name) }}')"
                                >
                                    <i class="ti ti-trash text-lg"></i> </button>
                            @else
                                @can('pasien-aktifkan')
                                    <button class="btn btn-sm btn-square btn-success btn-soft" title="Aktifkan"
                                        wire:click="$js.confirmAktifkanPasien({{ $d->id }}, '{{ addslashes($d->full_name) }}')"
                                    >
                                        <i class="ti ti-refresh text-lg"></i>
                                    </button>
                                @endcan
                            @endif
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

    <livewire:encounter.riwayat_pemeriksaan />

</div>
