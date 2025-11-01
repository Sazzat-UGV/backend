<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Image;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('browse-testimonial');
        $testimonials = Testimonial::latest('id')->paginate(10);
        return view('backend.pages.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('add-testimonial');
        return view('backend.pages.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-testimonial');
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'comment' => 'required|string|max:255',
            'rating' => 'required|numeric|max:5',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:10240',
        ]);
        $testimonial = Testimonial::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'status' => $request->status,
        ]);
        $this->image_upload($request, $testimonial->id);
        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial created successfully.');

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
        Gate::authorize('edit-testimonial');
        $testimonial = Testimonial::findOrFail($id);
        return view('backend.pages.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-testimonial');
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'comment' => 'required|string|max:255',
            'rating' => 'required|numeric|max:5',
            'photo' => 'sometimes|image|mimes:png,jpg,jpeg|max:10240',
        ]);
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'status' => $request->status,
        ]);
        $this->image_upload($request, $testimonial->id);
        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-testimonial');
        $testimonial = Testimonial::findOrFail($id);
        if ($testimonial->photo != 'default_testimonial.png') {
            //delete old photo
            $photo_location = 'public/uploads/testimonial/';
            $old_photo_location = $photo_location . $testimonial->photo;
            unlink(base_path($old_photo_location));
        }
        $testimonial->delete();
        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial deleted successfully.');
    }

    public function image_upload($request, $testimonial_id)
    {
        $testimonial = Testimonial::findOrFail($testimonial_id);
        if ($request->hasFile('photo')) {
            if ($testimonial->photo != 'default_testimonial.png') {
                //delete old photo
                $photo_location = 'public/uploads/testimonial/';
                $old_photo_location = $photo_location . $testimonial->photo;
                unlink(base_path($old_photo_location));
            }
            $photo_loation = 'public/uploads/testimonial/';
            $uploaded_photo = $request->file('photo');
            $new_photo_name = time() . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->resize(800, 800)->save(base_path($new_photo_location));
            $check = $testimonial->update([
                'photo' => $new_photo_name,
            ]);
        }
    }
}
