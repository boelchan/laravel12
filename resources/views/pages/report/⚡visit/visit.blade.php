<div>
    <div class="flex justify-between align-middle">
        <div>
            <h1 class="text-2xl font-medium text-slate-900">Rekap Kunjungan</h1>
            <div class="breadcrumbs p-0 text-xs text-slate-500">
                <ul>
                    <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
                    <li>Laporan</li>
                    <li>Rekap Kunjungan</li>
                </ul>
            </div>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-soft btn-success btn-sm" wire:click="export" wire:loading.attr="disabled">
                <i class="ti ti-file-spreadsheet text-lg" wire:loading.remove wire:target="export"></i>
                <i class="ti ti-loader-2 animate-spin text-lg" wire:loading wire:target="export"></i>
                Export Excel
            </button>
        </div>
    </div>

    <div class="mt-6">
        {{-- filter --}}
        <div class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
            <div class="flex justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-800">Filter Data</span>
                    <button class="btn btn-soft btn-error btn-xs w-6" type="button" wire:click="resetFilters">
                        <i class="ti ti-filter-x text-lg"></i>
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-4">
                <x-input type="month" label="Bulan & Tahun" wire:model.live="search_month" />
                
                <x-select.styled 
                    label="Status Kunjungan" 
                    placeholder="Semua Status"
                    :options="App\Enums\StatusEncounterEnum::choices()"
                    wire:model.live="search_status" 
                />
            </div>
        </div>
        {{-- end filter --}}

        <div class="mt-6">
            <x-table :paginate="$this->dataTable">
                <x-table.thead class="bg-slate-50" :sortDirection="$sortDirection" :sortField="$sortField">
                    <x-table.th width="5%" label="No" />
                    <x-table.th label="Tanggal" sort="visit_date" />
                    <x-table.th label="Jumlah Kunjungan" sort="total" />
                </x-table.thead>

                <tbody>
                    @forelse ($this->dataTable as $index => $d)
                        <tr class="bg-white hover:bg-neutral-50" wire:key="recap-{{ $d->visit_date }}">
                            <td class="p-2 text-center"> 
                                {{ $perPage * ($this->dataTable->currentPage() - 1) + $index + 1 }} 
                            </td>
                            <td class="p-2 font-medium"> 
                                {{ \Carbon\Carbon::parse($d->visit_date)->translatedFormat('l, d F Y') }} 
                            </td>
                            <td class="p-2"> 
                                <span class="badge badge-primary">{{ $d->total }} Pasien</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-4 text-center text-slate-500" colspan="3">Tidak ada data untuk filter ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </x-table>
        </div>
    </div>
</div>
