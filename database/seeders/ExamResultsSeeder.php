<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Database\Seeder;

class ExamResultSeeder extends Seeder
{
    public function run(): void
    {
        $completedExams = Exam::where('status', 'completed')->get();
        
        foreach ($completedExams as $exam) {
            // Get students in the exam's group
            $students = $exam->group->users()->where('user_type', 'etudiant')->get();
            
            foreach ($students as $student) {
                // Randomly determine if student was present (90% chance)
                $isPresent = (rand(1, 10) <= 9);
                
                // If student was present, give a grade
                if ($isPresent) {
                    // Generate a grade distribution that resembles reality:
                    // - Most students get 10-16
                    // - Fewer get very high or very low grades
                    $randVal = rand(1, 100);
                    
                    if ($randVal <= 5) {
                        // 5% chance of failing badly (0-6)
                        $grade = rand(0, 60) / 10;
                    } elseif ($randVal <= 15) {
                        // 10% chance of failing (6-10)
                        $grade = rand(60, 99) / 10;
                    } elseif ($randVal <= 75) {
                        // 60% chance of average (10-16)
                        $grade = rand(100, 160) / 10;
                    } elseif ($randVal <= 95) {
                        // 20% chance of good (16-18)
                        $grade = rand(160, 180) / 10;
                    } else {
                        // 5% chance of excellent (18-20)
                        $grade = rand(180, 200) / 10;
                    }
                    
                    $comments = null;
                    if ($grade < 10) {
                        $comments = $this->getRandomFailComment();
                    } elseif ($grade >= 18) {
                        $comments = $this->getRandomExcellentComment();
                    }
                } else {
                    // Absent student gets a 0
                    $grade = 0;
                    $comments = "Student absent";
                }
                
                ExamResult::create([
                    'exam_id' => $exam->id,
                    'student_id' => $student->id,
                    'grade' => $grade,
                    'is_present' => $isPresent,
                    'comments' => $comments,
                ]);
            }
        }
    }
    
    private function getRandomFailComment()
    {
        $comments = [
            "Needs significant improvement",
            "Did not demonstrate understanding of core concepts",
            "Please see me during office hours",
            "Consider retaking this module",
            "Must improve study habits",
        ];
        
        return $comments[array_rand($comments)];
    }
    
    private function getRandomExcellentComment()
    {
        $comments = [
            "Outstanding work!",
            "Exceptional understanding of the material",
            "One of the best performances in class",
            "Keep up the excellent work",
            "Shows tremendous potential in this subject",
        ];
        
        return $comments[array_rand($comments)];
    }
}