<?php

namespace App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Http\Responses\LoginResponse;
use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Throwable;

class MyLogin extends Login
{
    protected $remember = true;

    /**
     * @throws Throwable
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(setting('max_login_attempts', 5));
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();
        dd('Esa');
        if (! Auth::attempt([
            'username' => $data['username'],
            'password' => $data['password'],
        ], $this->remember)) {
            Notification::make()
                ->title(__('auth.failed'))
                ->danger()
                ->send();

            return null;
        }

        $user = Filament::auth()->user();

        if (
            ($user instanceof FilamentUser) &&
            (! $user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

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

        return app(LoginResponse::class);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->required()
                    ->label('Username')
                    ->autofocus()
                    ->extraInputAttributes(['tabindex' => 1]),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }
}
