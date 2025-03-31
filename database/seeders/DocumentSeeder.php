<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        // Get admins and directors
        $adminsAndDirectors = User::whereIn('user_type', ['administrateur', 'directeur_pedagogique'])->get();
        
        if ($adminsAndDirectors->count() == 0) {
            return; // Skip if no admins or directors
        }
        
        // Get completed exams
        $completedExams = Exam::where('status', 'completed')->get();
        
        foreach ($completedExams as $exam) {
            // Create PV for each completed exam
            Document::create([
                'type' => 'pv_notes',
                'file_path' => 'documents/pv/' . $exam->id . '_pv.pdf',
                'exam_id' => $exam->id,
                'student_id' => null,
                'generated_by' => $adminsAndDirectors->random()->id,
                'created_at' => $exam->end_date,
                'description' => 'Procès-verbal des notes de l\'examen ' . $exam->name,
            ]);
            
            // Create exam schedule document (30% chance)
            if (rand(1, 100) <= 30) {
                Document::create([
                    'type' => 'emploi_du_temps',
                    'file_path' => 'documents/schedules/' . $exam->id . '_schedule.pdf',
                    'exam_id' => $exam->id,
                    'student_id' => null,
                    'generated_by' => $adminsAndDirectors->random()->id,
                    'created_at' => $exam->start_date->subDays(7),
                    'description' => 'Emploi du temps de l\'examen ' . $exam->name,
                ]);
            }
            
            // Get students for this exam group
            $students = $exam->group->users()->where('user_type', 'etudiant')->get();
            
            // For a random set of students, create transcripts
            $selectedStudents = $students->random(min(5, $students->count()));
            
            foreach ($selectedStudents as $student) {
                // Create transcript (relevé de notes)
                Document::create([
                    'type' => 'releve_notes',
                    'file_path' => 'documents/releves/' . $student->id . '_' . $exam->id . '_releve.pdf',
                    'exam_id' => $exam->id,
                    'student_id' => $student->id,
                    'generated_by' => $adminsAndDirectors->random()->id,
                    'created_at' => $exam->end_date->addDays(3),
                    'description' => 'Relevé de notes pour ' . $student->name,
                ]);
                
                // Create success certificate (attestation) for some high-performing students
                $examResult = $student->examResults()->where('exam_id', $exam->id)->first();
                
                if ($examResult && $examResult->grade >= 16) {
                    Document::create([
                        'type' => 'attestation_reussite',
                        'file_path' => 'documents/attestations/' . $student->id . '_' . $exam->id . '_attestation.pdf',
                        'exam_id' => $exam->id,
                        'student_id' => $student->id,
                        'generated_by' => $adminsAndDirectors->random()->id,
                        'created_at' => $exam->end_date->addDays(7),
                        'description' => 'Attestation de réussite avec mention',
                    ]);
                }
                
                // Create exam authorization (20% chance)
                if (rand(1, 100) <= 20) {
                    Document::create([
                        'type' => 'autorisation_examen',
                        'file_path' => 'documents/autorisations/' . $student->id . '_' . $exam->id . '_autorisation.pdf',
                        'exam_id' => $exam->id,
                        'student_id' => $student->id,
                        'generated_by' => $adminsAndDirectors->random()->id,
                        'created_at' => $exam->start_date->subDays(14),
                        'description' => 'Autorisation de passage à l\'examen',
                    ]);
                }
            }
            
            // Create exam subject documents (50% chance)
            if (rand(1, 100) <= 50) {
                Document::create([
                    'type' => 'sujet_examen',
                    'file_path' => 'documents/sujets/' . $exam->id . '_sujet.pdf',
                    'exam_id' => $exam->id,
                    'student_id' => null,
                    'generated_by' => $adminsAndDirectors->random()->id,
                    'created_at' => $exam->start_date->subDays(1),
                    'description' => 'Sujet de l\'examen ' . $exam->name,
                ]);
                
                // Create answer key (30% chance if subject exists)
                if (rand(1, 100) <= 30) {
                    Document::create([
                        'type' => 'corrige_examen',
                        'file_path' => 'documents/corriges/' . $exam->id . '_corrige.pdf',
                        'exam_id' => $exam->id,
                        'student_id' => null,
                        'generated_by' => $adminsAndDirectors->random()->id,
                        'created_at' => $exam->end_date->addDays(1),
                        'description' => 'Corrigé de l\'examen ' . $exam->name,
                    ]);
                }
            }
        }
        
        // Create some general documents (10% chance per admin/director)
        foreach ($adminsAndDirectors as $user) {
            if (rand(1, 100) <= 10) {
                Document::create([
                    'type' => 'document_general',
                    'file_path' => 'documents/generaux/' . $user->id . '_' . now()->format('Ymd') . '.pdf',
                    'exam_id' => null,
                    'student_id' => null,
                    'generated_by' => $user->id,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'description' => 'Document administratif général',
                ]);
            }
        }
    }
}