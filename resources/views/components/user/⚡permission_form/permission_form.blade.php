<div>
    @island(lazy: true)
        <form wire:submit.prevent="store">
            <div class="flex gap-0">
                <input type="hidden" wire:model="permission_id">
                <x-input placeholder="Nama permission baru" wire:model="name" />
                <button class="btn btn-primary btn-square" type="submit"><i class="ti ti-check text-lg"></i></button>
                <button class="btn btn-soft btn-secondary btn-square" type="button" wire:click="batalEdit" wire:show="permission_id"><i
                        class="ti ti-x text-lg"
                    ></i></button>
            </div>
        </form>
    @endisland
</div>
