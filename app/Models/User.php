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
        'user_type' // Add this line
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Role-specific methods
    public function isDirecteurPedagogique()
    {
        return $this->user_type === 'directeur_pedagogique';
    }

    public function isEnseignant()
    {
        return $this->user_type === 'enseignant';
    }

    public function isEtudiant()
    {
        return $this->user_type === 'etudiant';
    }

    public function isAdministrateur()
    {
        return $this->user_type === 'administrateur';
    }
}