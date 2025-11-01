<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('browse-user');
        $search = $request->search;
        $users = User::with('role:id,name')
            ->latest('id')
            ->whereNotIn('id', [1, 2])
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhereHas('role', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->select('id', 'role_id', 'profile_photo', 'first_name', 'last_name', 'email', 'phone', 'address', 'status', 'created_at')
            ->paginate(10);

        return view('backend.pages.user.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('add-user');
        $roles = Role::whereNot('id', 1)->where('status', 1)->latest('id')->get();
        return view('backend.pages.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-user');
        $request->validate([
            'role_id' => 'required|numeric',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'profile_photo' => 'sometimes|image|mimes:png,jpg,jpeg',
            'bio' => 'nullable|string|max:2000',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $user = User::create([
            'role_id' => $request->role_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'slug' => Str::slug($request->first_name . ' ' . $request->last_name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
            'date_of_birth' => $request->date_of_birth,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'city' => $request->city,
        ]);
        $this->image_upload($request, $user->id);
        return redirect()->route('admin.user.index')->with('success', 'User added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('read-user');
        $user = User::findOrFail($id);
        return view('backend.pages.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('edit-user');
        $roles = Role::whereNot('id', 1)->where('status', 1)->latest('id')->get();
        $user = User::findOrFail($id);
        return view('backend.pages.user.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-user');
        $user = User::findOrFail($id);
        $request->validate([
            'role_id' => 'required|numeric',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'profile_photo' => 'sometimes|image|mimes:png,jpg,jpeg',
            'bio' => 'nullable|string|max:2000',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);
        $user->update([
            'role_id' => $request->role_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'slug' => Str::slug($request->first_name . ' ' . $request->last_name),
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
            'date_of_birth' => $request->date_of_birth,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'city' => $request->city,
            'status' => $request->status,
        ]);
        $this->image_upload($request, $user->id);
        return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-user');
        $user = User::findOrFail($id);
        if ($user->profile_photo != 'default_profile.jpg') {
            //delete old photo
            $photo_location = 'public/uploads/profile_photo/';
            $old_photo_location = $photo_location . $user->profile_photo;
            unlink(base_path($old_photo_location));
        }
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
    }

    public function image_upload($request, $user_id)
    {
        $user = User::findOrFail($user_id);
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo != 'default_profile.jpg') {
                //delete old photo
                $photo_location = 'public/uploads/profile_photo/';
                $old_photo_location = $photo_location . $user->profile_photo;
                unlink(base_path($old_photo_location));
            }
            $photo_loation = 'public/uploads/profile_photo/';
            $uploaded_photo = $request->file('profile_photo');
            $new_photo_name = time() . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->resize(800, 800)->save(base_path($new_photo_location));
            $check = $user->update([
                'profile_photo' => $new_photo_name,
            ]);
        }
    }
}
