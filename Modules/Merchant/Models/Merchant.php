<?php

namespace Modules\Merchant\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

// use Modules\Merchant\Database\Factories\MerchantFactory;

#[Fillable(['name', 'email', 'password', 'phone', 'email_verified_at', 'phone_verified_at'])]
#[Hidden(['password', 'remember_token'])]
class Merchant extends Authenticatable
{
    use HasFactory;

    protected $casts = ['email_verified_at' => 'datetime', 'phone_verified_at' => 'datetime', 'password' => 'hashed'];
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'email_verified_at',
        'phone_verified_at',
    ];

    public function apps(): HasMany
    {
        return $this->hasMany(MerchantApp::class);
    }
    // protected static function newFactory(): MerchantFactory
    // {
    //     // return MerchantFactory::new();
    // }
}
