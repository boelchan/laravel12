<div>
    <form wire:submit.prevent="store">
        <input type="hidden" wire:model="permission_id">
        <x-input placeholder="Nama permission baru" wire:model="name">
            <x-slot:suffix>
                <button class="btn btn-primary btn-square" type="submit"><i class="ti ti-check text-lg"></i></button>
                <button class="btn btn-secondary btn-square" type="button" wire:click="batalEdit" wire:show="permission_id">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </x-slot:suffix>
        </x-input>
    </form>
</div>
