<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Encounter;

new class extends Component {
    public $jumlah_pendaftar;
    public $booking_date;

    #[On('load-jumlah-pendaftar')]
    public function loadJumlahPendaftar($booking_date)
    {
        $this->booking_date = $booking_date;
        $this->jumlah_pendaftar = Encounter::where('visit_date', $booking_date)->count();
    }
};
?>

<div>
    @placeholder
        <div>
            sdsdsds
        </div>
    @endplaceholder

    @if ($booking_date)
        <div class="bg-info/5 border-info/10 flex items-center gap-4 rounded-lg border p-3">
            <div class="text-info flex h-10 w-10 items-center justify-center rounded-lg bg-white shadow-sm">
                <span class="text-lg font-bold">{{ $jumlah_pendaftar }}</span>
            </div>
            <div>
                <div class="text-info text-[10px] font-medium uppercase tracking-wider">Antrian Saat Ini</div>
                <div class="text-xs font-medium text-slate-600">
                    <span>Pasien telah terdaftar pada tanggal tersebut</span>
                </div>
            </div>
        </div>
    @endif
</div>
