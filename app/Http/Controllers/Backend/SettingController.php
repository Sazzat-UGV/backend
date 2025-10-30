<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\ContactUsMail;
use App\Models\AboutUs;
use App\Models\Contact;
use App\Models\Page;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function getAboutUs()
    {
        $about_us = AboutUs::all();
        return response()->json([
            'status'  => true,
            'message' => 'About us retreived successfully.',
            'data'    => $about_us], 200);
    }

    public function updateAboutUs(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'icon'        => 'sometimes|mimes:png,jpg,jpeg|max:10240',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        try {
            $about_us = AboutUs::findOrFail($id);
            if ($request->hasFile('icon')) {
                $photo_location     = public_path('uploads/aboutus');
                $old_photo          = basename($about_us->icon);
                $old_photo_location = $photo_location . '/' . $old_photo;
                if (! in_array($old_photo, ['why_choose _myTsv.png', 'our_story.png', 'our_mission.png', 'meet_with_the_team.png', 'join_us.png'])) {
                    if (file_exists($old_photo_location)) {
                        unlink($old_photo_location);
                    }
                }

                $final_photo_name = time() . '.' . $request->icon->extension();
                $request->icon->move($photo_location, $final_photo_name);
                $about_us->icon = $final_photo_name;
            }
            $about_us->title       = $request->title;
            $about_us->description = $request->description;
            $about_us->save();
            return response()->json([
                'status'  => true,
                'message' => 'About us updated successfully',
                'data'    => $about_us,
            ]);
        } catch (Exception $e) {
            Log::error('About us updated error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
    public function getPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $page = Page::where('type', 'LIKE', '%' . $request->type . '%')->get();
        return response()->json([
            'status'  => true,
            'message' => $request->type . ' retrieved successfully',
            'data'    => $page,
        ]);
    }
    public function createOrUpdatePage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'text' => 'required|string',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $page = Page::updateOrCreate(
            ['type' => $request->type],
            ['text' => $request->text]
        );
        return response()->json([
            'status'  => true,
            'message' => 'Page created or updated successfully',
            'data'    => $page,
        ]);
    }
    public function getContact()
    {
        $contact = Contact::findOrFail(1);
        return response()->json([
            'status'  => true,
            'message' => 'Contact retreived successfully.',
            'data'    => $contact], 200);
    }
    public function updateContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        try {
            $contact          = Contact::findOrFail(1);
            $contact->email   = $request->email;
            $contact->phone   = $request->phone;
            $contact->address = $request->address;
            $contact->save();
            return response()->json([
                'status'  => true,
                'message' => 'Contact updated successfully',
                'data'    => $contact,
            ]);
        } catch (Exception $e) {
            Log::error('Contact updated error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $message_data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];
        Mail::to($request->email)->send(new ContactUsMail($message_data));
        return response()->json([
            'status'  => true,
            'message' => 'Message send successfully',
            'data'    => $message_data,
        ]);
    }
}
