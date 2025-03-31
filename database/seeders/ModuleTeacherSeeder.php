<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleTeacherSeeder extends Seeder
{
    public function run(): void
    {
        $modules = Module::all();
        
        foreach ($modules as $module) {
            // Get teachers from the same program as the module
            $programTeachers = User::where('user_type', 'enseignant')
                                 ->where('program_id', $module->program_id)
                                 ->get();
            
            if ($programTeachers->count() > 0) {
                // Assign 1-3 teachers to each module
                $assignTeacherCount = min(rand(1, 3), $programTeachers->count());
                $selectedTeachers = $programTeachers->random($assignTeacherCount);
                
                foreach ($selectedTeachers as $teacher) {
                    DB::table('module_teacher')->insert([
                        'module_id' => $module->id,
                        'user_id' => $teacher->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}