<?php

use App\Models\Encounter;
use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $patient_id;
    public $patient;
    public $showHistoryModal = false;
    public $encounterHistory = [];

    #[On('open-history-modal')]
    public function openHistory($patient_id)
    {
        $this->showHistoryModal = true;

        $this->patient = Patient::find($patient_id);

        $this->encounterHistory = Encounter::where('patient_id', $patient_id)
            ->with(['vitalSign', 'anthropometry', 'hasils', 'reseps'])
            ->orderBy('visit_date', 'desc')
            ->get();
    }
};
?>

<div>
    <x-modal
        class="h-[90vh]"
        title="Riwayat Pemeriksaan"
        wire="showHistoryModal"
        size="6xl"
    >
        <div class="space-y-4">
            @if ($patient)
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-user text-lg"></i>
                        <span> {{ $patient->full_name }} </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ti ti-home text-lg"></i>
                        <span> {{ $patient->village?->name }} - {{ $patient->district?->name }} - {{ $patient->regency?->name }} </span>
                    </div>
                </div>
            @endif

            @forelse ($encounterHistory as $enc)
                <div class="card border border-slate-200 bg-white shadow-md">

                    <div class="flex flex-wrap gap-4 border-b border-slate-200 bg-slate-50/30 p-4">
                        <div class="flex items-center gap-2 pr-4">
                            <div class="bg-primary/10 text-primary flex h-8 w-8 items-center justify-center rounded-full">
                                <i class="ti ti-calendar-event text-lg"></i>
                            </div>
                            <div>
                                <div class="">
                                    {{ $enc->visit_date }}
                                </div>
                                <div class="text-xs text-slate-400">
                                    {!! $enc->statusBadge !!}
                                </div>
                            </div>
                        </div>

                        @if ($enc->vitalSign)
                            <div class="flex items-center gap-2 pr-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                                    <i class="ti ti-activity text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-bold uppercase text-slate-400">TTV</span>
                                    <span class="text-slate-700">
                                        {{ $enc->vitalSign->systolic ?? '-' }}/{{ $enc->vitalSign->diastolic ?? '-' }} <small
                                            class="text-slate-400"
                                        >mmHg</small>
                                        <span class="mx-1 text-slate-300">•</span>
                                        {{ $enc->vitalSign->body_temperature ?? '-' }}<span class="text-slate-400">°C</span>
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if ($enc->anthropometry)
                            <div class="flex items-center gap-2 pr-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                                    <i class="ti ti-scale text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-bold uppercase text-slate-400">BB/TB</span>
                                    <span class="text-slate-700">
                                        {{ $enc->anthropometry->body_weight ?? '-' }}<small class="text-slate-400">kg</small>
                                        <span class="mx-1 text-slate-300">•</span>
                                        {{ $enc->anthropometry->body_height ?? '-' }}<small class="text-slate-400">cm</small>
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body border-b border-slate-200 p-4">
                        <p class="font-bold">KELUHAN</p>
                        <p>{{ $enc->chief_complaint }}</p>
                    </div>
                    <div class="card-body border-b border-slate-200 p-4">
                        <p class="font-bold">Dokumen</p>
                        @if ($enc->documents && count($enc->documents) > 0)
                            <div class="mt-4 space-y-2">
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach ($enc->documents as $doc)
                                        <div class="flex items-center justify-between rounded-lg border border-slate-100 bg-slate-50 p-2">
                                            <div class="flex items-center gap-2 overflow-hidden">
                                                <i class="ti ti-file text-slate-500"></i>
                                                <span
                                                    class="truncate text-xs"
                                                    title="{{ $doc->name }}"
                                                >{{ $doc->name }}</span>
                                            </div>
                                            <div class="flex gap-1">
                                                <button
                                                    class="btn btn-ghost btn-primary btn-square btn-xs"
                                                    type="button"
                                                    wire:click="$dispatch('open_preview', ['{{ $doc->file_path }}'])"
                                                >
                                                    <i class="ti ti-eye text-base text-blue-500"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    @can('kunjungan-edit-pemeriksaan')
                        @if ($enc->status == 'finished')
                            <div class="card-body p-4">

                                {{-- Split Content: Hasil (Left) vs Hasil Drawings & Resep (Right) --}}
                                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                                    {{-- LEFT COLUMN: Hasil Text --}}
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                                                <i class="ti ti-stethoscope text-lg"></i>
                                            </div>
                                            <h5 class="font-bold uppercase">Hasil Pemeriksaan</h5>
                                        </div>
                                        <div>
                                            @php $hasilText = $enc->hasils->firstWhere('tipe', 'text'); @endphp
                                            @if ($hasilText && $hasilText->hasil)
                                                <div class="my-2">
                                                    {{ $hasilText->hasil }}
                                                </div>
                                            @else
                                                <span class="italic text-slate-400">Tidak ada catatan pemeriksaan</span>
                                            @endif
                                            @php $hasilDraw = $enc->hasils->firstWhere('tipe', 'draw'); @endphp
                                            @if ($hasilDraw && !empty($hasilDraw->signatures))
                                                <div class="space-y-2">
                                                    @foreach ($hasilDraw->signatures as $sig)
                                                        @if ($sig && strlen($sig) > 100)
                                                            <img
                                                                class="h-full w-full object-contain"
                                                                src="{{ $sig }}"
                                                            />
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- RIGHT COLUMN: Drawings & Resep --}}
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                                                <i class="ti ti-pill text-lg"></i>
                                            </div>
                                            <h5 class="font-bold uppercase">Resep</h5>
                                        </div>
                                        <div>
                                            @php $resepText = $enc->reseps->firstWhere('tipe', 'text'); @endphp
                                            @if ($resepText && $resepText->resep)
                                                {!! nl2br(e($resepText->resep)) !!}
                                            @else
                                                <span class="italic text-slate-400">Tidak ada resep</span>
                                            @endif

                                            @php $resepDraw = $enc->reseps->firstWhere('tipe', 'draw'); @endphp
                                            @if ($resepDraw && !empty($resepDraw->signatures))
                                                <div class="space-y-2">
                                                    @foreach ($resepDraw->signatures as $sig)
                                                        @if ($sig && strlen($sig) > 100)
                                                            <img
                                                                class="h-full w-full object-contain"
                                                                src="{{ $sig }}"
                                                            />
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endcan
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-slate-500">
                    <div class="mb-4 rounded-full bg-slate-100 p-4">
                        <i class="ti ti-clipboard-list text-3xl opacity-20"></i>
                    </div>
                    <p class="font-medium">Tidak ada riwayat pemeriksaan</p>
                    <p class="mt-1 text-xs text-slate-400">Belum ada data kunjungan untuk pasien ini.</p>
                </div>
            @endforelse
        </div>
    </x-modal>
</div>
