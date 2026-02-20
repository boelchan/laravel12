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
                <x-table.th label="Tekanan Darah" />
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
                            {{ $d->vitalSign->systolic ?? '-' }} / {{ $d->vitalSign->diastolic ?? '-' }}
                        </td>
                        <td class="p-2">
                            TB : {{ $d->anthropometry->body_height ?? '-' }}<br>
                            BB : {{ $d->anthropometry->body_weight ?? '-' }}
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

                            @if ($d->status == 'registered')
                                <button class="btn btn-xs btn-square btn-success btn-soft" title="Pasien Datang"
                                    wire:click="arrived({{ $d->id }})"
                                >
                                    <i class="ti ti-check text-lg"></i>
                                </button>
                            @endif

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

    {{-- Modal Encounter --}}
    <x-modal id="modalEncounter" title="Tambah Kunjungan" wire="modalEncounter">
            {{-- Pencarian & Pemilihan Pasien --}}
            <div>
                <label class="label"><span class="label-text font-medium">Pasien <span class="text-error">*</span></span></label>

                @if ($selectedPatientName)
                    <div class="flex items-center gap-2 rounded-lg border border-primary/30 bg-primary/5 p-2.5">
                        <i class="ti ti-user-check text-lg text-primary"></i>
                        <span class="flex-1 text-sm font-medium text-slate-700">{{ $selectedPatientName }}</span>
                        <button class="btn btn-circle btn-ghost btn-xs" type="button"
                            wire:click="$set('selectedPatientName', '')"
                        >
                            <i class="ti ti-x text-sm"></i>
                        </button>
                    </div>
                @else
                    <x-input
                        icon="magnifying-glass"
                        placeholder="Cari nama, alamat, atau No. RM..."
                        wire:model.live.debounce.300ms="searchPatient"
                    />

                    @if ($this->patientList->count() > 0)
                        <div class="mt-1 max-h-48 overflow-y-auto rounded-lg border border-slate-200 bg-white">
                            @foreach ($this->patientList as $p)
                                <button
                                    class="flex w-full items-start gap-3 border-b border-slate-100 px-3 py-2 text-left transition hover:bg-primary/5 last:border-b-0"
                                    type="button"
                                    wire:click="selectPatient({{ $p->id }})"
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
                        Jumlah terdaftar pada tanggal ini: <span class="text-primary">{{ $this->encounterCount }}</span>
                    </div>
                @endif
            </div>
        <x-slot name="footer">
            <button class="btn btn-ghost" type="button" wire:click="$set('modalEncounter', false)">Batal</button>
            <button class="btn btn-primary" type="button" wire:click="saveEncounter">Simpan</button>
        </x-slot>
    </x-modal>

    {{-- Modal Vitals --}}
    <x-modal id="modalVitals" title="TTV & Antropometri" size="2xl" wire="modalVitals">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-4">
                <h4 class="font-semibold text-slate-700">Vital Signs</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs">Systolic</span></label>
                        <input class="input input-bordered input-sm w-full" type="number" wire:model="systolic" placeholder="mmHg">
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text text-xs">Diastolic</span></label>
                        <input class="input input-bordered input-sm w-full" type="number" wire:model="diastolic" placeholder="mmHg">
                    </div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs">Heart Rate</span></label>
                    <input class="input input-bordered input-sm w-full" type="number" wire:model="heart_rate" placeholder="bpm">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs">Resp. Rate</span></label>
                    <input class="input input-bordered input-sm w-full" type="number" wire:model="respiratory_rate" placeholder="x/mnt">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs">Suhu Tubuh</span></label>
                    <input class="input input-bordered input-sm w-full" type="number" wire:model="body_temperature" placeholder="°C">
                </div>
            </div>
            <div class="space-y-4">
                <h4 class="font-semibold text-slate-700">Antropometri</h4>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs">Tinggi Badan</span></label>
                    <input class="input input-bordered input-sm w-full" type="number" wire:model="body_height" placeholder="cm">
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text text-xs">Berat Badan</span></label>
                    <input class="input input-bordered input-sm w-full" type="number" wire:model="body_weight" placeholder="kg">
                </div>
            </div>
        </div>
        <x-slot name="footer">
            <button class="btn btn-ghost" type="button" wire:click="$set('modalVitals', false)">Batal</button>
            <button class="btn btn-primary" type="button" wire:click="saveVitals">Simpan</button>
        </x-slot>
    </x-modal>
</div>
