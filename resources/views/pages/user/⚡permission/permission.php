<?php

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

new class extends Component
{
    use WireUiActions;
    
    public $roles;
    public $permissions;

    #[On('role-created')]
    #[On('role-deleted')]
    public function mount()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        $role->delete();

        $this->notification()->success('Role berhasil dihapus');
        $this->dispatch('role-deleted');
    }

};
