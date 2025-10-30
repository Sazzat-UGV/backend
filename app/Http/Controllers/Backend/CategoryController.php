<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::latest('id')->paginate($request->per_page ?? 10);
        return response()->json([
            'status'  => true,
            'message' => 'Category retreived successfully.',
            'data'    => $categories,
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
            'name' => 'required|string|unique:categories,name|max:255',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $category = Category::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'status'  => true,
            'message' => 'Category created successfully.',
            'data'    => $category,
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
        try {
            $category  = Category::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            ]);
            if ($validator->fails()) {
                $firstError = collect($validator->errors()->all())->first();
                return response()->json([
                    'message' => $firstError,
                    'errors'  => $validator->errors(),
                ], 422);
            }
            $category->name = $request->name;
            $category->save();

            return response()->json([
                'status'  => true,
                'message' => 'Category updated successfully.',
                'data'    => $category,
            ], 200);
        } catch (Exception $e) {
            Log::error('Category updated error: ' . $e->getMessage());
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
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Category deleted successfully.',
                'data'    => $category,
            ], 200);
        } catch (Exception $e) {
            Log::error('Category deleted error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
}
