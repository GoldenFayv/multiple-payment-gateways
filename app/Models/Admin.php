<?php

namespace App\Models;

use App\Interface\User;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;


#[Fillable(
    ['name', 'email', 'password', 'phone', 'email_verified_at', 'phone_verified_at', 'is_active', 'business_id']
)]
#[Hidden(['password', 'remember_token'])]
class Admin extends Authenticatable implements FilamentUser, HasName, User, MustVerifyEmail
{
    protected string $morphClass = 'admin';

    protected $casts = ['password' => 'hashed'];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        // return $panel->getId() === 'merchant' && $this->is_active;
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }
}
