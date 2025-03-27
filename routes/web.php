<?php


use App\Http\Controllers\DirecteurPedagogiqueController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\AdministrateurController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dynamic Dashboard Routing Based on User Type
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    switch ($user->user_type) {
        case 'directeur_pedagogique':
            return (new DirecteurPedagogiqueController())->dashboard();
        case 'enseignant':
            return (new EnseignantController())->dashboard();
        case 'etudiant':
            return (new EtudiantController())->dashboard();
        case 'administrateur':
            return (new AdministrateurController())->dashboard();
        default:
            return view('dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (Editing, Updating, and Deleting Profile)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Exam Routes (Accessible to Multiple Roles)
Route::middleware('auth')->group(function () {
    Route::get('/exams/schedule', [ExamController::class, 'schedule'])->name('exams.schedule');
    Route::get('/exams/results', [ExamController::class, 'results'])->name('exams.results');
});

// Grade Routes
Route::middleware('auth')->group(function () {
    Route::get('/grades/enter', [GradeController::class, 'enter'])->name('grades.enter');
    Route::get('/grades/view', [GradeController::class, 'view'])->name('grades.view');
    Route::get('/grades/download', [GradeController::class, 'download'])->name('grades.download');
});

// Role-Specific Routes
Route::middleware(['auth', 'role:directeur_pedagogique'])->group(function () {
    Route::get('/directeur/dashboard', [DirecteurPedagogiqueController::class, 'dashboard'])->name('directeur.dashboard');
    Route::get('/programs', [DirecteurPedagogiqueController::class, 'programs'])->name('programs.index');
    Route::get('/groups', [DirecteurPedagogiqueController::class, 'groups'])->name('groups.index');
    Route::get('/students', [DirecteurPedagogiqueController::class, 'students'])->name('students.index');
    Route::get('/modules', [DirecteurPedagogiqueController::class, 'modules'])->name('modules.index');
    Route::get('/teachers', [DirecteurPedagogiqueController::class, 'teachers'])->name('teachers.index');
    Route::get('/rooms', [DirecteurPedagogiqueController::class, 'rooms'])->name('rooms.index');

    Route::prefix('exams')->group(function () {
        Route::get('/planning', [ExamController::class, 'planning'])->name('exams.planning');
        Route::get('/results', [ExamController::class, 'results'])->name('exams.results');
    });
});

Route::middleware(['auth', 'role:enseignant'])->group(function () {
    Route::get('/enseignant/dashboard', [EnseignantController::class, 'dashboard'])->name('enseignant.dashboard');
});

Route::middleware(['auth', 'role:etudiant'])->group(function () {
    Route::get('/etudiant/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
});

Route::middleware(['auth', 'role:administrateur'])->group(function () {
    Route::get('/admin/dashboard', [AdministrateurController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users/create', [AdministrateurController::class, 'create'])->name('users.create');
    Route::get('/users/manage', [AdministrateurController::class, 'manage'])->name('users.manage');
    Route::get('/users/permissions', [AdministrateurController::class, 'permissions'])->name('users.permissions');
});

// Authentication Routes (Breeze)
require __DIR__.'/auth.php';
