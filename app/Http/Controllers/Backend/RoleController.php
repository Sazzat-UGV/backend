<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('browse-role');
        $roles = Role::with(['permissions:id,name,slug']);
        if (Auth::user()->role->name != 'Developer') {
            $roles = $roles->where('id', '!=', 1)->where('status', 1);
        }
        $roles = $roles->latest('id')->select('id', 'name', 'status', 'note', 'is_deletable')->get();
        return view('backend.pages.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('add-role');
        $modules = Module::query();
        if (Auth::user()->role->id == 1) {
            $modules = $modules->with(['permissions:id,name,slug,module_id'])->select('id', 'name')->where('status', 1);
        } else {
            $modules = Module::where('status', 1)->whereHas('permissions', function ($query) {
                $query->where('status', 1);
            })->with(['permissions' => function ($query) {
                $query->where('status', 1);
            }])->select('id', 'name');
        }
        $modules = $modules->get();
        return view('backend.pages.role.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-role');
        $request->validate([
            'role_name' => 'required|unique:roles,name',
            'role_note' => 'nullable|string|max:255',
            'permissions' => 'required|array',
            'permissions.*' => 'integer',
        ]);
        $status = $request->has('status') && $request->status !== null ? $request->status : 1;

        Role::updateOrCreate([
            'name' => $request->role_name,
            'slug' => Str::slug($request->role_name),
        ],
            [
                'note' => $request->role_note,
                    'status' =>  $status,

            ]
        )->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.role.index')->with('success', 'Role added successfully.');
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
        Gate::authorize('edit-role');
        $role = Role::with('permissions')->find($id);
        $role_permissions = $role->permissions->pluck('id')->toArray();
        $modules = Module::query();
        if (Auth::user()->role->id == 1) {
            $modules = $modules->with(['permissions:id,name,slug,module_id'])->select('id', 'name')->where('status', 1);
        } else {
            $modules = Module::where('status', 1)->whereHas('permissions', function ($query) {
                $query->where('status', 1);
            })->with(['permissions' => function ($query) {
                $query->where('status', 1);
            }])->select('id', 'name');
        }
        $modules = $modules->get();
        return view('backend.pages.role.edit', compact('role', 'modules', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-role');
        $role = Role::find($id);
        $request->validate([
            'role_name' => 'required|unique:roles,name,' . $role->id,
            'role_note' => 'nullable|string|max:255',
            'permissions' => 'required|array',
            'permissions.*' => 'integer',
        ]);
            $status = $request->has('status') && $request->status !== null ? $request->status : 1;
        $role->update([
            'name' => $request->role_name,
            'slug' => Str::slug($request->role_name),
            'note' => $request->role_note,
            'status' => $status,
        ]);
        $role->permissions()->sync($request->input('permissions', []));
        return redirect()->route('admin.role.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(string $id)
    {
        Gate::authorize('delete-role');
        $role = Role::find($id);
        if ($role->user()->count() > 0) {
            return redirect()->route('admin.role.index')->with('success', "Role cann't be deleted because it contains user");
        }
        if ($role->is_deletable) {
            $role->delete();
            return redirect()->route('admin.role.index')->with('success', "Role deleted successfully");
        }
    }
}
