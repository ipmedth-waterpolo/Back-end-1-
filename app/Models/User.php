<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public const ROLES = ['lid', 'gast', 'onderhoud', 'trainer', 'admin'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Check if the user has a specific role
    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }

        return $this->role === $roles;
    }

    // Check if the user is a specific role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOnderhoud()
    {
        return $this->role === 'onderhoud';
    }

    public function isTrainer()
    {
        return $this->role === 'trainer';
    }

    public function isLid()
    {
        return $this->role === 'lid';
    }

    public function isGast()
    {
        return $this->role === 'gast';
    }
}
