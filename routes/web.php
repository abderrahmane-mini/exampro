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

// 🔐 Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 📄 Documents (Accessible by teachers & director)
Route::middleware(['auth'])->group(function () {
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/releve/{student}', [DocumentController::class, 'releve'])->name('documents.releve');
    Route::get('/documents/attestation/{student}', [DocumentController::class, 'attestation'])->name('documents.attestation');
    Route::get('/documents/pv/{exam}', [DocumentController::class, 'pv'])->name('documents.pv');
});

// 📝 Grades (Directeur only)
Route::middleware(['auth', 'role:directeur_pedagogique'])->group(function () {
    Route::get('/grades/averages', [GradeController::class, 'calculateAverages'])->name('grades.averages');
});

// 🎓 Directeur Pédagogique Routes
Route::middleware(['auth', 'role:directeur_pedagogique'])->group(function () {
    // Programs (Filières)
    Route::resource('programs', ProgramController::class)->except(['show']);
    // Groups
    Route::resource('groups', GroupController::class)->except(['show']);
    // Students
    Route::resource('students', StudentController::class)->except(['show']);
    // Teachers
    Route::resource('teachers', TeacherController::class)->except(['show']);
    // Modules
    Route::resource('modules', ModuleController::class)->except(['show']);
    // Rooms
    Route::resource('rooms', RoomController::class)->except(['show']);
    Route::get('/rooms/{room}/exams', [RoomController::class, 'exams'])->name('rooms.exams');
    // Exams CRUD
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
    // Planning & Results
    Route::get('/exams/planning/view', [ExamController::class, 'planning'])->name('exams.planning');
    Route::get('/exams/results', [ExamController::class, 'results'])->name('exams.results');
    Route::get('/documents/attestations', [DocumentController::class, 'attestations'])->name('documents.attestations');
    Route::get('/documents/attestations/{student?}', [DocumentController::class, 'showAttestation'])->name('documents.attestation.view');
    Route::get('/documents/attestation/download/{student}', [DocumentController::class, 'downloadAttestation'])->name('documents.attestation.download');

});

// 👨‍🏫 Enseignant Routes
Route::middleware(['auth', 'role:enseignant'])->group(function () {
    Route::get('/enseignant/dashboard', [EnseignantController::class, 'dashboard'])->name('enseignant.dashboard');
    Route::get('/enseignant/exams/schedule', [ExamController::class, 'schedule'])->name('enseignant.exams.schedule');

    Route::get('/enseignant/modules/{module}', [ModuleController::class, 'show'])->name('modules.details');

    Route::get('/enseignant/grades/select', [GradeController::class, 'selectExam'])->name('enseignant.grades.select');
    Route::get('/enseignant/grades/enter/{exam}', [GradeController::class, 'enter'])->name('enseignant.grades.enter');
    Route::post('/enseignant/grades/enter/{exam}', [GradeController::class, 'store'])->name('enseignant.grades.store');
    Route::get('/enseignant/grades/view', [GradeController::class, 'view'])->name('enseignant.grades.view');
});

// 🎓 Étudiant Routes
Route::middleware(['auth', 'role:etudiant'])->group(function () {
    Route::get('/etudiant/dashboard', [EtudiantController::class, 'dashboard'])->name('etudiant.dashboard');
    Route::get('/etudiant/exams/schedule', [EtudiantController::class, 'examSchedule'])->name('etudiant.exams.schedule');
    Route::get('/etudiant/grades/view', [EtudiantController::class, 'viewGrades'])->name('etudiant.grades.view');
    Route::get('/etudiant/releve/download', [EtudiantController::class, 'downloadReleve'])->name('etudiant.releve.download');
});

// 👤 Administrateur Routes
Route::middleware(['auth', 'role:administrateur'])->group(function () {
    Route::get('/admin/dashboard', [AdministrateurController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/users/create', [AdministrateurController::class, 'create'])->name('users.create');
    Route::post('/users/store', [AdministrateurController::class, 'store'])->name('users.store');

    Route::get('/users/manage', [AdministrateurController::class, 'manage'])->name('users.manage');
    Route::get('/users/{user}/edit', [AdministrateurController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdministrateurController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdministrateurController::class, 'destroy'])->name('users.delete');

    Route::get('/users/permissions', [AdministrateurController::class, 'permissions'])->name('users.permissions');
    Route::patch('/users/{user}/permissions', [AdministrateurController::class, 'updatePermission'])->name('users.permissions.update');
});

// Auth
require __DIR__.'/auth.php';
