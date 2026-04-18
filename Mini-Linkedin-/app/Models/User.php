<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject; // ← JWT

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable; // ← removed HasApiTokens (Sanctum, not needed)

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // ← make sure this is here
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // =================== JWT ===================
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // =================== Relations ===================
    public function profil()
    {
        return $this->hasOne(Profil::class);
    }

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }

    // =================== Role helpers ===================
    public function isAdmin(): bool     { return $this->role === 'admin'; }
    public function isRecruteur(): bool { return $this->role === 'recruteur'; }
    public function isCandidat(): bool  { return $this->role === 'candidat'; }
}