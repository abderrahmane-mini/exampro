<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // If the user is not authenticated, redirect them to the login page
        if (!$request->user()) {
            return redirect('login');
        }

        // Check if the user has one of the allowed roles
        if (!in_array($request->user()->user_type, $roles)) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }

        // Dynamically set the menu based on the user role
        $menuMethod = 'getMenu' . ucfirst($request->user()->user_type);
        
        // Ensure the method exists in the user's controller and merge the menu
        if (method_exists($this, $menuMethod)) {
            $request->merge(['dynamic_menu' => $this->$menuMethod()]);
        } else {
            // If the method does not exist, you can either handle it as a fallback or log it
            return redirect()->route('dashboard')->with('error', 'Menu generation failed.');
        }

        return $next($request);
    }

    // Example method for generating menu for directeur_pedagogique
    protected function getMenuDirecteurPedagogique()
    {
        return (new \App\Http\Controllers\DirecteurPedagogiqueController())->getMenu();
    }

    // Method for generating menu for enseignant (teacher)
    protected function getMenuEnseignant()
    {
        return (new \App\Http\Controllers\EnseignantController())->getMenu();
    }

    // Method for generating menu for etudiant (student)
    protected function getMenuEtudiant()
    {
        return (new \App\Http\Controllers\EtudiantController())->getMenu();
    }

    // Method for generating menu for administrateur (administrator)
    protected function getMenuAdministrateur()
    {
        return (new \App\Http\Controllers\AdministrateurController())->getMenu();
    }
}
