<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    // Update the fillable array to include both name and code
    protected $fillable = ['name', 'code'];

    // Relationship to teachers (Many-to-Many)
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'module_teacher', 'module_id', 'user_id')
                    ->where('user_type', 'enseignant');  // Ensuring the user is of type 'enseignant'
    }

    // Relationship to exams (One-to-Many)
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}