<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run()
    {
        Module::insert([
            ['name' => 'Programmation Web', 'code' => 'MOD101'],
            ['name' => 'Comptabilité', 'code' => 'MOD202'],
        ]);
    }
}
