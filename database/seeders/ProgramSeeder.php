<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Computer Science',
                'code' => 'CS',
                'description' => 'Bachelor degree in Computer Science focusing on software development and IT infrastructure.',
                'duration_years' => 3,
            ],
            [
                'name' => 'Business Administration',
                'code' => 'BA',
                'description' => 'Business Administration degree with focus on management and leadership.',
                'duration_years' => 3,
            ],
            [
                'name' => 'Electrical Engineering',
                'code' => 'EE',
                'description' => 'Engineering program focused on electrical systems and electronics.',
                'duration_years' => 4,
            ],
            [
                'name' => 'Mathematics',
                'code' => 'MATH',
                'description' => 'Advanced mathematics program with theoretical and applied focuses.',
                'duration_years' => 3,
            ],
            [
                'name' => 'Data Science',
                'code' => 'DS',
                'description' => 'Advanced program focusing on data analysis, machine learning, and AI.',
                'duration_years' => 2,
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}