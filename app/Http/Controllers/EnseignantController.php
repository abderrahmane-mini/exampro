<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;

class EnseignantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:enseignant']); // Only allow 'enseignant' role
    }

    public function dashboard()
    {
        $user = Auth::user();
        $menu = $this->getMenu();
    
        // Modules assigned to the teacher
        $assignedModules = $user->modules()->with('exams')->get();
        $assignedModulesCount = $assignedModules->count();
    
        // Upcoming exams
        $upcomingExams = Exam::whereIn('module_id', $assignedModules->pluck('id'))
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();
        $upcomingExamsCount = $upcomingExams->count();
    
        // Total unique students in those modules (via group)
        $totalStudentsCount = \App\Models\User::where('user_type', 'etudiant')
            ->whereIn('group_id', function ($query) use ($assignedModules) {
                $query->select('group_id')
                    ->from('exams')
                    ->whereIn('module_id', $assignedModules->pluck('id'));
            })->distinct()->count();
    
        // Recent modules
        $recentModules = $assignedModules->sortByDesc('updated_at')->take(5);
    
        // For chart: module names + average grades
        $moduleNames = [];
        $moduleAverageGrades = [];
    
        foreach ($assignedModules as $module) {
            $moduleNames[] = $module->name;
            $average = $module->exams->flatMap->results->avg('grade');
            $moduleAverageGrades[] = round($average ?? 0, 2);
        }
    
        return view('enseignant.dashboard', compact(
            'user',
            'menu',
            'assignedModulesCount',
            'upcomingExamsCount',
            'totalStudentsCount',
            'recentModules',
            'moduleNames',
            'moduleAverageGrades'
        ));
    }
    

    public function getMenu()
    {
        return [
            'Dashboard' => [
                'icon' => 'dashboard',
                'route' => 'enseignant.dashboard',
            ],
            'User Profile' => [
                'icon' => 'user',
                'route' => 'profile.edit',
            ],
            'Gestion des Examens' => [
                'Planning' => [
                    'icon' => 'calendar',
                    'route' => 'enseignant.exams.schedule', // Shows assigned exams
                ],
                'Résultats' => [
                    'icon' => 'file-alt',
                    'submenu' => [
                        'Saisie des Notes' => [
                            'route' => 'enseignant.grades.select', // Fixed: now points to teacher's select route
                        ],
                        'Consultation des Notes' => [
                            'route' => 'enseignant.grades.view',
                        ],
                        'PV des Notes' => [
                            'route' => 'documents.index', // Optional: if listing PVs
                        ],
                    ],
                ],
            ],
        ];
    }
}
