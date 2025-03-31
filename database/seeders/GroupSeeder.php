<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Program;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        $programs = Program::all();
        
        foreach ($programs as $program) {
            // Create multiple groups per program, more for longer duration programs
            $groupCount = $program->duration_years * 2;
            
            for ($year = 1; $year <= $program->duration_years; $year++) {
                for ($group = 1; $group <= 2; $group++) {
                    Group::create([
                        'name' => $program->code . ' Y' . $year . '-G' . $group,
                        'program_id' => $program->id,
                    ]);
                }
            }
        }
    }
}