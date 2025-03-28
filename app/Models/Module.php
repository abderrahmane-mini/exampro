<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'module_teacher', 'module_id', 'user_id')
                    ->where('user_type', 'enseignant');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
