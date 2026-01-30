<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

new class extends Component
{
    use WireUiActions;

    // Profile Properties
    public $name = '';
    public $email = '';

    // Password Properties
    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->notification()->success(
            title: 'Berhasil',
            description: 'Profil berhasil diubah.'
        );
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        $this->notification()->success(
            title: 'Berhasil',
            description: 'Password berhasil diubah.'
        );
    }
};
