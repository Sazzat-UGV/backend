<?php

namespace App\Http\Controllers\Backend;

use Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Support\Facades\Gate;

class CounterController extends Controller
{
    public function edit()
    {
        Gate::authorize('edit-counter');
        $counter = Counter::where('id', 1)->first();
        return view('backend.pages.counter.index', compact('counter'));
    }

    public function update(Request $request)
    {
        Gate::authorize('edit-counter');

        $request->validate([
            'title1' => 'required|string|max:255',
            'number1' => 'required|string|max:255',
            'icon1' => 'sometimes|image|mimes:png,jpg|max:10240',
            'title2' => 'required|string|max:255',
            'number2' => 'required|string|max:255',
            'icon2' => 'sometimes|image|mimes:png,jpg|max:10240',
            'title3' => 'required|string|max:255',
            'number3' => 'required|string|max:255',
            'icon3' => 'sometimes|image|mimes:png,jpg|max:10240',
            'title4' => 'required|string|max:255',
            'number4' => 'required|string|max:255',
            'icon4' => 'sometimes|image|mimes:png,jpg|max:10240',
        ]);

        $counter = Counter::findOrFail(1);

        $counter->update([
            'title1' => $request->title1,
            'number1' => $request->number1,
            'title2' => $request->title2,
            'number2' => $request->number2,
            'title3' => $request->title3,
            'number3' => $request->number3,
            'title4' => $request->title4,
            'number4' => $request->number4,
            'status' => $request->status,
        ]);

        $this->image_upload($request, $counter);

        return redirect()->back()->with('success', 'Counter updated successfully.');
    }

    private function image_upload($request, $counter)
    {
        $icons = ['icon1', 'icon2', 'icon3', 'icon4'];

        foreach ($icons as $icon) {
            if ($request->hasFile($icon)) {
                $this->delete_old_photo($counter, $icon);
                $new_photo_name = $this->upload_new_photo($request, $icon);
                $counter->update([$icon => $new_photo_name]);
            }
        }
    }

    private function delete_old_photo($counter, $icon)
    {
        if ($counter->$icon != 'default_' . $icon . '.png') {
            $photo_location = 'public/uploads/counter/';
            $old_photo_location = $photo_location . $counter->$icon;

            if (file_exists(base_path($old_photo_location))) {
                unlink(base_path($old_photo_location));
            }
        }
    }

    private function upload_new_photo($request, $icon)
    {
        $photo_location = 'public/uploads/counter/';
        $uploaded_photo = $request->file($icon);
        $new_photo_name = time() . '_' . $icon . '.' . $uploaded_photo->getClientOriginalExtension();
        $new_photo_location = $photo_location . $new_photo_name;
        Image::make($uploaded_photo)->save(base_path($new_photo_location));

        return $new_photo_name;
    }
}
