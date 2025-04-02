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

    public function dashboard()
    {
        $user = Auth::user();
        $menu = $this->getMenu();

        return view('administrateur.dashboard', [
            'user' => $user,
            'menu' => $menu,
            'totalUsersCount' => User::count(),
            'adminCount' => User::where('user_type', 'administrateur')->count(),
            'directeurCount' => User::where('user_type', 'directeur_pedagogique')->count(),
            'enseignantCount' => User::where('user_type', 'enseignant')->count(),
            'etudiantCount' => User::where('user_type', 'etudiant')->count(),
            'recentUsers' => User::latest()->take(5)->get(),
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
                        'Créer Compte' => ['route' => 'users.create'],
                        'Gérer Comptes' => ['route' => 'users.manage'],
                        'Permissions' => ['route' => 'users.permissions']
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'user_type' => 'required|in:administrateur,directeur_pedagogique,enseignant,etudiant',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
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
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'user_type' => 'required|in:administrateur,directeur_pedagogique,enseignant,etudiant',
            'password'  => 'nullable|string|min:6|confirmed',
        ]);
    
        // Mise à jour des informations principales
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->user_type = $validated['user_type'];
    
        // Mise à jour du mot de passe uniquement s’il est rempli
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
    
        $user->save();
    
        return redirect()->route('users.manage')->with('success', 'Utilisateur mis à jour avec succès.');
    }
    

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.manage')->with('success', 'Utilisateur supprimé.');
    }

    public function manage(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('user_type', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        $menu = $this->getMenu();
        $user = Auth::user();

        return view('administrateur.users.index', compact('users', 'menu', 'user'));
    }

    public function permissions(Request $request)
    {
        $user = Auth::user();
        $menu = $this->getMenu();

        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('user_type', $request->query('role'));
        }

        $sortColumn = $request->query('sort', 'name');
        $sortDirection = $request->query('direction', 'asc');

        if (in_array($sortColumn, ['name', 'email', 'user_type', 'created_at'])) {
            $query->orderBy($sortColumn, $sortDirection);
        }

        $perPage = in_array($request->query('per_page'), [10, 25, 50, 100]) ? $request->query('per_page') : 10;

        $users = $query->paginate($perPage);

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

    public function show(User $user)
    {
        return view('administrateur.users.show', compact('user'));
    }
}
