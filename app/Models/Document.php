<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'file_path', 'student_id', 'exam_id', 'generated_by'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
