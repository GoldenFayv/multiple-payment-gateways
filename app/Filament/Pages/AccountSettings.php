<?php

namespace App\Filament\Pages;

use App\Actions\UpdateAdmin;
use App\Interface\User;
use App\Models\Admin;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Modules\Merchant\Actions\UpdateMerchant;
use UnitEnum;

class AccountSettings extends Page
{
    protected string $view = 'filament.pages.account-settings';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Account';
    protected static ?int $navigationSort = 2;
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    public string $email = '';
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(): void
    {
        $this->email = $this->getUser()->email;
    }

    public function emailForm(Schema $schema): Schema
    {
        $user = $this->getUser();
        $isAdmin = $user instanceof Admin;
        $table = $isAdmin ? 'admins' : 'merchants';

        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()->disabled($isAdmin) // ← read-only for admins
                    ->unique(
                        table: $table,
                        column: 'email',
                        ignorable: $this->getUser()
                    )
            ])
            ->statePath('');
    }

    public function passwordForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('current_password')
                    ->label('Current Password')
                    ->password()
                    ->required()
                // ->currentPassword()
                ,

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
            ->statePath('');
    }

    public function updateEmail(): void
    {
        $payload = $this->emailForm->getState();
            // $this->emailForm->validate();
        ;
        $this->updateUser($payload);

        Notification::make()
            ->title('Email updated. Please verify your new email.')
            ->warning()
            ->send();
        $route = $this->getUser() instanceof Admin
            ? 'filament.admin.pages.verify-mail'
            : 'filament.merchant.pages.verify-mail';
        redirect()->route($route);
    }

    public function updatePassword(): void
    {
        $payload = $this->passwordForm->getState();

        $this->updateUser($payload);

        $this->reset('current_password', 'password', 'password_confirmation');

        Notification::make()
            ->title('Password updated successfully.')
            ->success()
            ->send();
    }

    private function updateUser(array $data)
    {
        if ($this->getUser() instanceof Admin) {
            app(UpdateAdmin::class)->handle($this->getUser(), $data);
        } else {
            app(UpdateMerchant::class)->handle($this->getUser(), $data);
        }
    }

    private function getUser(): Model&User
    {
        return Auth::user();
    }

    protected function getForms(): array
    {
        return ['emailForm', 'passwordForm'];
    }
}
// TODO: Before authenticating, we have to check for the key type (test or live)