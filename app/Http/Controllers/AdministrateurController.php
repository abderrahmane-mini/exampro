<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministrateurController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:administrateur']);
    }
    public function show(User $user)
    {
        return view('administrateur.users.show', compact('user'));
    }
    
    public function dashboard()
    {
        $user = Auth::user();
        $menu = $this->getMenu();

        return view('administrateur.dashboard', [
            'user' => $user,
            'menu' => $menu,
            'totalUsersCount'   => User::count(),
            'adminCount'        => User::where('user_type', 'administrateur')->count(),
            'directeurCount'    => User::where('user_type', 'directeur_pedagogique')->count(),
            'enseignantCount'   => User::where('user_type', 'enseignant')->count(),
            'etudiantCount'     => User::where('user_type', 'etudiant')->count(),
            'recentUsers'       => User::latest()->take(5)->get(),
        ]);
    }

    public function getMenu()
    {
        return [
            'Dashboard' => [
                'icon' => 'fas fa-dashboard',
                'route' => 'admin.dashboard'
            ],
            'User Profile' => [
                'icon' => 'fas fa-user',
                'route' => 'profile.edit'
            ],
            'Gestion des Comptes Utilisateurs' => [
                'Comptes' => [
                    'icon' => 'fas fa-users',
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

    public function create()
    {
        return view('administrateur.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6|confirmed',
            'user_type'  => 'required|in:administrateur,directeur_pedagogique,enseignant,etudiant',
        ]);

        User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'user_type'  => $validated['user_type'],
        ]);

        return redirect()->route('users.manage')->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        return view('administrateur.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'user_type'  => 'required|in:administrateur,directeur_pedagogique,enseignant,etudiant',
        ]);

        $user->update($validated);

        return redirect()->route('users.manage')->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.manage')->with('success', 'Utilisateur supprimé.');
    }

    public function manage()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('administrateur.users.index', compact('users'));
    }

    public function permissions()
    {
        $user = Auth::user();
        $menu = $this->getMenu(); // <- this is important for the sidebar
    
        $users = User::all();
    
        return view('administrateur.users.permissions', compact('users', 'menu', 'user'));
    }
    
    
    public function updatePermission(Request $request, User $user)
    {
        $request->validate([
            'user_type' => 'required|in:administrateur,directeur_pedagogique,enseignant,etudiant',
        ]);
    
        $user->user_type = $request->user_type;
        $user->save();
    
        return redirect()->route('users.permissions')->with('success', 'Rôle mis à jour avec succès.');
    }
    
}
