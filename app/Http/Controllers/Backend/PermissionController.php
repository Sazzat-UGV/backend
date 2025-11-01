<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('browse-permission');
        $permissions = Permission::with('module')
            ->whereHas('module', fn($query) => $query->where('status', 1))
            ->latest('id')
            ->get();
        $modules = Module::where('status', 1)->get();
        return view('backend.pages.permission.index', compact('permissions', 'modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-permission');
        $request->validate([
            'module_id' => 'required',
            'permission_name' => 'required|unique:permissions,name',
        ]);
        Permission::create([
            'module_id' => $request->module_id,
            'name' => $request->permission_name,
            'slug' => Str::slug($request->permission_name),
            'status' => $request->status,
        ]);

        session()->flash('success', 'Permission added successfully.');
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
        Gate::authorize('edit-permission');
        $permission = Permission::findOrFail($id);
        $request->validate([
            'module_id' => 'required',
            'permission_name' => 'required|unique:permissions,name,' . $permission->id,
        ]);
        $permission->update([
            'module_id' => $request->module_id,
            'name' => $request->permission_name,
            'slug' => Str::slug($request->permission_name),
            'status' => $request->status,
        ]);

        session()->flash('success', 'Permission updated successfully.');
        return response()->json(['success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-permission');
        $permission = Permission::findOrFail($id);
        $permission->delete();
        session()->flash('success', 'Permission deleted successfully');
        return back();
    }
}
