<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;

new class extends Component {
    public $role_id;
    public $name;

    #[On('role-edit')]
    public function edit($role_id)
    {
        $role = Role::findOrFail($role_id);
        $this->name = $role->name;
        $this->role_id = $role->id;
    }

    public function batalEdit()
    {
        $this->reset();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::updateOrCreate(['id' => $this->role_id], ['name' => $this->name]);
        $this->reset();
        $this->dispatch('load-role');
    }
};
?>

<div>
    @island(lazy: true)
        <form wire:submit.prevent="store">
            <div class="flex gap-0">
                <input type="hidden" wire:model="role_id">
                <x-input placeholder="Nama role baru" wire:model="name" />
                <x-button>TallStackUi</x-button>
                <button class="btn btn-primary btn-square" type="submit"><i class="ti ti-check text-lg"></i></button>
                <button class="btn btn-soft btn-secondary btn-square" type="button" wire:click="batalEdit" wire:show="role_id"><i
                        class="ti ti-x text-lg"
                    ></i></button>
            </div>
        </form>
    @endisland
</div>
