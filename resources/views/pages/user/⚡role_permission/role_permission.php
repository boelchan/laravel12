<?php

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;

new class extends Component
{
    use Interactions;

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
        if ($role->users()->count() > 0) {
            $this->toast()->error('Role tidak bisa dihapus karena masih digunakan')->send();
            return;
        }
        $role->delete();

        $this->toast()->success('Role berhasil dihapus')->send();
        $this->dispatch('load-role');
    }

    public function deletePermission($id)
    {
        $permission = Permission::find($id);
        if ($permission->roles()->count() > 0) {
            $this->toast()->error('Permission tidak bisa dihapus karena masih digunakan')->send();
            return;
        }
        $permission->delete();

        $this->toast()->success('Permission berhasil dihapus')->send();
        $this->dispatch('load-permission');
    }
};
