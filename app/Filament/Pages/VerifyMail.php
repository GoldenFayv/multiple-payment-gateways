<?php

namespace App\Filament\Pages;

use App\Actions\VerifyEmail;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class VerifyMail extends Page
{
    protected string $view = 'filament.pages.verify-mail';

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
                    ->length(6)
                    ->numeric(),
            ])
            ->statePath('data');
    }

    public function verify(VerifyEmail $verifyEmail): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        $verifyEmail->handle($user, $data);

        $this->redirect(filament()->getHomeUrl());
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
