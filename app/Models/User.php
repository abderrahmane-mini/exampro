<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Module[] $modules
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExamResult[] $examResults
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read \App\Models\Group|null $group
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ✅ Role checkers
    public function isDirecteurPedagogique() { return $this->user_type === 'directeur_pedagogique'; }
    public function isEnseignant() { return $this->user_type === 'enseignant'; }
    public function isEtudiant() { return $this->user_type === 'etudiant'; }
    public function isAdministrateur() { return $this->user_type === 'administrateur'; }

    // ✅ Relationships

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_teacher', 'user_id', 'module_id');
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class, 'student_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
