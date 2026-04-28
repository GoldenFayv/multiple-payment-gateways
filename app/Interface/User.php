<?php

namespace App\Interface;

use Illuminate\Contracts\Auth\Authenticatable;
// use Illuminate\Database\Eloquent\Model;

interface User extends Authenticatable
{
    public function getMorphClass();
    public function getKey();
    public function update(array $attributes = []);
}
