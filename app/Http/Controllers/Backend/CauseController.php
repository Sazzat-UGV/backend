<?php

namespace App\Http\Controllers\Backend;

use Image;
use App\Models\User;
use App\Models\Cause;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CauseDonation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class CauseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('browse-cause');

        $causes = Cause::latest('id');
        if ($request->search) {
            $causes = $causes->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $causes = $causes->paginate(10);
        return view('backend.pages.cause.index', compact('causes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('add-cause');
        return view('backend.pages.cause.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('add-cause');
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'goal' => 'nullable|numeric|min:1',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:10240',
        ]);
        $cause = Cause::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'goal' => $request->goal,
        ]);
        $this->image_upload($request, $cause->id);
        return redirect()->route('admin.cause.index')->with('success', 'Cause added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('read-cause');
        $cause = Cause::findOrFail($id);
        return view('backend.pages.cause.show', compact('cause'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('edit-cause');
        $cause = Cause::findOrFail($id);
        return view('backend.pages.cause.edit', compact('cause'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('edit-cause');
        $cause = Cause::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'goal' => 'nullable|numeric|min:1',
            'photo' => 'sometimes|image|mimes:png,jpg,jpeg|max:10240',
        ]);
        $cause->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'goal' => $request->goal,
        ]);
        $this->image_upload($request, $cause->id);
        return redirect()->route('admin.cause.index')->with('success', 'Cause updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete-cause');
        $cause = Cause::findOrFail($id);
        if ($cause->featured_photo != 'default-cause.png') {
            //delete old photo
            $photo_location = 'public/uploads/cause/';
            $old_photo_location = $photo_location . $cause->featured_photo;
            unlink(base_path($old_photo_location));
        }
        $cause->delete();
        return redirect()->route('admin.cause.index')->with('success', 'Cause deleted successfully.');
    }

    public function image_upload($request, $goal_id)
    {
        $cause = Cause::findOrFail($goal_id);
        if ($request->hasFile('photo')) {
            if ($cause->featured_photo != 'default-cause.png') {
                //delete old photo
                $photo_location = 'public/uploads/cause/';
                $old_photo_location = $photo_location . $cause->featured_photo;
                unlink(base_path($old_photo_location));
            }
            $photo_loation = 'public/uploads/cause/';
            $uploaded_photo = $request->file('photo');
            $new_photo_name = time() . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->save(base_path($new_photo_location));
            $check = $cause->update([
                'featured_photo' => $new_photo_name,
            ]);
        }
    }

    public function causeDonationPage($id)
    {
        Gate::authorize('cause-donation');
        $causeDonation = CauseDonation::with('user')->where('cause_id', $id)->where('payment_status', 'COMPLETED')->latest('id')->get();
        return view('backend.pages.cause.cause_donation', compact('causeDonation'));
    }

    public function causeDonationInvoice($id)
    {
        Gate::authorize('cause-donation');
        $cause_donation = CauseDonation::with('user', 'cause')->where('id', $id)->first();
        $billed_to = User::where('id', 1)->first();
        return view('backend.pages.cause.cause_donation_invoice', compact('cause_donation', 'billed_to'));
    }
}
