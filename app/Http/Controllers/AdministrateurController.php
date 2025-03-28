<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        // ✅ KPIs for admin overview
        $totalUsers = User::count();
        $totalAdmins = User::where('user_type', 'administrateur')->count();
        $totalDirecteurs = User::where('user_type', 'directeur_pedagogique')->count();
        $totalEnseignants = User::where('user_type', 'enseignant')->count();
        $totalEtudiants = User::where('user_type', 'etudiant')->count();

        return view('administrateur.dashboard', compact(
            'user',
            'menu',
            'totalUsers',
            'totalAdmins',
            'totalDirecteurs',
            'totalEnseignants',
            'totalEtudiants'
        ));
    }

    public function getMenu()
    {
        return [
            'Dashboard' => [
                'icon' => 'dashboard',
                'route' => 'admin.dashboard'
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
