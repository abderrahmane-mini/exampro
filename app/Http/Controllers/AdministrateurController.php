<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministrateurController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:administrateur']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $menu = $this->getMenu();
        
        return view('administrateur.dashboard', compact('user', 'menu'));
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
            'Gestion des Comptes Utilisateurs' => [
                'Comptes' => [
                    'icon' => 'users',
                    'submenu' => [
                        'Créer Compte' => [
                            'route' => 'users.create'
                        ],
                        'Gérer Comptes' => [
                            'route' => 'users.manage'
                        ],
                        'Permissions' => [
                            'route' => 'users.permissions'
                        ]
                    ]
                ]
            ]
        ];
    }
}