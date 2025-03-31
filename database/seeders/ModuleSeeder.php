<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modulesByProgram = [
            'CS' => [
                ['name' => 'Introduction to Programming', 'code' => 'CS101'],
                ['name' => 'Data Structures and Algorithms', 'code' => 'CS201'],
                ['name' => 'Database Systems', 'code' => 'CS301'],
                ['name' => 'Web Development', 'code' => 'CS302'],
                ['name' => 'Operating Systems', 'code' => 'CS303'],
                ['name' => 'Computer Networks', 'code' => 'CS304'],
                ['name' => 'Software Engineering', 'code' => 'CS401'],
                ['name' => 'Artificial Intelligence', 'code' => 'CS402'],
            ],
            'BA' => [
                ['name' => 'Principles of Management', 'code' => 'BA101'],
                ['name' => 'Financial Accounting', 'code' => 'BA201'],
                ['name' => 'Marketing Fundamentals', 'code' => 'BA202'],
                ['name' => 'Business Law', 'code' => 'BA301'],
                ['name' => 'Human Resource Management', 'code' => 'BA302'],
                ['name' => 'Strategic Management', 'code' => 'BA401'],
            ],
            'EE' => [
                ['name' => 'Electric Circuits', 'code' => 'EE101'],
                ['name' => 'Digital Logic Design', 'code' => 'EE201'],
                ['name' => 'Electronics', 'code' => 'EE202'],
                ['name' => 'Signals and Systems', 'code' => 'EE301'],
                ['name' => 'Control Systems', 'code' => 'EE302'],
                ['name' => 'Microprocessors', 'code' => 'EE303'],
                ['name' => 'Power Systems', 'code' => 'EE401'],
                ['name' => 'Telecommunications', 'code' => 'EE402'],
            ],
            'MATH' => [
                ['name' => 'Calculus I', 'code' => 'MATH101'],
                ['name' => 'Linear Algebra', 'code' => 'MATH102'],
                ['name' => 'Discrete Mathematics', 'code' => 'MATH201'],
                ['name' => 'Calculus II', 'code' => 'MATH202'],
                ['name' => 'Probability and Statistics', 'code' => 'MATH301'],
                ['name' => 'Numerical Analysis', 'code' => 'MATH302'],
            ],
            'DS' => [
                ['name' => 'Python for Data Science', 'code' => 'DS101'],
                ['name' => 'Statistical Methods', 'code' => 'DS201'],
                ['name' => 'Machine Learning', 'code' => 'DS301'],
                ['name' => 'Big Data Technologies', 'code' => 'DS302'],
                ['name' => 'Data Visualization', 'code' => 'DS401'],
                ['name' => 'Deep Learning', 'code' => 'DS402'],
            ],
        ];

        foreach ($modulesByProgram as $programCode => $modules) {
            $program = Program::where('code', $programCode)->first();
            
            if ($program) {
                foreach ($modules as $moduleData) {
                    $moduleData['program_id'] = $program->id;
                    Module::create($moduleData);
                }
            }
        }
    }
}