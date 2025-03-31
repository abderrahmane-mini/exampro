<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamTeacherSeeder extends Seeder
{
    public function run(): void
    {
        $exams = Exam::where('status', '!=', 'canceled')->get();
        
        foreach ($exams as $exam) {
            // First assign module teachers to their exams
            $moduleTeachers = $exam->module->teachers;
            
            if ($moduleTeachers->count() > 0) {
                foreach ($moduleTeachers as $teacher) {
                    DB::table('exam_teacher')->insert([
                        'exam_id' => $exam->id,
                        'teacher_id' => $teacher->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            
            // Then add 1-2 additional supervisors from other modules
            $additionalSupervisorCount = rand(1, 2);
            $otherTeachers = User::where('user_type', 'enseignant')
                                ->whereNotIn('id', $moduleTeachers->pluck('id')->toArray())
                                ->inRandomOrder()
                                ->take($additionalSupervisorCount)
                                ->get();
            
            foreach ($otherTeachers as $teacher) {
                DB::table('exam_teacher')->insert([
                    'exam_id' => $exam->id,
                    'teacher_id' => $teacher->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}