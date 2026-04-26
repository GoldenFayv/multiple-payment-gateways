<?php

namespace Modules\Merchant\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

// use Modules\Merchant\Database\Factories\MerchantFactory;

#[Fillable(
    ['name', 'email', 'password', 'phone', 'email_verified_at', 'phone_verified_at', 'is_active', 'business_id']
)]
#[Hidden(['password', 'remember_token'])]
class Merchant extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory;

    protected string $morphClass = 'merchant';

    protected $casts = ['email_verified_at' => 'datetime', 'phone_verified_at' => 'datetime', 'password' => 'hashed'];

    public function activeBusiness(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }
    // protected static function newFactory(): MerchantFactory
    // {
    //     // return MerchantFactory::new();
    // }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        // return $panel->getId() === 'merchant' && $this->is_active;
    }

    public function getFilamentName(): string
    {
        return $this->email;
    }
}
