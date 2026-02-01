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
    public $password_for_email = '';

    public $tab = 'summary'; // summary, edit_name, edit_email, edit_password

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->reset(['current_password', 'password', 'password_confirmation', 'password_for_email']);
        $this->resetValidation();

        // Sync name/email from DB in case they were changed but not saved in other tabs
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateName()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Auth::user()->update([
            'name' => $this->name,
        ]);

        $this->notification()->success(
            title: 'Berhasil',
            description: 'Nama berhasil diubah.'
        );
    }

    public function updateEmail()
    {
        $user = Auth::user();

        $this->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password_for_email' => 'required|current_password',
        ], [
            'password_for_email.required' => 'Konfirmasi password diperlukan untuk merubah email.',
            'password_for_email.current_password' => 'Password yang Anda masukkan salah.',
        ]);

        // Check if email actually changed
        if ($user->email === $this->email) {
            $this->notification()->info(
                title: 'Info',
                description: 'Email yang dimasukkan sama dengan email yang terdaftar.'
            );
            return;
        }

        $user->email = $this->email;
        $user->email_verified_at = null;
        $user->save();

        // Reset password field
        $this->password_for_email = '';

        // Send verification email
        $user->sendEmailVerificationNotification();

        $this->notification()->warning(
            title: 'Email Diubah',
            description: 'Silahkan cek email baru Anda untuk verifikasi.'
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

    public function sendVerificationEmail()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->notification()->info(
                title: 'Info',
                description: 'Email Anda sudah terverifikasi.'
            );
            return;
        }

        $user->sendEmailVerificationNotification();

        $this->notification()->success(
            title: 'Berhasil',
            description: 'Link verifikasi telah dikirim ke email Anda.'
        );
    }
};
