<div class="space-y-6 pb-10">
    {{-- Header Section --}}
    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
            <p class="text-sm text-slate-500">Pantau perkembangan data pasien dan kunjungan secara real-time.</p>
        </div>
        <div class="flex items-center gap-2">
            <x-input type="month" label="Pilih Bulan" wire:model.live="selectedMonth" />
            <button class="btn btn-primary btn-soft btn-square" type="button" wire:click="$refresh">
                <i class="ti ti-refresh text-lg"></i>
            </button>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Patients -->
        <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:shadow-md">
            <div
                class="absolute -right-4 -top-4 text-slate-50 opacity-[0.03] transition-transform group-hover:scale-110 group-hover:opacity-[0.05]">
                <i class="ti ti-users text-9xl"></i>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-primary/10 text-primary flex h-12 w-12 items-center justify-center rounded-xl">
                    <i class="ti ti-users text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Total Pasien</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-900">{{ number_format($this->stats['total_patients']) }}</span>
                        <span class="text-xs font-medium text-slate-400">orang</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Encounters -->
        <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:shadow-md">
            <div
                class="text-info absolute -right-4 -top-4 opacity-[0.03] transition-transform group-hover:scale-110 group-hover:opacity-[0.05]">
                <i class="ti ti-stethoscope text-9xl"></i>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-info/10 text-info flex h-12 w-12 items-center justify-center rounded-xl">
                    <i class="ti ti-stethoscope text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Kunjungan Hari Ini</h3>
                    <span class="text-3xl font-bold text-slate-900">{{ number_format($this->stats['today_encounters']) }}</span>
                </div>
            </div>
        </div>

        <!-- Monthly Encounters -->
        <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:shadow-md">
            <div
                class="text-warning absolute -right-4 -top-4 opacity-[0.03] transition-transform group-hover:scale-110 group-hover:opacity-[0.05]">
                <i class="ti ti-calendar-event text-9xl"></i>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-warning/10 text-warning flex h-12 w-12 items-center justify-center rounded-xl">
                    <i class="ti ti-calendar-event text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Kunjungan Bulan Ini</h3>
                    <span class="text-3xl font-bold text-slate-900">{{ number_format($this->stats['monthly_encounters']) }}</span>
                </div>
            </div>
        </div>

        <!-- New Patients Today -->
        <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:shadow-md">
            <div
                class="text-success absolute -right-4 -top-4 opacity-[0.03] transition-transform group-hover:scale-110 group-hover:opacity-[0.05]">
                <i class="ti ti-user-plus text-9xl"></i>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-success/10 text-success flex h-12 w-12 items-center justify-center rounded-xl">
                    <i class="ti ti-user-plus text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Pasien Baru Hari Ini</h3>
                    <span class="text-3xl font-bold text-slate-900">{{ number_format($this->stats['new_patients_today']) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Shortcut Buttons & In Progress --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="flex flex-col gap-2 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-6 lg:col-span-2">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400">Akses Cepat</h3>
            <div class="flex flex-wrap gap-3">
                <a class="btn btn-white group border-slate-200 shadow-sm" href="{{ route('patient.index') }}" wire:navigate>
                    <div
                        class="bg-primary/10 text-primary group-hover:bg-primary flex h-8 w-8 items-center justify-center rounded-lg transition-colors group-hover:text-white">
                        <i class="ti ti-users"></i>
                    </div>
                    <span>Daftar Pasien</span>
                </a>
                <a class="btn btn-white group border-slate-200 shadow-sm" href="{{ route('encounter.index') }}" wire:navigate>
                    <div
                        class="bg-info/10 text-info group-hover:bg-info flex h-8 w-8 items-center justify-center rounded-lg transition-colors group-hover:text-white">
                        <i class="ti ti-layout-list"></i>
                    </div>
                    <span>Data Kunjungan</span>
                </a>
                <a class="btn btn-outline btn-primary border-primary/30" href="{{ route('patient.create') }}" wire:navigate>
                    <i class="ti ti-user-plus mr-1.5"></i> Tambah Pasien Baru
                </a>
            </div>
        </div>

        {{-- In Progress Patients --}}
        <div class="border-info/20 bg-info/5 animate-in fade-in slide-in-from-right-4 rounded-2xl border p-6 duration-500">
            <h3 class="text-info mb-4 flex items-center gap-2 text-xs font-bold uppercase tracking-widest">
                <span class="relative flex h-2 w-2">
                    <span class="bg-info absolute inline-flex h-full w-full animate-ping rounded-full opacity-75"></span>
                    <span class="bg-info relative inline-flex h-2 w-2 rounded-full"></span>
                </span>
                Sedang Diperiksa
            </h3>
            <div class="space-y-3">
                @forelse($this->inprogressEncounters as $inc)
                    <div class="border-info/10 group flex items-center justify-between rounded-xl border bg-white p-3 shadow-sm">
                        <div class="min-w-0">
                            <div class="truncate text-sm font-bold text-slate-800">{{ $inc->patient->full_name }}</div>
                            <div class="flex items-center gap-1 font-mono text-[10px] text-slate-500">
                                <i class="ti ti-hash"></i>{{ $inc->no_antrian }} • {{ $inc->patient->medical_record_number }}
                            </div>
                        </div>
                        <a class="btn btn-info btn-square btn-soft btn-xs group-hover:bg-info shadow-sm transition-all group-hover:text-white"
                            href="{{ route('encounter.edit', [$inc->id, $inc->uuid]) }}" 
                        >
                            <i class="ti ti-chevron-right text-lg"></i>
                        </a>
                    </div>
                @empty
                    <div class="text-info/50 flex flex-col items-center justify-center py-4 text-center text-xs italic">
                        <i class="ti ti-medical-cross mb-2 text-2xl opacity-20"></i>
                        Tidak ada pasien yang sedang diperiksa
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Daily Encounters Chart --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Tren Kunjungan Harian</h3>
                    <p class="text-xs text-slate-500">Statistik untuk bulan {{ date('F Y', strtotime($selectedMonth . '-01')) }}</p>
                </div>
                <div class="bg-info/5 text-info flex h-8 w-8 items-center justify-center rounded-lg">
                    <i class="ti ti-chart-line text-lg"></i>
                </div>
            </div>
            <div class="min-h-[300px]" id="dailyEncountersChart" wire:ignore></div>
        </div>

        {{-- New Patients Chart --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Pasien Baru (14 Hari Terakhir)</h3>
                    <p class="text-xs text-slate-500">Jumlah pendaftaran pasien baru per hari</p>
                </div>
                <div class="bg-success/5 text-success flex h-8 w-8 items-center justify-center rounded-lg">
                    <i class="ti ti-chart-bar text-lg"></i>
                </div>
            </div>
            <div class="min-h-[300px]" id="newPatientsChart" wire:ignore></div>
        </div>
    </div>

    @script
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                const chartOptions = {
                    fontFamily: 'Inter, sans-serif',
                    chart: {
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },
                    grid: {
                        strokeDashArray: 4,
                        padding: {
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    dataLabels: {
                        enabled: false
                    },
                };

                // Encounter Chart
                const encounterChart = new ApexCharts(document.querySelector("#dailyEncountersChart"), {
                    ...chartOptions,
                    chart: {
                        ...chartOptions.chart,
                        type: 'area',
                        height: 300
                    },
                    series: [{
                        name: 'Kunjungan',
                        data: @json($this->encounterChartData['data'])
                    }],
                    colors: ['#0ea5e9'],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [20, 100]
                        }
                    },
                    xaxis: {
                        categories: @json($this->encounterChartData['labels']),
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    }
                });
                encounterChart.render();

                // Patient Chart
                const patientChart = new ApexCharts(document.querySelector("#newPatientsChart"), {
                    ...chartOptions,
                    chart: {
                        ...chartOptions.chart,
                        type: 'bar',
                        height: 300
                    },
                    series: [{
                        name: 'Pasien Baru',
                        data: @json($this->patientChartData['data'])
                    }],
                    colors: ['#10b981'],
                    plotOptions: {
                        bar: {
                            borderRadius: 6,
                            columnWidth: '40%',
                            distributed: false
                        }
                    },
                    xaxis: {
                        categories: @json($this->patientChartData['labels']),
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    }
                });
                patientChart.render();

                // Listen for Livewire updates to refresh charts
                Livewire.on('refreshCharts', () => {
                    // For Volt component, we might need a different approach if using refresh, 
                    // but usually re-rendering or direct data update works.
                });

                // Re-render when selectedMonth changes
                $wire.on('monthUpdated', () => {
                    // Update implementation if needed
                });
            });
        </script>
    @endscript

</div>
