<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Program;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $program = Program::first();
        Group::insert([
            ['name' => 'G1', 'program_id' => $program->id],
            ['name' => 'G2', 'program_id' => $program->id],
        ]);
    }
}
