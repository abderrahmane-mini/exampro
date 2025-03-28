<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:directeur_pedagogique']);
    }

    // ✅ List all groups
    public function index()
    {
        $programs = Program::all();
        return view('programs.index', compact('programs'));
    }

    // ✅ Show create form
    public function create()
    {
        $programs = Program::all();
        return view('groups.create', compact('programs'));
    }

    // ✅ Store new group
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:groups,name',
            'program_id' => 'required|exists:programs,id',
        ]);

        Group::create($request->only(['name', 'program_id']));

        return redirect()->route('groups.index')->with('success', 'Groupe créé avec succès.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $group = Group::findOrFail($id);
        $programs = Program::all();

        return view('groups.edit', compact('group', 'programs'));
    }

    // ✅ Update group
    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:groups,name,' . $group->id,
            'program_id' => 'required|exists:programs,id',
        ]);

        $group->update($request->only(['name', 'program_id']));

        return redirect()->route('groups.index')->with('success', 'Groupe mis à jour avec succès.');
    }

    // ✅ Delete group
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Groupe supprimé avec succès.');
    }

    // ✅ Assign students to a group
    public function assignStudents($groupId)
    {
        $group = Group::findOrFail($groupId);
        $students = User::where('user_type', 'etudiant')->get();

        return view('groups.assign', compact('group', 'students'));
    }

    // ✅ Save student assignments
    public function saveStudentAssignments(Request $request, $groupId)
    {
        $group = Group::findOrFail($groupId);

        $request->validate([
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:users,id'
        ]);

        // Update student group_id
        User::where('user_type', 'etudiant')->whereIn('id', $request->student_ids ?? [])->update([
            'group_id' => $group->id
        ]);

        // Optionally, remove students from this group who are not in the list
        User::where('user_type', 'etudiant')
            ->where('group_id', $group->id)
            ->whereNotIn('id', $request->student_ids ?? [])
            ->update(['group_id' => null]);

        return redirect()->route('groups.index')->with('success', 'Affectation des étudiants mise à jour.');
    }
}
