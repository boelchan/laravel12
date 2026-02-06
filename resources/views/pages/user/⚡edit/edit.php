<?php

use Livewire\Component;
use TallStackUi\Traits\Interactions;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

new class extends Component
{
    use Interactions;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role;
    public $id;
    public $status;

    public $roles;

    public function mount(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status;

        $this->role = $user->roles->pluck('name')->toArray();

        $this->roles = Role::pluck('name', 'id')->all();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'password' => 'confirmed',
            'role' => 'required',
            'status' => 'required',
        ]);

        $user = User::findOrFail($this->id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
        ]);
        if ($this->password) {
            $user->update([
                'password' => Hash::make($this->password),
            ]);
        }

        $user->syncRoles($this->role);

        $this->toast()->success('User berhasil diubah')->flash()->send();

        return to_route('user');
    }
};
