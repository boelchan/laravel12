<?php

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use WireUi\Traits\WireUiActions;

new class extends Component
{
    use WireUiActions;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role;

    public $roles;
    public $status = 'active';

    public function mount()
    {
        $this->roles = Role::pluck('name', 'id')->all();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'role' => 'required',
            'status' => 'required',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'status' => $this->status,
        ]);

        $user->assignRole($this->role);

        $this->notification()->success('User berhasil ditambahkan');

        return to_route('user');
    }
};
