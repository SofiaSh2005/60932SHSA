<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // ← ДОБАВИТЬ

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // ← ДОБАВИТЬ

    protected $fillable = [
        'name',
        'email',
        'telefon',
        'password',
        'role',
        'klient_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function klient()
    {
        return $this->belongsTo(Klient::class, 'klient_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
