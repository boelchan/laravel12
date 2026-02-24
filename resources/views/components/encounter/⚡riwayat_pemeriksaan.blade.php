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
            ->orderBy('created_at', 'desc')
            ->get();
    }
};
?>

<div>
    <x-modal class="h-[90vh]" title="Riwayat Pemeriksaan" wire="showHistoryModal" size="6xl">
        <div class="space-y-4">
            @if ($patient)
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-user text-lg"></i>
                        <span> {{ $patient->full_name }} </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ti ti-cake text-lg"></i>
                        <span> {{ $patient->umur_sekarang }} </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ti ti-home text-lg"></i>
                        <span> {{ $patient->address }} </span>
                    </div>
                </div>
            @endif

            @forelse ($encounterHistory as $history)
                <div class="card border border-slate-200 bg-white shadow-md">

                    <div class="flex flex-wrap gap-4 border-b border-slate-200 bg-slate-50/30 p-4">
                        <div class="flex items-center gap-2 pr-4">
                            <div class="bg-primary/10 text-primary flex h-8 w-8 items-center justify-center rounded-full">
                                <i class="ti ti-calendar-event text-lg"></i>
                            </div>
                            <div>
                                <div class="">
                                    {{ $history->created_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-slate-400">
                                    {{ $history->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>

                        @if ($history->vitalSign)
                            <div class="flex items-center gap-2 pr-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                                    <i class="ti ti-activity text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-bold uppercase text-slate-400">TTV</span>
                                    <span class="text-slate-700">
                                        {{ $history->vitalSign->systolic ?? '-' }}/{{ $history->vitalSign->diastolic ?? '-' }} <small
                                            class="text-slate-400"
                                        >mmHg</small>
                                        <span class="mx-1 text-slate-300">•</span>
                                        {{ $history->vitalSign->body_temperature ?? '-' }}<span class="text-slate-400">°C</span>
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if ($history->anthropometry)
                            <div class="flex items-center gap-2 pr-4">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                                    <i class="ti ti-scale text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-bold uppercase text-slate-400">Antropometri</span>
                                    <span class="text-slate-700">
                                        {{ $history->anthropometry->body_weight ?? '-' }}<small class="text-slate-400">kg</small>
                                        <span class="mx-1 text-slate-300">•</span>
                                        {{ $history->anthropometry->body_height ?? '-' }}<small class="text-slate-400">cm</small>
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-4">

                        {{-- Split Content: Hasil (Left) vs Hasil Drawings & Resep (Right) --}}
                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                            {{-- LEFT COLUMN: Hasil Text --}}
                            <div class="space-y-3 border-slate-200 md:border-r">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                                        <i class="ti ti-stethoscope text-lg"></i>
                                    </div>
                                    <h5 class="font-bold uppercase">Hasil Pemeriksaan</h5>
                                </div>
                                <div>
                                    @php $hasilText = $history->hasils->firstWhere('tipe', 'text'); @endphp
                                    @if ($hasilText && $hasilText->hasil)
                                        <div class="my-2">
                                            {{ $hasilText->hasil }}
                                        </div>
                                    @else
                                        <span class="italic text-slate-400">Tidak ada catatan pemeriksaan</span>
                                    @endif
                                    @php $hasilDraw = $history->hasils->firstWhere('tipe', 'draw'); @endphp
                                    @if ($hasilDraw && !empty($hasilDraw->signatures))
                                        <div class="space-y-2">
                                            @foreach ($hasilDraw->signatures as $sig)
                                                @if ($sig && strlen($sig) > 100)
                                                    <img class="h-full w-full object-contain" src="{{ $sig }}" />
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
                                    @php $resepText = $history->reseps->firstWhere('tipe', 'text'); @endphp
                                    @if ($resepText && $resepText->resep)
                                        {!! nl2br(e($resepText->resep)) !!}
                                    @else
                                        <span class="italic text-slate-400">Tidak ada resep</span>
                                    @endif

                                    @php $resepDraw = $history->reseps->firstWhere('tipe', 'draw'); @endphp
                                    @if ($resepDraw && !empty($resepDraw->signatures))
                                        <div class="space-y-2">
                                            @foreach ($resepDraw->signatures as $sig)
                                                @if ($sig && strlen($sig) > 100)
                                                    <img class="h-full w-full object-contain" src="{{ $sig }}" />
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
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
