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

    public function mount()
    {
        $this->loadRole();
        $this->loadPermission();
    }

    #[On('load-role')]
    public function loadRole()
    {
        $this->roles = Role::with('permissions')->get();
    }

    #[On('load-permission')]
    public function loadPermission()
    {
        $this->permissions = Permission::all();
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        $role->delete();

        $this->notification()->success('Role berhasil dihapus');
        $this->dispatch('load-role');
    }

    public function deletePermission($id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        $this->notification()->success('Permission berhasil dihapus');
        $this->dispatch('load-permission');
    }
};
