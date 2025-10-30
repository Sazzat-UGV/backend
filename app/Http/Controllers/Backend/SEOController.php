<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SEOController extends Controller
{
    public function getSeo()
    {
        $seo = Seo::find(1);
        return response()->json([
            'status'  => true,
            'message' => 'SEO information retreived successfully.',
            'data'    => $seo,
        ], 200);
    }
    public function updateSeo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'tags'        => 'required',
            'links'       => 'required',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        try {
            $seo              = Seo::findOrFail(1);
            $seo->title       = $request->title;
            $seo->description = $request->description;
            $seo->tags        = json_encode($request->tags, true);
            $seo->links       = json_encode($request->links, true);
            $seo->save();
            return response()->json([
                'status'  => true,
                'message' => 'Seo updated successfully.',
                'data'    => $seo,
            ], 200);
        } catch (Exception $e) {
            Log::error('Seo updated error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
}
