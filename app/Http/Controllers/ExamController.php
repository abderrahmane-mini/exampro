<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Group;
use App\Models\Module;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ✅ Show all exams (director)
    public function index()
    {
        $this->authorizeRole('directeur_pedagogique');

        $exams = Exam::with(['module', 'group', 'rooms'])->get();
        return view('exams.index', compact('exams'));
    }

    // ✅ Show exam planning form
    public function create()
    {
        $this->authorizeRole('directeur_pedagogique');

        $modules = Module::all();
        $groups = Group::all();
        $rooms = Room::all();

        return view('exams.create', compact('modules', 'groups', 'rooms'));
    }

    // ✅ Store exam plan (fixed validation & relationship)
    public function store(Request $request)
    {
        $this->authorizeRole('directeur_pedagogique');

        $request->validate([
            'module_id'     => 'required|exists:modules,id',
            'group_id'      => 'required|exists:groups,id',
            'room_ids'      => 'required|array|min:1',
            'room_ids.*'    => 'exists:rooms,id',
            'teacher_ids'   => 'required|array|min:1',
            'teacher_ids.*' => 'exists:users,id',
            'date'          => 'required|date',
            'time'          => 'required',
            'duration'      => 'nullable|integer|min:30|max:300',
            'academic_year' => 'required|string',
            'semester'      => 'required|in:S1,S2,S3,S4',
        ]);

        $startTime = $request->date . ' ' . $request->time;
        $durationInMinutes = $request->duration ?? 120;
        $endTime = now()->parse($startTime)->addMinutes($durationInMinutes);

        $exam = Exam::create([
            'module_id'     => $request->module_id,
            'group_id'      => $request->group_id,
            'start_time'    => $startTime,
            'end_time'      => $endTime,
            'academic_year' => $request->academic_year,
            'semester'      => $request->semester,
            'created_by'    => Auth::id(),
            'status'        => 'planned',
        ]);

        $exam->rooms()->sync($request->room_ids);
        $exam->teachers()->sync($request->teacher_ids); // ✅ Assign teachers


        return redirect()->route('exams.index')->with('success', 'Examen planifié avec succès.');
    }


    // ✅ Planning view (for students, teachers, and director)
    public function planning()
    {
        $user = Auth::user();

        if ($user->isEtudiant()) {
            $exams = Exam::where('group_id', $user->group_id)
            ->with('module.program', 'rooms') // 👈 Add 'module.program'
            ->get();
        
        } elseif ($user->isEnseignant()) {
            $moduleIds = $user->modules->pluck('id');
            $exams = Exam::whereIn('module_id', $moduleIds)
                ->with('module', 'group', 'rooms')
                ->get();
        } elseif ($user->isDirecteurPedagogique()) {
            $exams = Exam::with(['module', 'group', 'rooms'])->get();
        } else {
            abort(403);
        }

        return view('exams.schedule', compact('exams'));
    }

    // ✅ For teachers
    public function schedule()
    {
        $user = auth()->user();
    
        $exams = Exam::whereHas('teachers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->with(['module', 'group', 'rooms'])
            ->orderBy('start_time')
            ->get();
    
        return view('exams.schedule', compact('exams'));
    }
    

    // ✅ Show exam results for Directeur Pédagogique
    public function results()
    {
        $this->authorizeRole('directeur_pedagogique');

        $exams = Exam::with(['module', 'group', 'results.student'])->get();

        return view('exams.results', compact('exams'));
    }

    // ✅ Role check helper
    protected function authorizeRole($role)
    {
        if (Auth::user()->user_type !== $role) {
            abort(403);
        }
    }

    public function edit($id)
    {
        $this->authorizeRole('directeur_pedagogique');

        $exam = Exam::with(['rooms', 'teachers'])->findOrFail($id);
        $modules = Module::all();
        $groups = Group::all();
        $rooms = Room::all();
        $teachers = User::where('user_type', 'enseignant')->get();

        return view('exams.edit', compact('exam', 'modules', 'groups', 'rooms', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeRole('directeur_pedagogique');

        $request->validate([
            'module_id'     => 'required|exists:modules,id',
            'group_id'      => 'required|exists:groups,id',
            'room_ids'      => 'required|array|min:1',
            'room_ids.*'    => 'exists:rooms,id',
            'teacher_ids'   => 'required|array|min:1',
            'teacher_ids.*' => 'exists:users,id',
            'date'          => 'required|date',
            'time'          => 'required',
            'academic_year' => 'required|string',
            'semester'      => 'required|in:S1,S2,S3,S4',
        ]);

        $exam = Exam::findOrFail($id);

        $startTime = $request->date . ' ' . $request->time;
        $durationInMinutes = 120;
        $endTime = now()->parse($startTime)->addMinutes($durationInMinutes);

        $exam->update([
            'module_id'     => $request->module_id,
            'group_id'      => $request->group_id,
            'start_time'    => $startTime,
            'end_time'      => $endTime,
            'academic_year' => $request->academic_year,
            'semester'      => $request->semester,
        ]);

        $exam->rooms()->sync($request->room_ids);
        $exam->teachers()->sync($request->teacher_ids);

        return redirect()->route('exams.index')->with('success', 'Examen mis à jour avec succès.');
    }
}
