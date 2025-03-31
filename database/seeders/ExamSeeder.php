<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Group;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        $academicYears = ['2023-2024', '2024-2025'];
        $semesters = ['S1', 'S2', 'S3', 'S4'];
        $statuses = ['planned', 'ongoing', 'completed', 'canceled'];
        
        // Get an admin user for created_by field
        $admin = User::where('user_type', 'administrateur')->first();
        
        if (!$admin) {
            // Fallback to any user if no admin exists
            $admin = User::first();
        }
        
        // Get all groups
        $groups = Group::all();
        
        foreach ($groups as $group) {
            // Get modules for this group's program
            $modules = Module::where('program_id', $group->program_id)->get();
            
            foreach ($modules as $module) {
                // Create 1-3 exams per module per group
                $examCount = rand(1, 3);
                
                for ($i = 1; $i <= $examCount; $i++) {
                    $academicYear = $academicYears[array_rand($academicYears)];
                    $semester = $semesters[array_rand($semesters)];
                    
                    // Weight completed exams more heavily
                    $statusRand = rand(1, 10);
                    if ($statusRand <= 6) {
                        $status = 'completed';
                    } elseif ($statusRand <= 8) {
                        $status = 'planned';
                    } elseif ($statusRand <= 9) {
                        $status = 'ongoing';
                    } else {
                        $status = 'canceled';
                    }
                    
                    // Create a random exam date within the current year
                    $examDate = $this->getRandomExamDate();
                    $startTime = clone $examDate;
                    $endTime = clone $examDate;
                    $endTime->modify('+2 hours');
                    
                    Exam::create([
                        'group_id' => $group->id,
                        'module_id' => $module->id,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'academic_year' => $academicYear,
                        'semester' => $semester,
                        'status' => $status,
                        'created_by' => $admin->id,
                    ]);
                }
            }
        }
    }
    
    private function getRandomExamDate()
    {
        // Generate a random date within the last 6 months and next 6 months
        $startDate = strtotime('-6 months');
        $endDate = strtotime('+6 months');
        $randomTimestamp = rand($startDate, $endDate);
        $date = new \DateTime();
        $date->setTimestamp($randomTimestamp);
        
        // Set a reasonable time for exams (8 AM to 6 PM)
        $hour = rand(8, 18);
        $date->setTime($hour, 0, 0);
        
        return $date;
    }
}