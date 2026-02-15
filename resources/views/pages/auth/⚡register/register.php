<?php

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\PasswordValidationRules;
use App\Enums\RolesEnum;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

new class extends Component
{
    use PasswordValidationRules, Interactions;

    public $name = '';
    public $nik = '';

    public $email = '';

    public $password = '';

    public $password_confirmation = '';

    /**
     * Get the validation rules.
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ];
    }

    /**
     * Register a new user using Fortify's logic.
     */
    public function cekregister()
    {
        // Validate input (Fortify's validation approach)
        $validated = $this->validate();

        try {
            // Create user using Fortify's CreateNewUser action
            $creator = app(CreateNewUser::class);
            $user = $creator->create([
                'name' => $this->name,
                'nik' => $this->nik,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ]);

            // Fire Registered event (Fortify's approach)
            event(new Registered($user));

            // default operator
            $user->assignRole(RolesEnum::PASIEN);

            // Login the user (Fortify's approach)
            Auth::login($user);

            // Regenerate session for security (Fortify's PrepareAuthenticatedSession logic)
            if (request()->hasSession()) {
                request()->session()->regenerate();
            }

            $this->toast()->success('Registration successful. Please verify your email.')->send();

            return redirect()->route('dashboard');
        } catch (ValidationException $e) {
            // Re-throw validation exceptions to display errors
            throw $e;
        } catch (\Exception $e) {
            // Handle any other exceptions
            $this->addError('email', 'An error occurred during registration. Please try again.');

            return;
        }
    }
};
