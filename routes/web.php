<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdministrateurController,
    DirecteurPedagogiqueController,
    EnseignantController,
    EtudiantController,
    ExamController,
    GradeController,
    ProfileController,
    ProgramController,
    GroupController,
    StudentController,
    TeacherController,
    ModuleController,
    RoomController,
    DocumentController
};

// 🌐 Public landing
Route::get('/', fn () => view('welcome'));

// 🔐 Dashboard redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    return match ($user->user_type) {
        'directeur_pedagogique' => app(DirecteurPedagogiqueController::class)->dashboard(),
        'enseignant' => app(EnseignantController::class)->dashboard(),
        'etudiant' => app(EtudiantController::class)->dashboard(),
        'administrateur' => app(AdministrateurController::class)->dashboard(),
        default => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// 🔐 Profile management
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 📝 Grades (Teacher + Director)
Route::middleware(['auth'])->group(function () {
    Route::get('/grades/select', [GradeController::class, 'selectExam'])->name('grades.select');
    Route::get('/grades/enter/{exam}', [GradeController::class, 'enter'])->name('grades.enter');
    Route::post('/grades/enter/{exam}', [GradeController::class, 'store'])->name('grades.store');
    Route::get('/grades/view', [GradeController::class, 'view'])->name('grades.view');
    Route::get('/grades/averages', [GradeController::class, 'averages'])->name('grades.averages');
});

// 📄 Documents (Student / Director)
Route::middleware(['auth'])->group(function () {
    // Add the missing documents.index route
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/releve/{student}', [DocumentController::class, 'releve'])->name('documents.releve');
    Route::get('/documents/attestation/{student}', [DocumentController::class, 'attestation'])->name('documents.attestation');
    Route::get('/documents/pv/{exam}', [DocumentController::class, 'pv'])->name('documents.pv');
});

// 🎓 Directeur Pédagogique routes
Route::middleware(['auth', 'role:directeur_pedagogique'])->group(function () {
    Route::resource('programs', ProgramController::class)->except(['show']);
    Route::resource('groups', GroupController::class)->except(['show']);
    Route::get('/groups/{group}/assign', [GroupController::class, 'assign'])->name('groups.assign');
    Route::post('/groups/{group}/assign', [GroupController::class, 'storeAssignment'])->name('groups.assign.store');
    
    Route::resource('students', StudentController::class)->except(['show']);
    Route::resource('teachers', TeacherController::class)->except(['show']);
    Route::resource('modules', ModuleController::class)->except(['show']);
    Route::resource('rooms', RoomController::class)->except(['show']);
    Route::get('/rooms/{room}/exams', [RoomController::class, 'exams'])->name('rooms.exams');

    Route::resource('exams', ExamController::class)->except(['show']);
    Route::get('/exams/planning/view', [ExamController::class, 'planning'])->name('exams.planning');
    Route::get('/exams/results', [ExamController::class, 'results'])->name('exams.results');
});

// 👨‍🏫 Enseignant
Route::middleware(['auth', 'role:enseignant'])->group(function () {
    Route::get('/enseignant/dashboard', [EnseignantController::class, 'dashboard'])->name('enseignant.dashboard');
});

// 🎓 Étudiant
Route::middleware(['auth', 'role:etudiant'])->group(function () {
    Route::get('/etudiant/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
});

// 👤 Administrateur
Route::middleware(['auth', 'role:administrateur'])->group(function () {
    Route::get('/admin/dashboard', [AdministrateurController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users/create', [AdministrateurController::class, 'create'])->name('users.create');
    Route::get('/users/manage', [AdministrateurController::class, 'manage'])->name('users.manage');
    Route::get('/users/permissions', [AdministrateurController::class, 'permissions'])->name('users.permissions');
});

// Auth (Breeze)
require __DIR__.'/auth.php';
