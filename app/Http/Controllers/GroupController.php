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
        // Eager load both 'program' and 'program.modules'
        $groups = Group::with('program.modules')->get();
        $programs = Program::all();
    
        return view('groups.index', compact('groups', 'programs'));
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
    
        // Get IDs of students already assigned to this group
        $assignedStudentIds = User::where('user_type', 'etudiant')
            ->where('group_id', $group->id)
            ->pluck('id')
            ->toArray();
    
        return view('groups.assign', compact('group', 'students', 'assignedStudentIds'));
    }
    

    // ✅ Save student assignments
    public function saveStudentAssignments(Request $request, $groupId)
    {
        $group = Group::findOrFail($groupId);
    
        $request->validate([
            'students' => 'nullable|array',
            'students.*' => 'exists:users,id'
        ]);
    
        // Assign checked students to the group
        User::where('user_type', 'etudiant')
            ->whereIn('id', $request->students ?? [])
            ->update(['group_id' => $group->id]);
    
        // Unassign others previously in this group but now unchecked
        User::where('user_type', 'etudiant')
            ->where('group_id', $group->id)
            ->whereNotIn('id', $request->students ?? [])
            ->update(['group_id' => null]);
    
        return redirect()->route('groups.index')->with('success', 'Affectation des étudiants mise à jour.');
    }
    
}
