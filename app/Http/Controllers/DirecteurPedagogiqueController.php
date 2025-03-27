<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        
        return view('directeur_pedagogique.dashboard', compact('user', 'menu'));
    }

    public function getMenu()
    {
        return [
            'Dashboard' => [
                'icon' => 'dashboard',
                'route' => 'dashboard'
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
            ]
        ];
    }
}