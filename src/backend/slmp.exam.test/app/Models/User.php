<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'id',
    'name',
    'username',
    'email',
    'phone',
    'website',
])]
class User extends Model
{
    public $incrementing = false;

    protected $keyType = 'int';

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'user_id');
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class, 'user_id');
    }

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class, 'user_id');
    }
}
