<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use App\Models\Report;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppealController extends Controller
{
    public function addAppeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_id'   => 'required|exists:reports,id',
            'subject'     => 'required|string',
            'explanation' => 'required|string',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $appeal = Appeal::create([
            'user_id'     => Auth::id(),
            'report_id'   => $request->report_id,
            'subject'     => $request->subject,
            'explanation' => $request->explanation,
            'status'      => 'Pending',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Appeal added successfully.',
            'data'    => $appeal,
        ], 200);
    }

    public function getAdminAppeal(Request $request)
    {
        $appeals = Appeal::with('user:id,name,channel_name,avatar')->latest('id')->paginate($request->per_page ?? 10);
        return response()->json([
            'status'  => true,
            'message' => 'Appeals retreived successfully.',
            'data'    => $appeals,
        ], 200);
    }

    public function getAppealDetails($id)
    {
        try {
            $appeal = Appeal::findOrFail($id);
            return response()->json([
                'status'  => true,
                'message' => 'Appeal detail retreived successfully.',
                'data'    => $appeal,
            ], 200);
        } catch (Exception $e) {
            Log::error('Appeal detail error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }

    public function takeAppealAction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'action_name' => 'required|in:accept,decline',
        ]);

        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $appeal = Appeal::findOrFail($id);
            $report = Report::findOrFail($appeal->report_id);
            $video  = Video::findOrFail($report->video_id);
            if ($request->action_name == 'accept') {
                $appeal->status = 'Accept';
                $appeal->save();

                $video->is_suspend     = false;
                $video->visibility     = 'Everyone';
                $video->suspend_reason = null;
                $video->suspend_until  = null;
                $video->save();
            } elseif ($request->action_name == 'decline') {
                $appeal->status = 'Decline';
                $appeal->save();
            }
            return response()->json([
                'status'  => true,
                'message' => 'You ' . $request->action_name . ' the appeal request.',
                'data'    => $appeal,
            ], 200);
        } catch (Exception $e) {
            Log::error('Appeal data error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
    public function appealDelete($id)
    {
        try {
            $appeal = Appeal::findOrFail($id);
            $appeal->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Appeal deleted successfully.',
                'data'    => $appeal,
            ], 200);
        } catch (Exception $e) {
            Log::error('Appeal delete error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
}
