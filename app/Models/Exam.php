<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'group_id',
        'start_time',
        'end_time',
        'academic_year',
        'semester',
        'status',
        'created_by',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'exam_room');
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'exam_teacher', 'exam_id', 'teacher_id');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_teacher');
    }
}
