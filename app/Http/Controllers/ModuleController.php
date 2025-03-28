<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

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
        ]);

        Module::create($request->only('name'));

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

        $request->validate([
            'name' => 'required|string|max:255|unique:modules,name,' . $module->id,
        ]);

        $module->update($request->only('name'));

        return redirect()->route('modules.index')->with('success', 'Module mis à jour.');
    }

    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return redirect()->route('modules.index')->with('success', 'Module supprimé.');
    }
}
