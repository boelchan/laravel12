<?php

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

new class extends Component
{
    public $roles;
    public $permissions;

    public function mount()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }
};
