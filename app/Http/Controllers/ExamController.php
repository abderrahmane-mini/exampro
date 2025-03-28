<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Group;
use App\Models\Module;
use App\Models\Room;
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

    // ✅ Store exam plan
    public function store(Request $request)
    {
        $this->authorizeRole('directeur_pedagogique');
    
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'group_id'  => 'required|exists:groups,id',
            'rooms'     => 'required|array|min:1',
            'rooms.*'   => 'exists:rooms,id',
            'date'      => 'required|date',
            'time'      => 'required',
        ]);
    
        // Combine the date and time fields into a single datetime for `start_time`
        $startTime = $request->date . ' ' . $request->time;
        
        $exam = Exam::create([
            'module_id' => $request->module_id,
            'group_id'  => $request->group_id,
            'start_time' => $startTime, // Use start_time instead of date
        ]);
    
        $exam->rooms()->sync($request->rooms);
    
        return redirect()->route('exams.index')->with('success', 'Examen planifié.');
    }
    

    // ✅ Show planning view (for student/teacher)
    public function planning()
    {
        $user = Auth::user();
    
        if ($user->isEtudiant()) {
            $exams = Exam::where('group_id', $user->group_id)
                         ->with('module', 'rooms')
                         ->get();
        } elseif ($user->isEnseignant()) {
            $moduleIds = $user->modules->pluck('id');
            $exams = Exam::whereIn('module_id', $moduleIds)
                         ->with('module', 'group', 'rooms')
                         ->get();
        } else {
            abort(403);
        }
    
        return view('exams.planning', compact('exams'));
    }
    

    protected function authorizeRole($role)
    {
        if (Auth::user()->user_type !== $role) {
            abort(403);
        }
    }


    public function schedule()
    {
        $user = auth()->user();
        $assignedModules = $user->modules;
    
        $exams = Exam::whereIn('module_id', $assignedModules->pluck('id'))
                     ->with(['module', 'group', 'rooms']) // ✅ Eager load everything needed in the view
                     ->orderBy('start_time')
                     ->get();
    
                     return view('exams.schedule', compact('exams'));
    }
    
    

}
