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
        <button class="btn btn-soft btn-primary btn-sm" wire:click="openModalEncounter">
            <i class="ti ti-plus text-lg"></i> Tambah
        </button>
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
                    <x-date label="Tanggal" placeholder="cari tanggal..." wire:model.live.debounce.500ms="search_visit_date" />
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
                <x-table.th label="TTV" />
                <x-table.th label="Antropometri" />
                <x-table.th label="Status" />
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
                            {{ $d->vitalSign->systolic ?? '-' }} / {{ $d->vitalSign->diastolic ?? '-' }} <i>mmHg</i>
                            @if ($d->status == 'arrived' || $d->status == 'inprogress')
                                <button class="btn btn-xs btn-square btn-primary btn-ghost"
                                    wire:click="openModalObservation({{ $d->id }})"
                                >
                                    <i class="ti ti-pencil text-lg"></i>
                                </button>
                            @endif
                            <br>
                            {{ $d->vitalSign->body_temperature  ?? '-'}} <i>°C</i>
                        </td>
                        <td class="p-2">
                            BB : {{ $d->anthropometry->body_weight ?? '-' }} <i>kg</i>
                            @if ($d->status == 'arrived' || $d->status == 'inprogress')
                                <button class="btn btn-xs btn-square btn-primary btn-ghost"
                                    wire:click="openModalObservation({{ $d->id }})"
                                >
                                    <i class="ti ti-pencil text-lg"></i>
                                </button>
                            @endif
                            <br>
                            TB : {{ $d->anthropometry->body_height ?? '-' }} <i>cm</i>
                        </td>
                        <td class="p-2">
                            @if ($d->status == 'registered')
                                <div class="badge badge-success">Baru</div>
                            @elseif ($d->status == 'arrived')
                                <div class="badge badge-warning">Datang</div>
                            @elseif ($d->status == 'inprogress')
                                <div class="badge badge-info">Pemeriksaan</div>
                            @elseif ($d->status == 'finished')
                                <div class="badge badge-info">Selesai</div>
                            @elseif ($d->status == 'cancelled')
                                <div class="badge badge-error">Batal</div>
                            @endif
                        </td>
                        <td class="p-2">
                            <div class="flex gap-2">

                                @if ($d->status == 'registered')
                                    <button class="btn btn-xs btn-square btn-warning btn-soft" title="Pasien Datang"
                                        wire:click="setArrived({{ $d->id }})"
                                    >
                                        <i class="ti ti-check text-lg"></i>
                                    </button>
                                @endif

                                @if ($d->status == 'arrived')
                                    <button class="btn btn-xs btn-square btn-info btn-soft" title="Mulai Pemeriksaan"
                                        wire:click="setInprogress({{ $d->id }})"
                                    >
                                        <i class="ti ti-send text-lg"></i>
                                    </button>
                                @endif

                                <a class="btn btn-xs btn-primary btn-square btn-soft"
                                    href="{{ route('encounter.edit', [$d->id, $d->uuid]) }}"
                                >
                                    <i class="ti ti-edit text-lg"></i></a>

                                @if ($d->status == 'registered')
                                    <button class="btn btn-xs btn-square btn-error btn-soft"
                                        wire:click="$js.confirmBatal({{ $d->id }}, '{{ $d->full_name }}')"
                                    >
                                        <i class="ti ti-x text-lg"></i>
                                    </button>
                                @endif
                            </div>
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

    {{-- Modal Encounter --}}
    <x-modal id="modalEncounter" title="Tambah Kunjungan" wire="modalEncounter">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="label"><span class="label-text font-medium">Pasien <span class="text-error">*</span></span></label>

                @if ($selectedPatientName)
                    <div class="border-primary/30 bg-primary/5 flex items-center gap-2 rounded-lg border p-2.5">
                        <i class="ti ti-user-check text-primary text-lg"></i>
                        <span class="flex-1 text-sm font-medium text-slate-700">{{ $selectedPatientName }}</span>
                        <button class="btn btn-circle btn-ghost btn-xs" type="button" wire:click="$set('selectedPatientName', '')">
                            <i class="ti ti-x text-sm"></i>
                        </button>
                    </div>
                @else
                    <x-input icon="magnifying-glass" placeholder="Cari nama, alamat, atau No. RM..."
                        wire:model.live.debounce.300ms="searchPatient"
                    />

                    @if ($this->patientList->count() > 0)
                        <div class="mt-1 max-h-48 overflow-y-auto rounded-lg border border-slate-200 bg-white">
                            @foreach ($this->patientList as $p)
                                <button
                                    class="hover:bg-primary/5 flex w-full items-start gap-3 border-b border-slate-100 px-3 py-2 text-left transition last:border-b-0"
                                    type="button" wire:click="selectPatient({{ $p->id }})"
                                    wire:key="patient-search-{{ $p->id }}"
                                >
                                    <i class="ti ti-user mt-0.5 text-lg text-slate-400"></i>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm font-semibold text-slate-800">{{ $p->full_name }}</div>
                                        <div class="text-xs text-slate-500">{{ $p->medical_record_number }}</div>
                                        @if ($p->address)
                                            <div class="truncate text-xs text-slate-400">
                                                <i class="ti ti-map-pin text-xs"></i> {{ $p->address }}
                                            </div>
                                        @endif
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @elseif (strlen($searchPatient) >= 1)
                        <div class="mt-1 rounded-lg border border-slate-200 bg-white px-3 py-4 text-center text-sm text-slate-400">
                            Pasien tidak ditemukan
                        </div>
                    @endif
                @endif
            </div>
            <div class="flex flex-col gap-1">
                <x-date label="Tanggal Periksa" wire:model.live="visit_date" />
                @if ($visit_date)
                    <div class="text-sm font-medium text-slate-600">
                        Pendaftar : <span class="text-primary">{{ $this->encounterCount }}</span>
                    </div>
                @endif
            </div>
        </div>
        <x-slot name="footer">
            <button class="btn btn-ghost" type="button" wire:click="$set('modalEncounter', false)">Batal</button>
            <button class="btn btn-primary" type="button" wire:click="saveEncounter">Simpan</button>
        </x-slot>
    </x-modal>

    {{-- Modal observasi --}}
    <x-modal id="modalObservation" title="Observasi" wire="modalObservation">
        <form wire:submit="saveObservation">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-4">
                    <h4 class="font-semibold text-slate-700">TTV</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <x-input type="number" label="Systolic" wire:model="systolic" suffix="mmHg" />
                        <x-input type="number" label="Diastolic" wire:model="diastolic" suffix="mmHg" />
                        <x-input
                            type="number"
                            step="0.1"
                            label="Suhu Tubuh"
                            wire:model="body_temperature"
                            suffix="°C"
                        />
                    </div>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-slate-700">Antropometri</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <x-input type="number" label="Tinggi Badan" wire:model="body_height" suffix="cm" />
                        <x-input type="number" label="Berat Badan" wire:model="body_weight" suffix="kg" />
                    </div>
                </div>
            </div>
            <div class="mt-2 flex justify-end gap-2">
                <button class="btn btn-ghost" type="button" wire:click="$set('modalObservation', false)">Batal</button>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </x-modal>
</div>
