<?php

use Illuminate\Validation\ValidationException;
use Livewire\Component;

new class extends Component
{
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

        // Check if too many failed attempts (Fortify's rate limiting logic)
        if ($this->hasTooManyLoginAttempts()) {
            $this->fireLockoutEvent();
            $seconds = $this->limiter()->availableIn($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        // Attempt authentication (Fortify's AttemptToAuthenticate logic)
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Increment failed attempts
            $this->incrementLoginAttempts();

            // Fire failed authentication event
            event(new \Illuminate\Auth\Events\Failed(
                'web',
                null,
                ['email' => $this->email, 'password' => $this->password]
            ));

            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        // Regenerate session (Fortify's PrepareAuthenticatedSession logic)
        if (request()->hasSession()) {
            request()->session()->regenerate();
        }

        // Clear rate limiting attempts
        $this->clearLoginAttempts();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Determine if the user has too many failed login attempts.
     */
    protected function hasTooManyLoginAttempts(): bool
    {
        return $this->limiter()->tooManyAttempts($this->throttleKey(), 5);
    }

    /**
     * Increment the login attempts for the user.
     */
    protected function incrementLoginAttempts(): void
    {
        $this->limiter()->hit($this->throttleKey(), 60);
    }

    /**
     * Clear the login locks for the given user credentials.
     */
    protected function clearLoginAttempts(): void
    {
        $this->limiter()->clear($this->throttleKey());
    }

    /**
     * Fire an event when a lockout occurs.
     */
    protected function fireLockoutEvent(): void
    {
        event(new \Illuminate\Auth\Events\Lockout(request()));
    }

    /**
     * Get the rate limiter instance.
     */
    protected function limiter(): \Illuminate\Cache\RateLimiter
    {
        return app(\Illuminate\Cache\RateLimiter::class);
    }

    /**
     * Get the throttle key for the given request.
     */
    protected function throttleKey(): string
    {
        return \Illuminate\Support\Str::transliterate(
            \Illuminate\Support\Str::lower($this->email) . '|' . request()->ip()
        );
    }
};
