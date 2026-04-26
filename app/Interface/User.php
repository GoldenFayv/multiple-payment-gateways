<?php

namespace App\Interface;

use Illuminate\Contracts\Auth\Authenticatable;

interface User extends Authenticatable
{
    public function getMorphClass();
    public function getKey();
    public function update(array $attributes = []);
}
