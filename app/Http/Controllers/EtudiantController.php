<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        
        return view('etudiant.dashboard', compact('user', 'menu'));
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
            'Consultation des Examens' => [
                'Planning' => [
                    'icon' => 'calendar',
                    'route' => 'exams.schedule'
                ],
                'Résultats' => [
                    'icon' => 'file-alt',
                    'submenu' => [
                        'Voir mes Notes' => [
                            'route' => 'grades.view'
                        ],
                        'Télécharger Relevés' => [
                            'route' => 'grades.download'
                        ]
                    ]
                ]
            ]
        ];
    }
}