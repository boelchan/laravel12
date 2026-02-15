<?php

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use TallStackUi\Traits\Interactions;

new class extends Component
{
    use Interactions;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $nik;
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
            'nik' => 'nullable|string|size:16|unique:users,nik',
            'role' => 'required',
            'status' => 'required',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'nik' => $this->nik,
            'status' => $this->status,
        ]);

        $user->assignRole($this->role);

        $this->toast()->success('User berhasil ditambahkan')->send();

        return to_route('user');
    }
};
