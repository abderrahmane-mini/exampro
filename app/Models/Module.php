<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    // ✅ Include program_id so it's mass assignable
    protected $fillable = ['name', 'code', 'program_id'];

    /**
     * ✅ Many-to-Many relationship with teachers
     */
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'module_teacher', 'module_id', 'user_id')
                    ->where('user_type', 'enseignant');
    }

    /**
     * ✅ One-to-Many relationship with exams
     */
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * ✅ Belongs to one program
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
