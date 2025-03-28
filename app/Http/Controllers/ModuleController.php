<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Allow only directeur to access everything except 'show'
        $this->middleware('role:directeur_pedagogique')->except(['show']);
    }

    // ✅ Directeur: list all modules
    public function index()
    {
        $modules = Module::with('program')->get(); // 👈 eager load the program
        return view('modules.index', compact('modules'));
    }
    

    // ✅ Directeur: show create form
    public function create()
    {
        return view('modules.create');
    }

    // ✅ Directeur: store new module
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:modules,name',
            'code' => 'required|string|max:50|unique:modules,code',
        ]);

        Module::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->route('modules.index')->with('success', 'Module créé avec succès.');
    }

    // ✅ Enseignant & Directeur: view single module
    public function show(Module $module)
    {
        $user = Auth::user();

        // Only show module if the teacher is assigned OR the user is directeur
        if ($user->isEnseignant() && !$user->modules->contains($module->id)) {
            abort(403);
        }

        return view('modules.show', compact('module'));
    }

    // ✅ Directeur: show edit form
    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $programs = \App\Models\Program::all(); // 👈 add this
        return view('modules.edit', compact('module', 'programs'));
    }
    

    // ✅ Directeur: update module
    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:modules,name,' . $module->id,
                'code' => 'required|string|max:50|unique:modules,code,' . $module->id,
                'program_id' => 'nullable|exists:programs,id',
            ]);
            
            $module->update($validatedData);
            

            return redirect()->route('modules.index')->with('success', 'Module mis à jour avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Module Update Validation Error', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Module Update Error', [
                'message' => $e->getMessage(),
                'input' => $request->all()
            ]);
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour du module.');
        }
    }

    // ✅ Directeur: delete module
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return redirect()->route('modules.index')->with('success', 'Module supprimé.');
    }

    // ✅ Directeur: form to assign modules to teachers
    public function assignView()
    {
        $teachers = User::where('user_type', 'enseignant')->with('modules')->get();
        $modules = Module::all();

        return view('modules.assign', compact('teachers', 'modules'));
    }

    // ✅ Directeur: save module-teacher assignments
    public function saveAssignments(Request $request)
    {
        foreach ($request->assignments ?? [] as $teacherId => $moduleIds) {
            $teacher = User::find($teacherId);
            if ($teacher && $teacher->user_type === 'enseignant') {
                $teacher->modules()->sync($moduleIds);
            }
        }

        return redirect()->route('modules.assign.view')->with('success', 'Modules assignés avec succès.');
    }
}
