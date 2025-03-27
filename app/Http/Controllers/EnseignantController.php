<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        
        return view('enseignant.dashboard', compact('user', 'menu'));
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
            'Gestion des Examens' => [
                'Planning' => [
                    'icon' => 'calendar',
                    'route' => 'exams.schedule'
                ],
                'Résultats' => [
                    'icon' => 'file-alt',
                    'submenu' => [
                        'Saisie des Notes' => [
                            'route' => 'grades.enter'
                        ],
                        'Consultation des Notes' => [
                            'route' => 'grades.view'
                        ]
                    ]
                ]
            ]
        ];
    }
}