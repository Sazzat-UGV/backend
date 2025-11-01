<?php

namespace App\Http\Controllers\Backend;

use Image;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class SliderController extends Controller
{
    public function index()
    {
        Gate::authorize('browse-slider');
        $sliders = Slider::latest('id')->paginate();
        return view('backend.pages.slider.index', compact('sliders'));
    }

    public function create()
    {
        Gate::authorize('add-slider');
        return view('backend.pages.slider.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('add-slider');
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:300',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:10240',
        ]);

        $slider = Slider::create($request->only(['title', 'description', 'button_name', 'button_link']));
        $this->uploadImage($request, $slider);

        return redirect()->route('admin.slider.index')->with('success', 'Slider created successfully.');
    }

    public function edit(string $id)
    {
        Gate::authorize('edit-slider');
        $slider = Slider::findOrFail($id);
        return view('backend.pages.slider.edit', compact('slider'));
    }

    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-slider');
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:300',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:10240',
        ]);

        $slider = Slider::findOrFail($id);
        $slider->update($request->only(['title', 'description', 'button_name', 'button_link']));

        if ($request->hasFile('image')) {
            $this->uploadImage($request, $slider);
        }

        return redirect()->route('admin.slider.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(string $id)
    {
        Gate::authorize('delete-slider');
        $slider = Slider::findOrFail($id);

        $this->deleteImage($slider->image);

        $slider->delete();
        return redirect()->route('admin.slider.index')->with('success', 'Slider deleted successfully.');
    }

    private function uploadImage(Request $request, Slider $slider)
    {
        if ($slider->image && !$this->isDefaultImage($slider->image)) {
            $this->deleteImage($slider->image);
        }

        $photoLocation = 'public/uploads/slider/';
        $uploadedPhoto = $request->file('image');
        $newPhotoName = time() . '.' . $uploadedPhoto->getClientOriginalExtension();
        $newPhotoLocation = base_path($photoLocation . $newPhotoName);

        Image::make($uploadedPhoto)->save($newPhotoLocation);
        $slider->update(['image' => $newPhotoName]);
    }

    private function deleteImage(string $image)
    {
        $photoLocation = 'public/uploads/slider/';
        $imagePath = base_path($photoLocation . $image);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    private function isDefaultImage(string $image): bool
    {
        $defaultImages = ['1.png', '2.png', '3.png'];
        return in_array($image, $defaultImages);
    }
}
