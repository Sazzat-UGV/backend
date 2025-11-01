<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;

class ProfileController extends Controller
{
    public function ProfilePage()
    {
        return view('backend.pages.profile.profile');
    }

    public function editProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'address' => 'required',
            'phone' => 'required',
            'profile_photo' => 'sometimes|mimes:jpeg,jpg,png,gif|max:10240',
            'cover_photo' => 'sometimes|mimes:jpeg,jpg,png,gif|max:10240',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->date_of_birth = $request->date_of_birth;
        $user->postal_code = $request->postal_code;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->bio = $request->bio;

        $this->image_upload($request, $user);
        $user->save();
        return redirect()->route('admin.profile_page')->with('success', 'Profile has been updated.');
    }

    public function ChangePasswordPage()
    {
        return view('backend.pages.profile.change_password');
    }

    public function ChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|same:retype_password',
            'retype_password' => 'required',
        ]);
        $user = User::where('id', Auth::user()->id)->first();
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', 'Password has been updated.');
        }
        return redirect()->back()->with('error', "Password doesn't match with current password.");
    }

    public function image_upload($request, $user)
    {
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
            Image::make($uploaded_photo)->save(base_path($new_photo_location));
            $check = $user->update([
                'profile_photo' => $new_photo_name,
            ]);
        }
        if ($request->hasFile('cover_photo')) {
            if ($user->cover_photo != 'default_cover.jpg') {
                //delete old photo
                $photo_location = 'public/uploads/cover_photo/';
                $old_photo_location = $photo_location . $user->cover_photo;
                unlink(base_path($old_photo_location));
            }
            $photo_loation = 'public/uploads/cover_photo/';
            $uploaded_photo = $request->file('cover_photo');
            $new_photo_name = time() . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_loation . $new_photo_name;
            Image::make($uploaded_photo)->save(base_path($new_photo_location));
            $check = $user->update([
                'cover_photo' => $new_photo_name,
            ]);
        }
    }
}
