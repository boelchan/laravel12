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
            </div>
        </div>
        {{-- end filter --}}

        <div class="mt-6">
            <x-table :paginate="$this->dataTable">
                <x-table.thead class="bg-slate-50" :sortDirection="$sortDirection" :sortField="$sortField">
                    <x-table.th width="5%" label="No" />
                    <x-table.th label="Tanggal" sort="visit_date" />
                    <x-table.th label="Total" sort="total" width="10%" />
                    <x-table.th label="Belum Datang" width="10%" />
                    <x-table.th label="Datang" width="10%" />
                    <x-table.th label="Pemeriksaan" width="10%" />
                    <x-table.th label="Selesai" width="10%" />
                    <x-table.th label="Batal" width="10%" />
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
                            <td class="p-2 text-center">
                                <span class="badge badge-ghost font-bold">{{ $d->total }}</span>
                            </td>
                            <td class="p-2 text-center">
                                @if($d->belum_datang > 0)
                                    <span class="badge badge-info">{{ $d->belum_datang }}</span>
                                @else
                                    <span class="text-slate-300">0</span>
                                @endif
                            </td>
                            <td class="p-2 text-center">
                                @if($d->datang > 0)
                                    <span class="badge badge-primary">{{ $d->datang }}</span>
                                @else
                                    <span class="text-slate-300">0</span>
                                @endif
                            </td>
                            <td class="p-2 text-center">
                                @if($d->in_progress > 0)
                                    <span class="badge badge-warning">{{ $d->in_progress }}</span>
                                @else
                                    <span class="text-slate-300">0</span>
                                @endif
                            </td>
                            <td class="p-2 text-center">
                                @if($d->selesai > 0)
                                    <span class="badge badge-success">{{ $d->selesai }}</span>
                                @else
                                    <span class="text-slate-300">0</span>
                                @endif
                            </td>
                            <td class="p-2 text-center">
                                @if($d->batal > 0)
                                    <span class="badge badge-error">{{ $d->batal }}</span>
                                @else
                                    <span class="text-slate-300">0</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-4 text-center text-slate-500" colspan="8">Tidak ada data untuk filter ini</td>
                        </tr>
                    @endforelse
                </tbody>

                @if($this->grandTotals && $this->dataTable->count() > 0)
                    <tfoot>
                        <tr class="bg-slate-100 font-bold text-slate-800">
                            <td class="p-2 text-center" colspan="2">Grand Total</td>
                            <td class="p-2 text-center">
                                <span class="badge badge-ghost font-bold">{{ $this->grandTotals->total }}</span>
                            </td>
                            <td class="p-2 text-center">
                                <span class="badge badge-info">{{ $this->grandTotals->belum_datang }}</span>
                            </td>
                            <td class="p-2 text-center">
                                <span class="badge badge-primary">{{ $this->grandTotals->datang }}</span>
                            </td>
                            <td class="p-2 text-center">
                                <span class="badge badge-warning">{{ $this->grandTotals->in_progress }}</span>
                            </td>
                            <td class="p-2 text-center">
                                <span class="badge badge-success">{{ $this->grandTotals->selesai }}</span>
                            </td>
                            <td class="p-2 text-center">
                                <span class="badge badge-error">{{ $this->grandTotals->batal }}</span>
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </x-table>
        </div>
    </div>
</div>
