<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:directeur_pedagogique']);
    }

    public function index()
    {
        $teachers = User::where('user_type', 'enseignant')->with('modules')->get();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('teachers.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'modules'  => 'nullable|array',
        ]);

        $teacher = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'user_type' => 'enseignant',
        ]);

        if ($request->has('modules')) {
            $teacher->modules()->sync($request->modules);
        }

        return redirect()->route('teachers.index')->with('success', 'Enseignant créé avec succès.');
    }

    public function edit($id)
    {
        $teacher = User::where('user_type', 'enseignant')->findOrFail($id);
        $modules = Module::all();

        return view('teachers.edit', compact('teacher', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $teacher = User::where('user_type', 'enseignant')->findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $teacher->id,
            'modules' => 'nullable|array',
        ]);

        $teacher->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->has('modules')) {
            $teacher->modules()->sync($request->modules);
        }

        return redirect()->route('teachers.index')->with('success', 'Enseignant mis à jour.');
    }

    public function destroy($id)
    {
        $teacher = User::where('user_type', 'enseignant')->findOrFail($id);
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Enseignant supprimé.');
    }
}
