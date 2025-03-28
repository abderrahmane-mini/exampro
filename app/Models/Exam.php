<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'group_id', 'date', 'time'];

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
}
