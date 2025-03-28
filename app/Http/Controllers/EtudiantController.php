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
                          ->whereDate('date', '>=', now()->toDateString())
                          ->orderBy('date')
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
}
