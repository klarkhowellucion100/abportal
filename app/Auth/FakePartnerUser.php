<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

class FakePartnerUser implements Authenticatable
{
    protected $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['id'];
    }

    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value) {}

    public function getRememberTokenName()
    {
        return null;
    }

    // 🔧 Add this to satisfy custom interface (even if Laravel doesn’t use it)
    public function getAuthPasswordName()
    {
        return 'password';
    }
}
