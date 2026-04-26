<?php

namespace App\Filament\Pages;

use App\Enums\CacheKey;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Pages\BasePage;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class VerifyMail extends BasePage
{
    protected string $view = 'filament.pages.verify-mail';
    protected ?string $code = null;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Verification Code')
                    ->required()
                    ->length(6)
                    ->numeric(),
            ])
            ->statePath('data');
    }

    public function verify(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();

        $cacheKey = CacheKey::EMAIL_VERIFY->dynamicKey($user->getMorphClass(), $user->getKey());

        $code = Cache::get($cacheKey);

        if ($code !== $data['code']) {
            throw ValidationException::withMessages([
                'data.code' => 'Invalid or expired verification code.',
            ]);
        }

        Cache::forget($cacheKey);

        $user->update([
            'email_verified_at' => now(),
        ]);

        redirect()->to(filament()->getHomeUrl());
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('verify')
                ->label('Verify Email')
                ->submit('verify'),
        ];
    }
}
