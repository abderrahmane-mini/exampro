<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:etudiant']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $menu = $this->getMenu();
    
        // ✅ Upcoming exams
        $groupExams = Exam::where('group_id', $user->group_id)
            ->whereDate('start_time', '>=', now()->toDateString())
            ->orderBy('start_time')
            ->get();
    
        // ✅ Student's exam results
        $examResults = $user->examResults()->with('exam.module')->get();
    
        // ✅ Calculate average grade
        $averageGrade = $examResults->count()
            ? round($examResults->avg('grade'), 2)
            : null;
    
        // ✅ Get unique module count
        $registeredModulesCount = $examResults->pluck('exam.module_id')->unique()->count();
    
        // ✅ Upcoming exams count
        $upcomingExamsCount = $groupExams->count();
    
        // ✅ Grades per module
        $moduleGrades = $examResults->map(function ($result) {
            return (object) [
                'module_name' => $result->exam->module->name ?? 'N/A',
                'module_code' => $result->exam->module->code ?? '',
                'grade' => $result->grade,
            ];
        });
    
        // ✅ Data for chart (Progression des Notes)
        $moduleNames = $moduleGrades->pluck('module_name');
        $moduleGradeProgress = $moduleGrades->pluck('grade');
    
        return view('etudiant.dashboard', compact(
            'user',
            'menu',
            'groupExams',
            'examResults',
            'averageGrade',
            'registeredModulesCount',
            'upcomingExamsCount',
            'moduleGrades',
            'moduleNames',
            'moduleGradeProgress'
        ));
    }
    

    public function getMenu()
    {
        return [
            'Dashboard' => [
                'icon' => 'fas fa-dashboard',
                'route' => 'etudiant.dashboard'
            ],
            'User Profile' => [
                'icon' => 'fas fa-user',
                'route' => 'profile.edit'
            ],
            'Consultation des Examens' => [
                'Planning' => [
                    'icon' => 'fas fa-calendar',
                    'route' => 'etudiant.exams.schedule'
                ],
                'Résultats' => [
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        'Voir mes Notes' => [
                            'route' => 'etudiant.grades.view'
                        ],
                        'Télécharger Relevé' => [
                            'route' => 'etudiant.releve.download'
                        ]
                    ]
                ]
            ]
        ];
    }


    public function examSchedule()
{
    $user = Auth::user();

    $exams = Exam::where('group_id', $user->group_id)
                 ->with(['module', 'group', 'rooms'])
                 ->orderBy('start_time')
                 ->get();

                 return view('exams.schedule', compact('exams'));

}

public function viewGrades()
{
    $user = Auth::user();

    $grades = $user->examResults()->with(['exam.module', 'exam.group'])->get();

    return view('grades.view', compact('grades'));
}


public function downloadReleve()
{
    $student = Auth::user();

    // Redirect to the document controller's releve PDF logic if already handled there
    return redirect()->route('documents.releve', $student->id);
}

}
