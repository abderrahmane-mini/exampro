<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\Group;
use App\Models\Module;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;

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

        return view('directeur_pedagogique.dashboard', [
            'user'           => $user,
            'menu'           => $menu,
            'totalPrograms'  => Program::count(),
            'totalGroups'    => Group::count(),
            'totalStudents'  => User::where('user_type', 'etudiant')->count(),
            'totalTeachers'  => User::where('user_type', 'enseignant')->count(),
            'totalModules'   => Module::count(),
            'totalExams'     => Exam::count(),
        ]);
    }

    public function getMenu()
    {
        return [
            'Dashboard' => [
                'icon' => 'fas fa-dashboard',
                'route' => 'dashboard'
            ],
            'User Profile' => [
                'icon' => 'fas fa-user',
                'route' => 'profile.edit'
            ],
            'Gestion des Filières et Groupes' => [
                'Filières' => [
                    'icon' => 'fas fa-graduation-cap',
                    'route' => 'programs.index'
                ],
                'Groupes' => [
                    'icon' => 'fas fa-users',
                    'route' => 'groups.index'
                ],
            ],
            'Gestion des Étudiants' => [
                'Étudiants' => [
                    'icon' => 'fas fa-user-graduate',
                    'route' => 'students.index'
                ]
            ],
            'Gestion des Modules et Enseignants' => [
                'Modules' => [
                    'icon' => 'fas fa-book',
                    'route' => 'modules.index'
                ],
                'Enseignants' => [
                    'icon' => 'fas fa-chalkboard-teacher',
                    'route' => 'teachers.index'
                ]
            ],
            'Gestion des Salles et Examens' => [
                'Salles' => [
                    'icon' => 'fas fa-building',
                    'route' => 'rooms.index'
                ],
                'Examens' => [
                    'icon' => 'fas fa-file-alt',
                    'submenu' => [
                        'Planning' => [
                            'route' => 'exams.planning'
                        ],
                        'Créer un Examen' => [
                            'route' => 'exams.create'
                        ],
                        'Résultats' => [
                            'route' => 'exams.results'
                        ]
                    ]
                ]
            ],
            'Documents officiels' => [
                'PV de notes' => [
                    'icon' => 'fas fa-file-pdf',
                    'route' => 'documents.index'
                ],
                'Relevés de notes' => [
                    'icon' => 'fas fa-file-alt',
                    'route' => 'grades.averages'
                ],
                'Attestations de réussite' => [
                    'icon' => 'fas fa-file',
                    'route' => 'documents.attestation.view'
                ]
            ]
        ];
    }
}
