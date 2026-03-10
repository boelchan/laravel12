<div class="space-y-6 pb-10">
    {{-- Header Section --}}
    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
            <p class="text-sm text-slate-500">Pantau perkembangan data pasien dan kunjungan secara real-time.</p>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Patients -->
        <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-2 shadow-sm transition hover:shadow-md">
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

        <!-- New Patients Today -->
        <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-2 shadow-sm transition hover:shadow-md">
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
        <!-- Today's Encounters -->
        <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-2 shadow-sm transition hover:shadow-md">
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
        <div class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-2 shadow-sm transition hover:shadow-md">
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

    </div>

    {{-- Shortcut Buttons & In Progress --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="flex flex-col gap-2 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-6">
            <span class="font-bold uppercase tracking-widest text-slate-400">Akses Cepat</span>
            <div class="flex flex-wrap gap-3">

                @can('kunjungan-list')
                    <a class="btn btn-dark btn-outline" href="{{ route('encounter.index') }}" wire:navigate>
                        <i class="ti ti-calendar-check mr-1 text-lg"></i>
                        <span>Data Kunjungan</span>
                    </a>
                @endcan
                @can('pasien-list')
                    <a class="btn btn-primary btn-outline" href="{{ route('patient.index') }}" wire:navigate>
                        <i class="ti ti-users mr-1 text-lg"></i>
                        <span>Data Pasien</span>
                    </a>
                @endcan
                @can('pasien-tambah')
                    <a class="btn btn-primary btn-outline" href="{{ route('patient.create') }}" wire:navigate>
                        <i class="ti ti-user-plus mr-1 text-lg"></i> Tambah Pasien Baru
                    </a>
                @endcan
                @can('rekap-kunjungan')
                    <a class="btn btn-secondary btn-outline" href="{{ route('report.visit-recap') }}" wire:navigate>
                        <i class="ti ti-report mr-1 text-lg"></i> Rekap Kunjungan
                    </a>
                @endcan
                @can('rekap-pasien')
                    <a class="btn btn-secondary btn-outline" href="{{ route('report.patient-registration-recap') }}" wire:navigate>
                        <i class="ti ti-report-medical mr-1 text-lg"></i> Rekap Pasien Baru
                    </a>
                @endcan
                @can('apotek-list')
                    <a class="btn btn-warning btn-outline" href="{{ route('pharmacy.index') }}" wire:navigate>
                        <i class="ti ti-pill mr-1 text-lg"></i> Apotek
                    </a>
                @endcan
            </div>
        </div>

        {{-- In Progress Patients --}}
        <div class="border-warning bg-warning/5 animate-in fade-in slide-in-from-right-4 rounded-2xl border p-6 duration-500">
            <h3 class="text-warning mb-4 flex items-center gap-2 font-bold uppercase tracking-widest">
                <span class="relative flex h-2 w-2">
                    <span class="bg-warning absolute inline-flex h-full w-full animate-ping rounded-full opacity-75"></span>
                    <span class="bg-warning relative inline-flex h-2 w-2 rounded-full"></span>
                </span>
                Sedang Diperiksa
            </h3>
            <div class="space-y-3">
                @forelse($this->inprogressEncounters as $inc)
                    <div class="border-warning/10 group flex items-center justify-between rounded-xl border bg-white p-3 shadow-sm">
                        <div class="min-w-0">
                            <div class="truncate text-sm font-bold text-slate-800">{{ $inc->patient->full_name }}</div>
                            <div class="flex items-center gap-1 font-mono text-[10px] text-slate-500">
                                <i class="ti ti-hash"></i>{{ $inc->no_antrian }} • {{ $inc->patient->medical_record_number }} •
                                {{ $inc->patient->village?->name }}
                            </div>
                        </div>
                        @can('kunjungan-edit-pemeriksaan')
                            <a class="btn btn-warning btn-square btn-md" href="{{ route('encounter.edit', [$inc->id, $inc->uuid]) }}">
                                <i class="ti ti-stethoscope text-2xl font-bold"></i>
                            </a>
                        @endcan
                    </div>
                @empty
                    <div class="text-warning italic">
                        Tidak ada pasien yang sedang diperiksa
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="flex items-center gap-2">
        <x-input type="month" wire:model.live="selectedMonth" />
        <button class="btn btn-primary btn-soft btn-square" type="button" wire:click="$refresh">
            <i class="ti ti-refresh text-lg"></i>
        </button>
    </div>

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
            <div class="relative h-[300px] w-full" wire:ignore>
                <canvas id="dailyEncountersChart"></canvas>
            </div>
        </div>

        {{-- New Patients Chart --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Pasien Baru</h3>
                    <p class="text-xs text-slate-500">Pendaftaran pasien baru bulan {{ date('F Y', strtotime($selectedMonth . '-01')) }}
                    </p>
                </div>
                <div class="bg-success/5 text-success flex h-8 w-8 items-center justify-center rounded-lg">
                    <i class="ti ti-chart-bar text-lg"></i>
                </div>
            </div>
            <div class="relative h-[300px] w-full" wire:ignore>
                <canvas id="newPatientsChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    @script
        <script>
            let encounterChart = null;
            let patientChart = null;

            const initCharts = (encounterData, patientData) => {
                const ctxEncounter = document.getElementById('dailyEncountersChart');
                const ctxPatient = document.getElementById('newPatientsChart');

                if (!ctxEncounter || !ctxPatient) return;

                // Destroy existing charts if they exist
                if (encounterChart) encounterChart.destroy();
                if (patientChart) patientChart.destroy();

                const eData = encounterData || $wire.encounterChartData;
                const pData = patientData || $wire.patientChartData;

                // Encounter Chart (Line/Area)
                encounterChart = new Chart(ctxEncounter.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: eData.labels,
                        datasets: [{
                            label: 'Kunjungan',
                            data: eData.data,
                            borderColor: '#0ea5e9',
                            backgroundColor: 'rgba(14, 165, 233, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: true,
                                    drawBorder: false,
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });

                // Patient Chart (Line/Area)
                patientChart = new Chart(ctxPatient.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: pData.labels,
                        datasets: [{
                            label: 'Pasien Baru',
                            data: pData.data,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: true,
                                    drawBorder: false,
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            };

            // Initial load
            initCharts();

            // Refresh on Livewire updates
            $wire.on('refreshCharts', (data) => {
                // Livewire v3 passes data payload inside an array, so it sits at data[0] when using named dispatcher arguments
                const payload = Array.isArray(data) ? data[0] : data;

                if (payload) {
                    initCharts(payload.encounterData, payload.patientData);
                } else {
                    initCharts();
                }
            });
        </script>
    @endscript

</div>
