<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            ProgramSeeder::class,
            ModuleSeeder::class,
            RoomSeeder::class,
            GroupSeeder::class,   // ✅ Run GroupSeeder before UserSeeder
            UserSeeder::class,    // ✅ Now $group won't be null
            ModuleTeacherSeeder::class,
        ]);
    }
    
    
}
