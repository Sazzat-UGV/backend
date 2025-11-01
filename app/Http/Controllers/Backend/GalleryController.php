<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Image;

class GalleryController extends Controller
{
    public function index()
    {
        Gate::authorize('browse-gallery');
        $galleries = gallery::latest('id')->paginate(10);
        return view('backend.pages.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('add-gallery');
        return view('backend.pages.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-gallery');
        $request->validate([
            'title' => 'required|string|max:255',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:10240',
        ]);
        $gallery = gallery::create([
            'title' => $request->title,
        ]);
        $this->image_upload($request, $gallery->id);
        return redirect()->route('admin.gallery.index')->with('success', 'Photo created successfully.');

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
        Gate::authorize('edit-gallery');
        $gallery = gallery::findOrFail($id);
        return view('backend.pages.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-gallery');
        $request->validate([
            'title' => 'required|string|max:255',
            'photo' => 'sometimes|image|mimes:png,jpg,jpeg|max:10240',
        ]);
        $gallery = gallery::findOrFail($id);
        $gallery->update([
            'title' => $request->title,
        ]);
        $this->image_upload($request, $gallery->id);
        return redirect()->route('admin.gallery.index')->with('success', 'Photo updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-gallery');
        $gallery = gallery::findOrFail($id);
        if ($gallery->photo != 'default_photo.png') {
            //delete old photo
            $photo_location = 'public/uploads/gallery/';
            $old_photo_location = $photo_location . $gallery->photo;
            unlink(base_path($old_photo_location));
        }
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Photo deleted successfully.');
    }

    public function image_upload($request, $gallery_id)
    {
        $gallery = gallery::findOrFail($gallery_id);
        if ($request->hasFile('photo')) {
            if ($gallery->photo != 'default_photo.png') {
                //delete old photo
                $photo_location = 'public/uploads/gallery/';
                $old_photo_location = $photo_location . $gallery->photo;
                unlink(base_path($old_photo_location));
            }
            $photo_loation = 'public/uploads/gallery/';
            $uploaded_photo = $request->file('photo');
            $new_photo_name = time() . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->save(base_path($new_photo_location));
            $check = $gallery->update([
                'photo' => $new_photo_name,
            ]);
        }
    }
}
