<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $blogs = Blog::latest('id')->paginate($request->per_page ?? 10);
        return response()->json([
            'status'  => true,
            'message' => 'Blog retreived successfully.',
            'data'    => $blogs,
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
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'required|mimes:png,jpg,jpeg|max:10240',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $blog              = new Blog();
        $blog->title       = $request->title;
        $blog->description = $request->description;
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $final_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blog'), $final_name);
            $blog->image = $final_name;
        }
        $blog->save();
        return response()->json([
            'status'  => true,
            'message' => 'Blog created successfully.',
            'data'    => $blog,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $blog = Blog::findOrFail($id);
            return response()->json([
                'status'  => true,
                'message' => 'Blog retreived successfully.',
                'data'    => $blog,
            ], 200);
        } catch (Exception $e) {
            Log::error('Blog retreived error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
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
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'sometimes|mimes:png,jpg,jpeg|max:10240',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        try {
            $blog = Blog::findOrFail($id);
            if ($request->hasFile('image')) {
                $photo_location     = public_path('uploads/blog');
                $old_photo          = basename($blog->image);
                $old_photo_location = $photo_location . '/' . $old_photo;
                if (! in_array($old_photo, ['blog1.jpg', 'blog2.jpg', 'blog3.jpg', 'blog4.jpg', 'blog5.jpg', 'blog6.jpg', 'blog7.jpg'])) {
                    if (file_exists($old_photo_location)) {
                        unlink($old_photo_location);
                    }
                }

                $final_photo_name = time() . '.' . $request->image->extension();
                $request->image->move($photo_location, $final_photo_name);
                $blog->image = $final_photo_name;
            }
            $blog->title       = $request->title;
            $blog->description = $request->description;
            $blog->save();
            return response()->json([
                'status'  => true,
                'message' => 'Blog updated successfully',
                'data'    => $blog,
            ]);
        } catch (Exception $e) {
            Log::error('Blog updated error: ' . $e->getMessage());
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
            $blog = Blog::findOrFail($id);
            if ($blog) {
                $photo_location     = public_path('uploads/blog');
                $old_photo          = basename($blog->image);
                $old_photo_location = $photo_location . '/' . $old_photo;
                if (! in_array($old_photo, ['blog1.jpg', 'blog2.jpg', 'blog3.jpg', 'blog4.jpg', 'blog5.jpg', 'blog6.jpg', 'blog7.jpg'])) {
                    if (file_exists($old_photo_location)) {
                        unlink($old_photo_location);
                    }
                }
            }
            $blog->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Blog deleted successfully.',
                'data'    => $blog,
            ], 200);
        } catch (Exception $e) {
            Log::error('Blog deleted error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
}
