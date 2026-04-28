<?php

namespace App\Filament\Pages;

use App\Actions\SendMail;
use App\Actions\VerifyEmail;
use App\Enums\CacheKey;
use App\Interface\User;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class VerifyMail extends Page
{
    protected string $view = 'filament.pages.verify-mail';
    protected static bool $shouldRegisterNavigation = false;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Verification Code')
                    ->required()
                    ->password()
                    ->length(6),
            ])
            ->statePath('data');
    }

    public function verify(VerifyEmail $verifyEmail): void
    {
        $data = $this->form->getState();
        $user = $this->getUser();

        $verifyEmail->handle($user, $data);

        $this->redirect(filament()->getHomeUrl());
    }

    public function resend(SendMail $sendMail): void
    {
        $user = $this->getUser();

        $code = generateCode();

        Cache::put(CacheKey::EMAIL_VERIFY->dynamicKey($user->getMorphClass(), $user->getKey()), $code, 300);

        $sendMail->handle($user->email, "Email Verification", 'mail.email_verification', ["otp" => $code, ...$user->toArray()]);

        Notification::make()
            ->title('Verification code resent')
            ->body('Please check your email for the new code.')
            ->success()
            ->send();
    }


    protected function getFormActions(): array
    {
        return [
            Action::make('verify')
                ->label('Verify Email')
                ->submit('verify'),

            Action::make('resend')
                ->label('Resend Code')
                ->color('gray')
                ->action('resend'),
        ];
    }

    private function getUser(): Model&User
    {
        return Auth::user();
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        // Ensure the user exists and check the email verification
        return $user && ! $user->email_verified_at;
    }

    // public function getMiddleware(): array
    // {
    //     return [
    //         'email.unverified',
    //     ];
    // }
}
