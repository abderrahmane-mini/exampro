<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        Program::insert([
            ['name' => 'Informatique', 'code' => 'INF101', 'description' => 'Licence en informatique', 'duration_years' => 3],
            ['name' => 'Gestion', 'code' => 'GST201', 'description' => 'Licence en gestion', 'duration_years' => 3],
        ]);
    }
}
