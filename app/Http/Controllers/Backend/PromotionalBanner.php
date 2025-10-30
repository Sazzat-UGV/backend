<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\SystemSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PromotionalBanner extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $system_settings=SystemSetting::findOrFail(1);
        $banners = Banner::query();
    if (!Auth::check() || (Auth::check() && Auth::user()->role !== 'ADMIN')) {
        $banners->where('is_active', 1);
    }
        $banners = $banners->latest('id')->paginate($request->per_page ?? 10);
        return response()->json([
            'status'  => true,
            'message' => 'Banner retrieved successfully.',
            'system_settings'    => $system_settings,
            'data'    => $banners,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:png,jpg,jpeg|max:10240',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $banner = new Banner();
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $final_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banner'), $final_name);
            $banner->image = $final_name;
        }
        $banner->save();
        return response()->json([
            'status'  => true,
            'message' => 'Banner created successfully.',
            'data'    => $banner,
        ], 200);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'sometimes|mimes:png,jpg,jpeg|max:10240',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        try {
            $banner = Banner::findOrFail($id);
            if ($request->hasFile('image')) {
                $photo_location     = public_path('uploads/banner');
                $old_photo          = basename(path: $banner->image);
                $old_photo_location = $photo_location . '/' . $old_photo;
                if (! in_array($old_photo, ['banner1.jpg', 'banner2.jpg', 'banner3.jpg', 'banner4.jpg', 'banner5.jpg', 'banner6.jpg', 'banner7.jpg'])) {
                    if (file_exists($old_photo_location)) {
                        unlink($old_photo_location);
                    }
                }

                $final_photo_name = time() . '.' . $request->image->extension();
                $request->image->move($photo_location, $final_photo_name);
                $banner->image = $final_photo_name;
            }
            $banner->save();
            return response()->json([
                'status'  => true,
                'message' => 'Banner updated successfully',
                'data'    => $banner,
            ]);
        } catch (Exception $e) {
            Log::error('Banner updated error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $banner = Banner::findOrFail($id);
            if ($banner) {
                $photo_location     = public_path('uploads/banner');
                $old_photo          = basename($banner->image);
                $old_photo_location = $photo_location . '/' . $old_photo;
                if (! in_array($old_photo, ['banner1.jpg', 'banner2.jpg', 'banner3.jpg', 'banner4.jpg', 'banner5.jpg', 'banner6.jpg', 'banner7.jpg'])) {
                    if (file_exists($old_photo_location)) {
                        unlink($old_photo_location);
                    }
                }
            }
            $banner->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Banner deleted successfully.',
                'data'    => $banner,
            ], 200);
        } catch (Exception $e) {
            Log::error('Banner deleted error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }

     public function toggleBannerStatus($id)
    {
        $banner = Banner::find($id);
        if (! $banner) {
             return response()->json([
            'status'  => false,
            'message' => 'Banner not found.',
        ], 404);
        }

        $banner->is_active = ! $banner->is_active;
        $banner->save();

          return response()->json([
            'status'  => true,
            'message' =>"Banner status has been changed successfully.",
            'data'    => $banner,
        ], 200);
    }
}
