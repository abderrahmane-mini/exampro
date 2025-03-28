<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\Group;
use App\Models\Module;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DirecteurPedagogiqueController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:directeur_pedagogique']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $menu = $this->getMenu();

        // ✅ KPIs
        $totalPrograms = Program::count();
        $totalGroups = Group::count();
        $totalStudents = User::where('user_type', 'etudiant')->count();
        $totalTeachers = User::where('user_type', 'enseignant')->count();
        $totalModules = Module::count();
        $totalExams = Exam::count();

        return view('directeur_pedagogique.dashboard', compact(
            'user',
            'menu',
            'totalPrograms',
            'totalGroups',
            'totalStudents',
            'totalTeachers',
            'totalModules',
            'totalExams'
        ));
    }

    public function getMenu()
    {
        return [
            'Dashboard' => [
                'icon' => 'dashboard',
                'route' => 'directeur.dashboard'
            ],
            'User Profile' => [
                'icon' => 'user',
                'route' => 'profile.edit'
            ],
            'Gestion des Filières et Groupes' => [
                'Filières' => [
                    'icon' => 'graduation-cap',
                    'route' => 'programs.index'
                ],
                'Groupes' => [
                    'icon' => 'users',
                    'route' => 'groups.index'
                ]
            ],
            'Gestion des Étudiants' => [
                'Étudiants' => [
                    'icon' => 'user-graduate',
                    'route' => 'students.index'
                ]
            ],
            'Gestion des Modules et Enseignants' => [
                'Modules' => [
                    'icon' => 'book',
                    'route' => 'modules.index'
                ],
                'Enseignants' => [
                    'icon' => 'chalkboard-teacher',
                    'route' => 'teachers.index'
                ]
            ],
            'Gestion des Salles et Examens' => [
                'Salles' => [
                    'icon' => 'building',
                    'route' => 'rooms.index'
                ],
                'Examens' => [
                    'icon' => 'file-alt',
                    'submenu' => [
                        'Planning' => [
                            'route' => 'exams.planning'
                        ],
                        'Résultats' => [
                            'route' => 'exams.results'
                        ]
                    ]
                ]
            ],
            'Documents officiels' => [
                'PV / Relevés / Attestations' => [
                    'icon' => 'file-pdf',
                    'route' => 'documents.index'
                ]
            ]
        ];
    }
}
