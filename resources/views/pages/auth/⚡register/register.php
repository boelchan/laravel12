<?php

use Livewire\Component;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    public $name = '';

    public $email = '';

    public $password = '';

    public $password_confirmation = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:8',
    ];

    public function cekregister()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);

        event(new Registered($user));

        // redirect to verification notice
        session()->flash('status', 'Registration successful. Please verify your email.');

        return redirect()->route('dashboard');
    }
};
