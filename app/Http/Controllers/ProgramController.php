<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:directeur_pedagogique']);
    }

    // ✅ List all filières
    public function index()
    {
        $programs = Program::all();
        return view('programs.index', compact('programs'));
    }

    // ✅ Show form to create a new filière
    public function create()
    {
        return view('programs.create');
    }

    // ✅ Save new filière
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:programs,name',
        ]);

        Program::create([
            'name' => $request->name,
        ]);

        return redirect()->route('programs.index')->with('success', 'Filière créée avec succès.');
    }

    // ✅ Show form to edit existing filière
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('programs.edit', compact('program'));
    }

    // ✅ Update existing filière
    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:programs,name,' . $program->id,
        ]);

        $program->update([
            'name' => $request->name,
        ]);

        return redirect()->route('programs.index')->with('success', 'Filière mise à jour avec succès.');
    }

    // ✅ Delete a filière
    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return redirect()->route('programs.index')->with('success', 'Filière supprimée avec succès.');
    }
}
