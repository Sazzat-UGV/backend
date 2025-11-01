<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Special;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Image;

class SpecialController extends Controller
{
    public function edit()
    {
        Gate::authorize('edit-special-section');
        $special = Special::where('id', 1)->first();
        return view('backend.pages.special.index', compact('special'));
    }

    public function update(Request $request)
    {
        Gate::authorize('edit-special-section');
        $request->validate([
            'heading' => 'required|string|max:255',
            'sub_heading' => 'required|string|max:255',
            'text' => 'required|string|max:2000',
        ]);
        $special = Special::findOrFail(1);
        $special->update([
            'heading' => $request->heading,
            'sub_heading' => $request->sub_heading,
            'text' => $request->text,
            'button_name' => $request->button_name,
            'button_link' => $request->button_link,
            'video_id' => $request->video_id,
            'video_button_name' => $request->video_button_name,
            'status' => $request->status,
        ]);
        $this->image_upload($request, $special->id);
        return redirect()->back()->with('success', 'Special section updated successfully.');
    }

    public function image_upload($request, $special_id)
    {
        $special = Special::findOrFail($special_id);
        if ($request->hasFile('photo')) {
            $photo_loation = 'public/uploads/others/';
            $uploaded_photo = $request->file('photo');
            $new_photo_name = 'special' . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->save(base_path($new_photo_location));
            $check = $special->update([
                'photo' => $new_photo_name,
            ]);
        }
    }
}
