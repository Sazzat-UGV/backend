<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('browse-module');
        $modules = Module::latest('id')->get();
        return view('backend.pages.module.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-module');
        $request->validate([
            'module_name' => 'required|string|unique:modules,name',
        ]);
        Module::create([
            'name' => $request->module_name,
            'slug' => Str::slug($request->module_name),
            'status' => $request->status,
        ]);

        session()->flash('success', 'Module added successfully.');
        return response()->json(['success' => true]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-module');
        $module = Module::findOrFail($id);
        $request->validate([
            'module_name' => 'required|string|unique:modules,name,' . $module->id,
        ]);
        $module->update([
            'name' => $request->module_name,
            'slug' => Str::slug($request->module_name),
            'status' => $request->status,
        ]);
        session()->flash('success', 'Module updated successfully.');
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-module');
        $module = Module::findOrFail($id);
        $module->delete();
        return redirect()->back()->with('success', "Module deleted successfully.");
    }
}
