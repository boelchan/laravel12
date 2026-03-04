<div>
    <div class="flex justify-between align-middle">
        <div>
            <h1 class="text-2xl font-medium text-slate-900">Farmasi / Apotik</h1>
            <div class="breadcrumbs p-0 text-xs text-slate-500">
                <ul>
                    <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
                    <li>Farmasi</li>
                    <li>Antrian Resep</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{-- filter --}}
        <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <span class="font-semibold text-slate-800">Filter Pencarian</span>
                <button class="btn btn-soft btn-error btn-xs w-6" type="button" wire:click="resetFilters">
                    <i class="ti ti-filter-x text-lg"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <x-date label="Tanggal Kunjungan" wire:model.live.debounce.500ms="search_visit_date" />
                <x-input label="Nama Pasien" placeholder="Cari nama..." wire:model.live.debounce.500ms="search_full_name" clearable />
                <x-select.native label="Status Obat" 
                    wire:model.live="search_status_obat"
                    :options="[
                        ['label' => 'Semua', 'value' => ''],
                        ['label' => 'Belum Diambil', 'value' => 'not_taken'],
                        ['label' => 'Sudah Diambil', 'value' => 'taken'],
                    ]"
                />
            </div>
        </div>
        {{-- end filter --}}

        <div class="mt-6">
            <x-table :paginate="$this->dataTable">
                <x-table.thead class="bg-slate-50" :sortDirection="$sortDirection" :sortField="$sortField">
                    <x-table.th width="5%" label="No" />
                    <x-table.th label="Antrian" sort="no_antrian" width="10%" />
                    <x-table.th label="Pasien" width="25%" />
                    <x-table.th label="Status Obat" width="15%" />
                    <x-table.th label="Catatan Farmasi" />
                    <x-table.th width="10%" label="Aksi" />
                </x-table.thead>

                <tbody>
                    @forelse ($this->dataTable as $index => $d)
                        <tr class="bg-white hover:bg-neutral-50 transition-colors" wire:key="pharmacy-{{ $d->id }}">
                            <td class="p-3 text-center text-slate-500"> {{ $perPage * ($this->dataTable->currentPage() - 1) + $index + 1 }} </td>
                            <td class="p-3 text-center font-bold"> {{ $d->no_antrian }} </td>
                            <td class="p-3">
                                <div class="font-bold text-slate-800">{{ $d->patient->full_name }}</div>
                                <div class="text-xs text-slate-500">{{ $d->patient->medical_record_number }}</div>
                            </td>
                            <td class="p-3">
                                @if($d->obat_diambil_at)
                                    <div class="flex flex-col">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-success/10 px-2.5 py-0.5 text-xs font-medium text-success">
                                            <i class="ti ti-check text-sm"></i> Sudah Diambil
                                        </span>
                                        <span class="text-[10px] text-slate-400 mt-1">
                                            {{ \Carbon\Carbon::parse($d->obat_diambil_at)->format('d/m H:i') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-warning/10 px-2.5 py-0.5 text-xs font-medium text-warning">
                                        <i class="ti ti-clock text-sm"></i> Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="p-3 text-xs text-slate-600 italic">
                                {{ Str::limit($d->catatan_farmasi, 50) ?: '-' }}
                            </td>
                            <td class="p-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="btn btn-sm btn-primary btn-soft" 
                                        wire:click="openModalResep({{ $d->id }})"
                                        title="Lihat Resep & Proses"
                                    >
                                        <i class="ti ti-prescription text-lg"></i> Resep
                                    </button>
                                    @if($d->obat_diambil_at)
                                        <button class="btn btn-sm btn-error btn-ghost btn-square" 
                                            wire:click="unmarkAsTaken({{ $d->id }})"
                                            title="Batalkan Status Diambil"
                                        >
                                            <i class="ti ti-rotate text-lg"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-8 text-center text-slate-400" colspan="7">
                                <div class="flex flex-col items-center">
                                    <i class="ti ti-prescription-off text-4xl mb-2 opacity-20"></i>
                                    <p>Tidak ada antrian resep hari ini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-table>
        </div>
    </div>

    {{-- Modal Resep --}}
    <x-modal id="modalResep" title="Detail Resep Pasien" wire="modalResep" size="3xl">
        @if($this->selectedEncounter)
            <div class="space-y-6">
                {{-- Patient Info Header --}}
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-primary/10 text-primary flex h-12 w-12 items-center justify-center rounded-full">
                            <i class="ti ti-user text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">{{ $this->selectedEncounter->patient->full_name }}</h3>
                            <p class="text-sm text-slate-500">
                                RM: {{ $this->selectedEncounter->patient->medical_record_number }} | 
                                Antrian: <span class="font-bold text-primary">{{ $this->selectedEncounter->no_antrian }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Waktu Selesai Periksa</p>
                        <p class="text-sm font-semibold text-slate-700">
                            {{ \Carbon\Carbon::parse($this->selectedEncounter->finished_at)->format('H:i') }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Prescription List --}}
                    <div class="space-y-4">
                        <h4 class="flex items-center gap-2 font-bold text-slate-700">
                            <i class="ti ti-list-details text-primary"></i> Daftar Resep
                        </h4>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 min-h-[200px] font-sans text-sm text-slate-800 leading-relaxed">
                            @php $hasResep = false; @endphp
                            @foreach($this->selectedEncounter->reseps as $resep)
                                @if($resep->tipe == 'text' && $resep->resep)
                                    <div class="mb-4 last:mb-0 border-b border-slate-200 pb-4 last:border-0 last:pb-0 whitespace-pre-wrap">
                                        <div class="text-[10px] font-bold uppercase text-slate-400 mb-2">Rincian Obat (Text)</div>
                                        {!! nl2br(e($resep->resep)) !!}
                                        @php $hasResep = true; @endphp
                                    </div>
                                @elseif($resep->tipe == 'draw' && count($resep->signatures ?? []) > 0)
                                    <div class="mb-4 last:mb-0 border-b border-slate-200 pb-4 last:border-0 last:pb-0">
                                        <div class="text-[10px] font-bold uppercase text-slate-400 mb-2">Resep Digital (Coretan)</div>
                                        <div class="grid grid-cols-1 gap-4">
                                            @foreach($resep->signatures as $sig)
                                                @if($sig)
                                                    <div class="bg-white border border-slate-200 rounded-lg p-2 flex justify-center shadow-sm">
                                                        <img src="{{ $sig }}" class="max-w-full h-auto" alt="Resep Digital">
                                                    </div>
                                                    @php $hasResep = true; @endphp
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            
                            @if(!$hasResep)
                                <div class="text-slate-400 italic text-center flex flex-col items-center justify-center h-40">
                                    <i class="ti ti-notes-off text-3xl mb-2 opacity-20"></i>
                                    Tidak ada rincian resep
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Pharmacy Processing --}}
                    <div class="space-y-4">
                        <h4 class="flex items-center gap-2 font-bold text-slate-700">
                            <i class="ti ti-note text-primary"></i> Proses Farmasi
                        </h4>
                        
                        <div class="space-y-4">
                            <x-textarea label="Catatan Farmasi" 
                                placeholder="Tambahkan catatan jika ada (misal: obat diganti, stok kosong, dll)..." 
                                wire:model="catatan_farmasi"
                                rows="5"
                            />

                            @if($this->selectedEncounter->obat_diambil_at)
                                <div class="rounded-lg bg-success/10 p-4 border border-success/20">
                                    <div class="flex items-center gap-3 text-success">
                                        <i class="ti ti-circle-check text-2xl"></i>
                                        <div>
                                            <p class="font-bold text-sm">Sudah Diambil</p>
                                            <p class="text-xs">{{ \Carbon\Carbon::parse($this->selectedEncounter->obat_diambil_at)->format('d F Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-3">
                    <button class="btn btn-ghost" type="button" wire:click="$set('modalResep', false)">Tutup</button>
                    @if(!$this->selectedEncounter->obat_diambil_at)
                        <button class="btn btn-success px-6 shadow-lg shadow-success/20" type="button" wire:click="markAsTaken">
                            <i class="ti ti-check mr-1.5"></i> Tandai Sudah Diambil
                        </button>
                    @else
                        <button class="btn btn-primary px-6" type="button" wire:click="markAsTaken">
                            <i class="ti ti-device-floppy mr-1.5"></i> Perbarui Catatan
                        </button>
                    @endif
                </div>
            </x-slot>
        @else
            <div class="flex flex-col items-center justify-center p-12 text-slate-400">
                <i class="ti ti-loader animate-spin text-4xl mb-4"></i>
                <p>Memuat data...</p>
            </div>
        @endif
    </x-modal>
</div>