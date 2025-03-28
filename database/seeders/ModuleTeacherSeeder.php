<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ModuleTeacherSeeder extends Seeder
{
    public function run()
    {
        $module = Module::first();
        $teacher = User::where('user_type', 'enseignant')->first();

        DB::table('module_teacher')->insert([
            'module_id' => $module->id,
            'user_id' => $teacher->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
