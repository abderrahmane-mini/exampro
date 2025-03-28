<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:directeur_pedagogique']);
    }

    public function index()
    {
        $modules = Module::all();
        return view('modules.index', compact('modules'));
    }

    public function create()
    {
        return view('modules.create');
    }

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
    
    public function show(Module $module)
    {
        $this->authorize('view', $module); // Optional if you use policies
    
        return view('modules.show', compact('module'));
    }
    
    public function edit($id)
    {
        $module = Module::findOrFail($id);
        return view('modules.edit', compact('module'));
    }

    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);
    
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:modules,name,' . $module->id,
                'code' => 'required|string|max:50|unique:modules,code,' . $module->id,
            ]);
    
            $module->update([
                'name' => $validatedData['name'],
                'code' => $validatedData['code'],
            ]);
    
            return redirect()->route('modules.index')->with('success', 'Module mis à jour avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation errors
            Log::error('Module Update Validation Error', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
    
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Log any other unexpected errors
            Log::error('Module Update Error', [
                'message' => $e->getMessage(),
                'input' => $request->all()
            ]);
    
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour du module.');
        }
    }

    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return redirect()->route('modules.index')->with('success', 'Module supprimé.');
    }


    public function assignView()
{
    $teachers = User::where('user_type', 'enseignant')->with('modules')->get();
    $modules = Module::all();

    return view('modules.assign', compact('teachers', 'modules'));
}

public function saveAssignments(Request $request)
{
    foreach ($request->assignments ?? [] as $teacherId => $moduleIds) {
        $teacher = User::find($teacherId);
        if ($teacher && $teacher->user_type === 'enseignant') {
            $teacher->modules()->sync($moduleIds); // assumes pivot relation set
        }
    }

    return redirect()->route('modules.assign.view')->with('success', 'Modules assignés avec succès.');
}
}
