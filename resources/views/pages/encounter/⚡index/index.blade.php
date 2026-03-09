<div>
    <div class="flex justify-between align-middle">
        <div>
            <h1 class="text-2xl font-medium text-slate-900">Kunjungan Pasien</h1>
            <div class="breadcrumbs p-0 text-xs text-slate-500">
                <ul>
                    <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
                    <li>Kunjungan</li>
                    <li>Data</li>
                </ul>
            </div>
        </div>
        @can('kunjungan-tambah')
            <button class="btn btn-primary btn-sm" wire:click="openModalEncounter">
                <i class="ti ti-plus text-lg"></i> Tambah
            </button>
        @endcan
    </div>

    <div class="mt-6">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-5">
            {{-- Total --}}
            <div class="rounded-xl border border-slate-100 bg-white p-2 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <i class="ti ti-users text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total</div>
                        <div class="text-xl font-bold text-slate-800">{{ $this->stats['total'] }}</div>
                    </div>
                </div>
            </div>
            {{-- Arrived --}}
            <div class="border-info/10 rounded-xl border bg-white p-2 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-info/10 text-info flex h-10 w-10 items-center justify-center rounded-lg">
                        <i class="ti ti-walk text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-info/70 text-[10px] font-bold uppercase tracking-wider">Belum Datang</div>
                        <div class="text-xl font-bold text-slate-800">{{ $this->stats['registered'] }}</div>
                    </div>
                </div>
            </div>
            {{-- Finished --}}
            {{-- Arrived --}}
            <div class="border-primary/10 rounded-xl border bg-white p-2 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-primary/10 text-primary flex h-10 w-10 items-center justify-center rounded-lg">
                        <i class="ti ti-user-check text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-primary/70 text-[10px] font-bold uppercase tracking-wider">Datang</div>
                        <div class="text-xl font-bold text-slate-800">{{ $this->stats['arrived'] }}</div>
                    </div>
                </div>
            </div>
            {{-- Finished --}}
            <div class="border-success/10 rounded-xl border bg-white p-2 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-success/10 text-success flex h-10 w-10 items-center justify-center rounded-lg">
                        <i class="ti ti-circle-check text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-success/70 text-[10px] font-bold uppercase tracking-wider">Selesai</div>
                        <div class="text-xl font-bold text-slate-800">{{ $this->stats['finished'] }}</div>
                    </div>
                </div>
            </div>
            {{-- Cancelled --}}
            <div class="border-error/10 rounded-xl border bg-white p-2 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-error/10 text-error flex h-10 w-10 items-center justify-center rounded-lg">
                        <i class="ti ti-x text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-error/70 text-[10px] font-bold uppercase tracking-wider">Batal</div>
                        <div class="text-xl font-bold text-slate-800">{{ $this->stats['cancelled'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{-- filter --}}
        <div>
            <div class="flex justify-between">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-800">Pencarian</span>
                    <button class="btn btn-outline btn-error btn-xs w-6" type="button" wire:click="resetFilters">
                        <i class="ti ti-filter-x text-lg"></i>
                    </button>
                </div>
            </div>
            <div>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-5">
                    <x-date value="{{ request()->search_visit_date }}" label="Tanggal" placeholder="cari tanggal..."
                        wire:model.live.debounce.500ms="search_visit_date"
                    />
                    <x-input
                        type="number"
                        clearable
                        label="No. Antrian"
                        placeholder="cari Nomer Antrian."
                        wire:model.live.debounce.500ms="search_no_antrian"
                    />
                    <x-input clearable label="Nama Pasien" placeholder="cari nama..." wire:model.live.debounce.500ms="search_full_name" />
                    <x-input clearable label="No. RM" placeholder="cari No. RM..."
                        wire:model.live.debounce.500ms="search_medical_record_number"
                    />
                    <x-select.styled wire:model.live="search_status" label="Status" :options="\App\Enums\StatusEncounterEnum::choices()" />

                </div>
            </div>
        </div>
        {{-- end filter --}}

        <x-table :paginate="$this->dataTable">
            <x-table.thead class="bg-slate-50" :sortDirection="$sortDirection" :sortField="$sortField">
                <x-table.th label="No" sort="no_antrian" width="5%" />
                <x-table.th label="Tanggal" width="15%" />
                <x-table.th label="Pasien" width="35%" />
                <x-table.th label="TTV" width="15%" />
                <x-table.th label="BB/TB" width="15%" />
                <x-table.th label="Status" sort="status" width="10%" />
                <x-table.th width="15%" />
            </x-table.thead>

            <tbody>
                @forelse ($this->dataTable as $index => $d)
                    <tr class="bg-white hover:bg-neutral-50" wire:key="encounter-{{ $d->id }}">
                        <td class="p-2"> {{ $d->no_antrian }} </td>
                        <td class="p-2"> {{ $d->visit_date }} </td>
                        <td class="p-2">
                            {{ $d->patient->medical_record_number }}<br>
                            {{ $d->patient->full_name }}
                            @if ($d->status != 'cancelled')
                                <button class="btn btn-xs btn-square btn-primary btn-ghost" title="Panggil Pasien"
                                    wire:click="$js.speak('Nomor antrian {{ $d->no_antrian }}. atas nama {{ addslashes($d->patient->full_name) }}')"
                                >
                                    <i class="ti ti-volume text-lg"></i>
                                </button>
                            @endif
                        </td>
                        <td class="p-2">
                            @if ($d->vitalSign)
                                {{ $d->vitalSign->systolic ?? '-' }} / {{ $d->vitalSign->diastolic ?? '-' }}
                                <br>
                                {{ $d->vitalSign->body_temperature ?? '-' }} <i>°C</i>
                            @else
                                -
                            @endif
                            @if ($d->visit_date == date('Y-m-d') || auth()->user()->can('kunjungan-edit-yang-lewat-hari'))
                                @if ($d->status == 'arrived' || $d->status == 'inprogress')
                                    <button class="btn btn-xs btn-square btn-primary btn-ghost"
                                        wire:click="openModalObservation({{ $d->id }})"
                                    >
                                        <i class="ti ti-pencil text-lg"></i>
                                    </button>
                                @endif
                            @endif
                        </td>
                        <td class="p-2">
                            @if ($d->anthropometry)
                                {{ $d->anthropometry->body_weight ?? '-' }} <i>kg</i>
                                <br>
                                {{ $d->anthropometry->body_height ?? '-' }} <i>cm</i>
                            @else
                                -
                            @endif
                            @if ($d->visit_date == date('Y-m-d') || auth()->user()->can('kunjungan-edit-yang-lewat-hari'))
                                @if ($d->status == 'arrived' || $d->status == 'inprogress')
                                    <button class="btn btn-xs btn-square btn-primary btn-ghost"
                                        wire:click="openModalObservation({{ $d->id }})"
                                    >
                                        <i class="ti ti-pencil text-lg"></i>
                                    </button>
                                @endif
                            @endif
                        </td>
                        <td class="p-2">
                            {!! $d->statusBadge !!}
                            @if ($d->visit_date >= date('Y-m-d') || auth()->user()->can('kunjungan-edit-yang-lewat-hari'))
                                @if ($d->status == 'cancelled')
                                    <button class="btn btn-xs btn-square btn-success btn-ghost" title="Pulihkan Kunjungan"
                                        wire:click="$js.confirmPulihkan({{ $d->id }}, '{{ addslashes($d->patient->full_name) }}')"
                                    >
                                        <i class="ti ti-refresh text-lg"></i>
                                    </button>
                                @endif
                                @if ($d->status == 'registered' || $d->status == 'arrived')
                                    <button class="btn btn-xs btn-square btn-error btn-ghost" title="Batalkan Kunjungan"
                                        wire:click="$js.confirmBatal({{ $d->id }}, '{{ addslashes($d->patient->full_name) }}')"
                                    >
                                        <i class="ti ti-x text-lg"></i>
                                    </button>
                                @endif
                            @endif
                        </td>
                        <td class="p-2">
                            @if ($d->visit_date == date('Y-m-d') || (auth()->user()->can('kunjungan-edit-yang-lewat-hari') && $d->visit_date <= date('Y-m-d')))
                                <div class="flex gap-2">
                                    @if ($d->status == 'registered')
                                        <button class="btn btn-sm btn-square btn-primary" title="Pasien Datang"
                                            wire:click="setArrived({{ $d->id }})"
                                        >
                                            <i class="ti ti-check text-lg"></i>
                                        </button>
                                    @endif

                                    @if ($d->status == 'arrived')
                                        <button class="btn btn-sm btn-square btn-warning" title="Mulai Pemeriksaan"
                                            wire:click="setInprogress({{ $d->id }})"
                                        >
                                            <i class="ti ti-send text-lg"></i>
                                        </button>
                                    @endif
                                    @can('kunjungan-edit-pemeriksaan')
                                        @if ($d->status == 'inprogress' || $d->status == 'finished')
                                            <a class="btn btn-sm btn-success btn-square"
                                                href="{{ route('encounter.edit', [$d->id, $d->uuid]) }}" title="Pemeriksaan"
                                            >
                                                <i class="ti ti-stethoscope text-lg"></i></a>
                                        @endif
                                    @endcan

                                </div>
                            @endif
                            @if ($d->status == 'registered' && $d->no_antrian == $antrianTerakhir)
                                <button class="btn btn-sm btn-square btn-error" title="Hapus Kunjungan"
                                    wire:click="$js.confirmDelete({{ $d->id }}, '{{ addslashes($d->patient->full_name) }}')"
                                >
                                    <i class="ti ti-trash text-lg"></i>
                                </button>
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

    {{-- Modal Encounter --}}
    <x-modal
        id="modalEncounter"
        title="Tambah Kunjungan Baru"
        persistent
        size="4xl"
        wire="modalEncounter"
    >
        <div class="space-y-6">
            {{-- Patient Selection Section --}}
            <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                <div class="mb-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="bg-primary/10 text-primary flex h-8 w-8 items-center justify-center rounded-lg">
                            <i class="ti ti-user-search text-lg"></i>
                        </div>
                        <h3 class="text-sm font-semibold text-slate-800">Informasi Pasien</h3>
                    </div>
                </div>

                @if ($selectedPatientName)
                    <div class="space-y-4">
                        <div
                            class="animate-in fade-in zoom-in border-primary/20 flex items-center gap-4 rounded-xl border bg-white p-4 shadow-sm duration-300">
                            <div class="bg-primary/10 text-primary flex h-12 w-12 items-center justify-center rounded-full">
                                <i class="ti ti-user-check text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-xs font-medium uppercase tracking-wider text-slate-500">Pasien Terpilih</div>
                                <div class="text-lg font-bold text-slate-800">{{ $selectedPatientName }}</div>
                            </div>
                            <button class="btn btn-circle btn-ghost btn-sm text-error hover:bg-error/10" type="button"
                                title="Ganti Pasien" wire:click="$set('selectedPatientName', '')"
                            >
                                <i class="ti ti-rotate text-lg"></i>
                            </button>
                        </div>

                        {{-- Riwayat Kunjungan singkat --}}
                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-200 bg-slate-50 px-4 py-2">
                                <h4 class="text-[10px] font-bold uppercase tracking-widest text-slate-400">10 Kunjungan Terakhir</h4>
                            </div>
                            <div class="max-h-40 overflow-y-auto">
                                <table class="w-full text-left text-xs">
                                    <thead class="bg-slate-100 text-[10px] uppercase text-slate-500">
                                        <tr>
                                            <th class="px-4 py-2 font-bold">Tanggal</th>
                                            <th class="px-4 py-2 text-center font-bold">No. Antrian</th>
                                            <th class="px-4 py-2 font-bold">TTV / Status</th>
                                            <th class="px-4 py-2 text-right font-bold">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse($this->patientHistory as $history)
                                            <tr class="transition-colors hover:bg-slate-50">
                                                <td class="px-4 py-2 font-medium text-slate-700">{{ $history->visit_date }}</td>
                                                <td class="px-4 py-2 text-center font-mono text-slate-500">{{ $history->no_antrian }}</td>
                                                <td class="px-4 py-2 text-slate-500">
                                                    @if ($history->vitalSign)
                                                        {{ $history->vitalSign->systolic }}/{{ $history->vitalSign->diastolic }} @
                                                        {{ $history->vitalSign->body_temperature }}°C
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="flex items-center justify-end gap-2 px-4 py-2 text-right">
                                                    {!! $history->statusBadge !!}
                                                    @if ($history->status == 'cancelled' && $history->visit_date == $visit_date)
                                                        <button class="btn btn-xs btn-success btn-outline"
                                                            title="Pulihkan ke Pasien Datang"
                                                            wire:click="setArrived({{ $history->id }})"
                                                        >
                                                            <i class="ti ti-refresh"></i> Pulihkan
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="px-4 py-6 text-center italic text-slate-400" colspan="4">Belum ada riwayat
                                                    kunjungan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="space-y-3">
                        <div class="flex items-end gap-3">
                            <div class="grid flex-1 grid-cols-1 gap-3 md:grid-cols-3">
                                <x-input label="No. RM" placeholder="Ketik No. RM..."
                                    wire:model.live.debounce.500ms="searchPatientMRN" />
                                <x-input label="Nama Pasien" placeholder="Ketik nama..."
                                    wire:model.live.debounce.500ms="searchPatientName"
                                />
                                <x-input label="Desa" placeholder="Ketik desa..."
                                    wire:model.live.debounce.500ms="searchPatientVillage" />
                            </div>
                            <div class="shrink-0 pb-1">
                                <a class="btn btn-primary btn-sm" href="{{ route('patient.create') }}">
                                    <i class="ti ti-user-plus mr-1.5"></i> Baru
                                </a>
                            </div>
                        </div>

                        {{-- Loading Indicator --}}
                        <div class="mt-2" wire:loading wire:target="searchPatientMRN, searchPatientName, searchPatientVillage">
                            <div class="border-primary/10 bg-primary/5 flex items-center gap-2 rounded-lg border px-3 py-2">
                                <i class="ti ti-loader-2 text-primary animate-spin"></i>
                                <span class="text-primary text-xs font-medium">Mencari data pasien...</span>
                            </div>
                        </div>

                        {{-- Search Results --}}
                        <div wire:loading.remove wire:target="searchPatientMRN, searchPatientName, searchPatientVillage">
                            @if ($this->patientList->count() > 0)
                                <div class="mt-2 max-h-60 overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-sm">
                                    @foreach ($this->patientList as $p)
                                        <button
                                            class="hover:bg-primary/5 group flex w-full items-center gap-4 border-b border-slate-50 px-4 py-3 text-left transition last:border-b-0"
                                            type="button" wire:click="selectPatient({{ $p->id }})"
                                            wire:key="patient-search-{{ $p->id }}"
                                        >
                                            <div
                                                class="group-hover:bg-primary/10 group-hover:text-primary flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                                                <i class="ti ti-user text-xl"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <span class="truncate font-semibold text-slate-800">{{ $p->full_name }}</span>
                                                    <span
                                                        class="ml-2 shrink-0 rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-bold uppercase text-slate-600"
                                                    >{{ $p->medical_record_number }}</span>
                                                </div>
                                                <div class="flex flex-col gap-0.5">
                                                    @if ($p->address)
                                                        <div class="truncate text-xs text-slate-500">
                                                            <i class="ti ti-map-pin mr-1 text-[10px]"></i>{{ $p->address }}
                                                        </div>
                                                    @endif
                                                    @if ($p->village)
                                                        <div class="text-[10px] font-medium text-slate-400">
                                                            <i class="ti ti-building-community mr-1"></i>{{ $p->village->name }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <i class="ti ti-chevron-right text-slate-300"></i>
                                        </button>
                                    @endforeach
                                </div>
                            @elseif (strlen($searchPatientName) >= 1 || strlen($searchPatientMRN) >= 1 || $searchPatientVillage)
                                <div class="mt-2 rounded-xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-400">
                                    <i class="ti ti-search-off mx-auto mb-2 text-3xl opacity-20"></i>
                                    <p class="text-sm font-medium">Pasien Tidak Ditemukan</p>
                                    <p class="text-xs">Coba cari dengan kata kunci lain</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Visit Details Section --}}
            <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                <div class="mb-3 flex items-center gap-2">
                    <div class="bg-info/10 text-info flex h-8 w-8 items-center justify-center rounded-lg">
                        <i class="ti ti-calendar-event text-lg"></i>
                    </div>
                    <h3 class="text-sm font-semibold text-slate-800">Detail Kunjungan</h3>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-date label="Tanggal Periksa" wire:model.live="visit_date" :min-date="today()"/>

                    @if ($visit_date)
                        @if ($this->isAlreadyRegistered && $selectedPatientName)
                            <div class="alert alert-error" role="alert">
                                <i class="ti ti-alert-triangle text-2xl"></i>
                                <span>PASIEN SUDAH TERDAFTAR <br>pada tanggal {{ $visit_date }}</span>
                            </div>
                        @else
                            <livewire:jumlah_pendaftar />
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex w-full items-center justify-between">
                <p class="text-[10px] font-medium uppercase tracking-tighter text-slate-400">* Wajib diisi</p>
                <div class="flex gap-2">
                    <button class="btn btn-ghost" type="button" wire:click="$set('modalEncounter', false)">Batal</button>
                    @if (!$this->isAlreadyRegistered)
                        <button class="btn btn-primary shadow-primary/20 px-6 shadow-lg" type="button" wire:click="saveEncounter">
                            <i class="ti ti-device-floppy mr-1.5"></i> Simpan Kunjungan
                        </button>
                    @else
                        <button class="btn btn-outline btn-error cursor-not-allowed opacity-50" type="button" disabled>
                            Sudah Terdaftar
                        </button>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-modal>

    {{-- Modal observasi --}}
    <x-modal id="modalObservation" title="Observasi" wire="modalObservation">
        <form wire:submit="saveObservation">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="col-span-2">
                    <x-textarea label="Keluhan" rows="5" wire:model="chief_complaint" />
                </div>

                <div class="space-y-4">
                    <h4 class="font-semibold text-slate-700">TTV</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <x-input type="number" label="Systolic" wire:model="systolic" suffix="mmHg" />
                        <x-input type="number" label="Diastolic" wire:model="diastolic" suffix="mmHg" />
                        <x-input
                            type="number"
                            step="0.1"
                            label="Suhu Tubuh"
                            wire:model="body_temperat   ure"
                            suffix="°C"
                        />
                    </div>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-slate-700">Antropometri</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <x-input type="number" label="Berat Badan" wire:model="body_weight" suffix="kg" />
                        <x-input type="number" label="Tinggi Badan" wire:model="body_height" suffix="cm" />
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
