<?php

namespace App\Http\Controllers\Backend;

use Image;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('browse-volunteer');
        $volunteers=Volunteer::latest()->paginate();
        return view('backend.pages.volunteer.index',compact('volunteers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('add-volunteer');
        return view('backend.pages.volunteer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-volunteer');
        $request->validate([
            'name'=>'required|string|max:255',
            'title'=>'required|string|max:255',
            'photo'=>'required|image|mimes:png,jpg,jpeg|max:10240'
        ]);
        $volunteer=Volunteer::create([
            'name' => $request->name,
            'title' => $request->title,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
        ]);
        $this->image_upload($request, $volunteer->id);
        return redirect()->route('admin.volunteer.index')->with('success', 'Volunteer created successfully.');
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
        Gate::authorize('edit-volunteer');
        $volunteer=Volunteer::findOrFail($id);
        return view('backend.pages.volunteer.edit',compact('volunteer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-volunteer');
        $request->validate([
            'name'=>'required|string|max:255',
            'title'=>'required|string|max:255',
            'photo'=>'sometimes|image|mimes:png,jpg,jpeg|max:10240'
        ]);
        $volunteer=Volunteer::findOrFail($id);
        $volunteer->update([
            'name' => $request->name,
            'title' => $request->title,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
        ]);
        $this->image_upload($request, $volunteer->id);
        return redirect()->route('admin.volunteer.index')->with('success', 'Volunteer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-volunteer');
        $volunteer=Volunteer::findOrFail($id);
        if ($volunteer->photo != 'default_volunteer.png') {
            //delete old photo
            $photo_location = 'public/uploads/volunteer/';
            $old_photo_location = $photo_location . $volunteer->photo;
            unlink(base_path($old_photo_location));
        }
        $volunteer->delete();
        return redirect()->route('admin.volunteer.index')->with('success', 'Volunteer deleted successfully.');
    }

    public function image_upload($request, $volunteer_id)
    {
        $volunteer = Volunteer::findOrFail($volunteer_id);
        if ($request->hasFile('photo')) {
            if ($volunteer->photo != 'default_volunteer.png') {
                //delete old photo
                $photo_location = 'public/uploads/volunteer/';
                $old_photo_location = $photo_location . $volunteer->photo;
                unlink(base_path($old_photo_location));
            }
            $photo_loation = 'public/uploads/volunteer/';
            $uploaded_photo = $request->file('photo');
            $new_photo_name = time() . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->save(base_path($new_photo_location));
            $check = $volunteer->update([
                'photo' => $new_photo_name,
            ]);
        }
    }
}
