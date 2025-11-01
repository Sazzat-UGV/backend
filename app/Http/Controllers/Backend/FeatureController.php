<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Image;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('browse-feature');
        $features = Feature::latest('id')->paginate();
        return view('backend.pages.feature.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('add-feature');
        return view('backend.pages.feature.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-feature');
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string|max:2000',
            'icon' => 'required|image|mimes:png,jpg',
        ]);
        $feature = Feature::create([
            'title' => $request->title,
            'text' => $request->text,
        ]);
        $this->image_upload($request, $feature->id);
        return redirect()->route('admin.feature.index')->with('success', 'Feature added successfully.');
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
        Gate::authorize('edit-feature');
        $feature=Feature::findOrFail($id);
        return view('backend.pages.feature.edit',compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-feature');
        $feature=Feature::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string|max:2000',
            'icon' => 'nullable|image|mimes:png,jpg',
        ]);
        $feature->update([
            'title' => $request->title,
            'text' => $request->text,
            'status' => $request->status,
        ]);
        $this->image_upload($request, $feature->id);
        return redirect()->route('admin.feature.index')->with('success', 'Feature updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-feature');
        $feature=Feature::findOrFail($id);
        if ($feature->icon != 'default_icon.png') {
            //delete old photo
            $photo_location = 'public/uploads/feature/';
            $old_photo_location = $photo_location . $feature->icon;
            unlink(base_path($old_photo_location));
        }
        $feature->delete();
        return redirect()->route('admin.feature.index')->with('success', 'Feature deleted successfully.');
    }
    public function image_upload($request, $feature_id)
    {
        $feature = feature::findOrFail($feature_id);
        if ($request->hasFile('icon')) {
            if ($feature->icon != 'default_icon.png') {
                //delete old photo
                $photo_location = 'public/uploads/feature/';
                $old_photo_location = $photo_location . $feature->icon;
                unlink(base_path($old_photo_location));
            }
            $photo_loation = 'public/uploads/feature/';
            $uploaded_photo = $request->file('icon');
            $new_photo_name = time() . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->save(base_path($new_photo_location));
            $check = $feature->update([
                'icon' => $new_photo_name,
            ]);
        }
    }
}
