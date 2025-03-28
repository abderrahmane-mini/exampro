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

        // ✅ Dashboard data for the student
        $groupExams = Exam::where('group_id', $user->group_id)
            ->whereDate('start_time', '>=', now()->toDateString())
            ->orderBy('start_time')
            ->get();


        $examResults = $user->examResults()->with('exam.module')->get();

        return view('etudiant.dashboard', compact(
            'user',
            'menu',
            'groupExams',
            'examResults'
        ));
    }

    public function getMenu()
    {
        return [
            'Dashboard' => [
                'icon' => 'dashboard',
                'route' => 'etudiant.dashboard'
            ],
            'User Profile' => [
                'icon' => 'user',
                'route' => 'profile.edit'
            ],
            'Consultation des Examens' => [
                'Planning' => [
                    'icon' => 'calendar',
                    'route' => 'etudiant.exams.schedule'
                ],
                'Résultats' => [
                    'icon' => 'file-alt',
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

        $examResults = $user->examResults()->with('exam.module')->get();

        return view('grades.view', compact('examResults'));

    }

public function downloadReleve()
{
    $student = Auth::user();

    // Redirect to the document controller's releve PDF logic if already handled there
    return redirect()->route('documents.releve', $student->id);
}

}
