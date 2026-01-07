<?php

namespace App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Http\Responses\LoginResponse;
use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Throwable;

class MyLogin extends Login
{
    protected string $view = 'filament.pages.auth.login';

    protected $remember = true;

    /**
     * @throws Throwable
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            // adjust this setting call to match your app or hardcode a number
            $this->rateLimit(setting('max_login_attempts', 5));
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        $remember = $data['remember'] ?? $this->remember;

        // optional normalization; remove mb_strtolower() if you want case-sensitive usernames
        $username = isset($data['username']) ? mb_strtolower(trim($data['username'])) : null;

        if (! Auth::attempt([
            'username' => $username,
            'password' => $data['password'] ?? null,
        ], $remember)) {
            Notification::make()
                ->title(__('auth.failed'))
                ->danger()
                ->send();

            return null;
        }

        $user = Filament::auth()->user();

        // Optional: restrict access to the panel
        // if (($user instanceof \Filament\Models\Contracts\FilamentUser) && (! $user->canAccessPanel(Filament::getCurrentPanel()))) {
        //     Filament::auth()->logout();
        //     $this->throwFailureValidationException();
        // }

        session()->regenerate();

        // optional activity logging if you use the activity() helper
        if (function_exists('activity')) {
            activity('auth')
                ->by($user)
                ->event('login')
                ->withProperties([
                    'attributes' => [
                        'ip' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ],
                ])
                ->log('User logged in');
        }

        return app(LoginResponse::class);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('username')
                ->label('Username')
                ->required()
                ->autocomplete()
                ->autofocus()
                ->extraInputAttributes(['tabindex' => 1]),

            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent(),
        ]);
    }
}
