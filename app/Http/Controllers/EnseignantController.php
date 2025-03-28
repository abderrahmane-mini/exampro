<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;

class EnseignantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:enseignant']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $menu = $this->getMenu();

        // ✅ Teacher dashboard data
        $assignedModules = $user->modules()->with('exams')->get();
        $upcomingExams = Exam::whereIn('module_id', $assignedModules->pluck('id'))
                             ->whereDate('date', '>=', now()->toDateString())
                             ->orderBy('date')
                             ->get();

        return view('enseignant.dashboard', compact(
            'user',
            'menu',
            'assignedModules',
            'upcomingExams'
        ));
    }

    public function getMenu()
    {
        return [
            'Dashboard' => [
                'icon' => 'dashboard',
                'route' => 'enseignant.dashboard'
            ],
            'User Profile' => [
                'icon' => 'user',
                'route' => 'profile.edit'
            ],
            'Gestion des Examens' => [
                'Planning' => [
                    'icon' => 'calendar',
                    'route' => 'enseignant.exams.schedule'
                ],
                'Résultats' => [
                    'icon' => 'file-alt',
                    'submenu' => [
                        'Saisie des Notes' => [
                            'route' => 'enseignant.grades.enter'
                        ],
                        'Consultation des Notes' => [
                            'route' => 'enseignant.grades.view'
                        ]
                    ]
                ]
            ]
        ];
    }
}
