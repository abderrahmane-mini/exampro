<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'administrateur',
            'phone' => '123456789',
            'birth_date' => '1985-01-01',
            'address' => '123 Admin Street',
            'gender' => 'M',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Create Directeur Pedagogique
        User::create([
            'name' => 'Director of Education',
            'email' => 'director@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'directeur_pedagogique',
            'phone' => '123456780',
            'birth_date' => '1975-01-01',
            'address' => '123 Director Avenue',
            'gender' => 'F',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Create Teachers (5-10 per program)
        $programs = Program::all();
        $teacherCounter = 1;
        
        foreach ($programs as $program) {
            $teacherCount = rand(5, 10);
            
            for ($i = 1; $i <= $teacherCount; $i++) {
                $gender = rand(0, 1) ? 'M' : 'F';
                $firstName = $this->getRandomFirstName($gender);
                $lastName = $this->getRandomLastName();
                
                User::create([
                    'name' => $firstName . ' ' . $lastName,
                    'email' => 'teacher' . $teacherCounter . '@example.com',
                    'password' => Hash::make('password'),
                    'user_type' => 'enseignant',
                    'phone' => '7' . str_pad($teacherCounter, 8, '0', STR_PAD_LEFT),
                    'birth_date' => $this->getRandomBirthDate(30, 65),
                    'address' => rand(1, 999) . ' ' . $this->getRandomStreetName(),
                    'gender' => $gender,
                    'teacher_code' => 'T' . str_pad($teacherCounter, 5, '0', STR_PAD_LEFT),
                    'email_verified_at' => now(),
                    'program_id' => $program->id,
                    'remember_token' => Str::random(10),
                ]);
                
                $teacherCounter++;
            }
        }

        // Create Students (20-30 per group)
        $groups = Group::all();
        $studentCounter = 1;
        
        foreach ($groups as $group) {
            $studentCount = rand(20, 30);
            
            for ($i = 1; $i <= $studentCount; $i++) {
                $gender = rand(0, 1) ? 'M' : 'F';
                $firstName = $this->getRandomFirstName($gender);
                $lastName = $this->getRandomLastName();
                
                User::create([
                    'name' => $firstName . ' ' . $lastName,
                    'email' => 'student' . $studentCounter . '@example.com',
                    'password' => Hash::make('password'),
                    'user_type' => 'etudiant',
                    'phone' => '6' . str_pad($studentCounter, 8, '0', STR_PAD_LEFT),
                    'birth_date' => $this->getRandomBirthDate(18, 30),
                    'address' => rand(1, 999) . ' ' . $this->getRandomStreetName(),
                    'gender' => $gender,
                    'student_code' => 'S' . str_pad($studentCounter, 6, '0', STR_PAD_LEFT),
                    'email_verified_at' => now(),
                    'program_id' => $group->program_id,
                    'group_id' => $group->id,
                    'remember_token' => Str::random(10),
                ]);
                
                $studentCounter++;
            }
        }
    }

    private function getRandomFirstName($gender)
    {
        $maleNames = ['John', 'Michael', 'David', 'James', 'Robert', 'William', 'Ali', 'Mohammed', 'Omar', 
                      'Hassan', 'Ahmed', 'Youssef', 'Karim', 'Hamza', 'Rachid', 'Mehdi', 'Nasser', 'Samir'];
        
        $femaleNames = ['Mary', 'Jennifer', 'Linda', 'Patricia', 'Elizabeth', 'Fatima', 'Aisha', 'Laila', 
                        'Nora', 'Amina', 'Leila', 'Yasmine', 'Salma', 'Nadia', 'Sara', 'Hind', 'Dounia'];
        
        $names = $gender == 'M' ? $maleNames : $femaleNames;
        return $names[array_rand($names)];
    }

    private function getRandomLastName()
    {
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia', 
                      'Alaoui', 'Benani', 'Tazi', 'El Fassi', 'Bennani', 'El Amrani', 'Tahiri', 
                      'Idrissi', 'Benjelloun', 'Belmkadem', 'Cherkaoui', 'Berrada', 'Sahraoui', 'Mansouri'];
        
        return $lastNames[array_rand($lastNames)];
    }

    private function getRandomStreetName()
    {
        $streets = ['Main Street', 'Park Avenue', 'Oak Street', 'Cedar Road', 'Elm Boulevard', 
                   'Boulevard Mohammed V', 'Avenue Hassan II', 'Rue Ibn Batouta', 'Avenue Moulay Ismail', 
                   'Rue Allal Ben Abdellah', 'Boulevard Anfa', 'Avenue des FAR'];
        
        return $streets[array_rand($streets)];
    }

    private function getRandomBirthDate($minAge, $maxAge)
    {
        $minTimestamp = strtotime("-$maxAge years");
        $maxTimestamp = strtotime("-$minAge years");
        $randomTimestamp = rand($minTimestamp, $maxTimestamp);
        
        return date('Y-m-d', $randomTimestamp);
    }
}