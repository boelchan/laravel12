<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;

new class extends Component
{
    public $role_id;
    public $name;

    #[On('role-edit')]
    public function edit($role_id)
    {
        $role = Role::findOrFail($role_id);
        $this->name = $role->name;
        $this->role_id = $role->id;
    }
    
    public function store()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::updateOrCreate(['id' => $this->role_id], ['name' => $this->name]);

        $this->reset();

        $this->dispatch('role-created');
    }
};