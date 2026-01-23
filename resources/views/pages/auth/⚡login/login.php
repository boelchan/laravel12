<?php

use Livewire\Component;

new class extends Component {
    public $email = '';

    public $password = '';

    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function authenticate()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', 'The provided credentials do not match our records.');

            return;
        }

        return redirect()->intended(route('dashboard'));
    }
};
