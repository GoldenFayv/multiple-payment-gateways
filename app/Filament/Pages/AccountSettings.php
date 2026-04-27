<?php

namespace App\Filament\Pages;

use App\Models\Admin;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Modules\Merchant\Actions\UpdateMerchant;
use UnitEnum;

class AccountSettings extends Page
{
    protected string $view = 'filament.pages.account-settings';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Account';
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    public string $email = '';
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(): void
    {
        $this->email = Auth::user()->email;
    }

    public function emailForm(Schema $schema): Schema
    {
        $user = Auth::user();

        $table = $user instanceof Admin ? 'admins' : 'merchants';
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->unique(
                        table: $table,
                        column: 'email',
                        ignorable: $user
                    )
            ])
            ->statePath('data');
    }

    public function passwordForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('current_password')
                    ->label('Current Password')
                    ->password()
                    ->required()
                    ->currentPassword(),

                TextInput::make('password')
                    ->label('New Password')
                    ->password()
                    ->required()
                    ->rule(Password::defaults())
                    ->confirmed(),

                TextInput::make('password_confirmation')
                    ->label('Confirm New Password')
                    ->password()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function updateEmail(): void
    {
        $data = $this->emailForm->getState();
        // $this->emailForm->validate();

        app(UpdateMerchant::class)->handle(Auth::user(), $data);
        Notification::make()
            ->title('Email updated. Please verify your new email.')
            ->warning()
            ->send();

        redirect()->route('filament.merchant.pages.verify-mail');
    }

    // public function updatePassword(): void
    // {
    //     $this->passwordForm->validate();

    //     auth()->user()->update([
    //         'password' => $this->password,
    //     ]);

    //     $this->reset('current_password', 'password', 'password_confirmation');

    //     Notification::make()
    //         ->title('Password updated successfully.')
    //         ->success()
    //         ->send();
    // }
}
// TODO: Before authenticating, we have to check for the key type (test or live)