<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Order matters! Some seeders depend on others
        $this->call([
            ProgramSeeder::class,
            ModuleSeeder::class,
            RoomSeeder::class,
            GroupSeeder::class,
            UserSeeder::class,
            ModuleTeacherSeeder::class,
            ExamSeeder::class,
            ExamRoomSeeder::class,
            ExamTeacherSeeder::class,
            ExamResultSeeder::class,
            DocumentSeeder::class,
        ]);
    }
}