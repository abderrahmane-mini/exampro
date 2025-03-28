<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Program;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $program = Program::firstOrCreate(['name' => 'Informatique']);
        $group = Group::firstOrCreate([
            'name' => 'Groupe A',
            'program_id' => $program->id
        ]);

        User::create([
            'name' => 'Directeur Pédagogique',
            'email' => 'directeur@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'directeur_pedagogique',
        ]);

        User::create([
            'name' => 'Professeur A',
            'email' => 'enseignant@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'enseignant',
            'teacher_code' => 'ENS001',
        ]);

        User::create([
            'name' => 'Etudiant A',
            'email' => 'etudiant@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'etudiant',
            'student_code' => 'ETU001',
            'program_id' => $program->id,
            'group_id' => $group->id,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'administrateur',
        ]);
    }
}
