<?php

namespace Modules\Merchant\Filament\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema; // ← correct import for Filament v5
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Modules\Merchant\Actions\CreateMerchant;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('business_name')
                    ->label('Business Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Phone Number')
                    ->required()
                    ->maxLength(255),

                $this->getEmailFormComponent()
                    ->unique(
                        table: 'users',
                        column: 'email',
                        ignorable: null,
                    ),

                $this->getPasswordFormComponent(),

                $this->getPasswordConfirmationFormComponent(),
            ])
            ->statePath('data');
    }

    protected function handleRegistration(array $data): Model
    {
        try {
            return app(CreateMerchant::class)->handle($data);
        } catch (ValidationException $e) {
            // Map the errors from 'password' to 'data.password'
            throw ValidationException::withMessages(
                collect($e->errors())
                    ->mapWithKeys(fn($messages, $key) => ["data.{$key}" => $messages])
                    ->all()
            );
        }
    }
}
