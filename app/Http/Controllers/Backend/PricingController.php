<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PricingController extends Controller
{
    public function updatePrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uploading_video'         => 'required|string|max:5',
            'uploading_youTube_link'  => 'required|string|max:5',
            'onsite_account_creation' => 'required|string|max:5',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $pricing                          = Pricing::find(1);
        $pricing->uploading_video         = $request->uploading_video;
        $pricing->uploading_youTube_link  = $request->uploading_youTube_link;
        $pricing->onsite_account_creation = $request->onsite_account_creation;
        $pricing->save();
        return response()->json([
            'status'  => true,
            'message' => 'Pricing updated successfully.',
            'data'    => $pricing,
        ], 200);
    }

    public function getPrice()
    {
        try {
            $pricing = Pricing::findOrFail(1);
            return response()->json([
                'status'  => true,
                'message' => 'Pricing retreived successfully.',
                'data'    => $pricing,
            ], 200);
        } catch (Exception $e) {
            Log::error('Pricing retreived error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
}
