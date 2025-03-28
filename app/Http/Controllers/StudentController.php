<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:directeur_pedagogique']);
    }

    // ✅ List all students
    public function index()
    {
        $students = User::where('user_type', 'etudiant')->with('group')->get();
        return view('students.index', compact('students'));
    }

    // ✅ Show create form
    public function create()
    {
        $groups = Group::all();
        return view('students.create', compact('groups'));
    }

    // ✅ Store new student
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6',
            'group_id'  => 'nullable|exists:groups,id',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'user_type' => 'etudiant',
            'group_id'  => $request->group_id,
        ]);

        return redirect()->route('students.index')->with('success', 'Étudiant créé avec succès.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $student = User::where('user_type', 'etudiant')->findOrFail($id);
        $groups = Group::all();

        return view('students.edit', compact('student', 'groups'));
    }

    // ✅ Update student
    public function update(Request $request, $id)
    {
        $student = User::where('user_type', 'etudiant')->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $student->id,
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $student->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'group_id' => $request->group_id,
        ]);
        

        return redirect()->route('students.index')->with('success', 'Étudiant mis à jour avec succès.');
    }

    // ✅ Delete student
    public function destroy($id)
    {
        $student = User::where('user_type', 'etudiant')->findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Étudiant supprimé avec succès.');
    }
}
