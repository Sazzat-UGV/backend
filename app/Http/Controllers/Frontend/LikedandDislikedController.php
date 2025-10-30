<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DislikedVideo;
use App\Models\LikedVideo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LikedandDislikedController extends Controller
{
    public function addLikeDislike(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_id' => 'required|exists:videos,id',
            'action'   => 'required|in:like,dislike',
        ]);

        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $userId  = Auth::id();
        $videoId = $request->video_id;

        if ($request->action === 'like') {
            $liked = LikedVideo::where('video_id', $videoId)->where('user_id', $userId)->first();

            if ($liked) {
                $liked->delete();
                $status = 'like removed';
            } else {
                LikedVideo::create([
                    'user_id'  => $userId,
                    'video_id' => $videoId,
                ]);
                DislikedVideo::where('video_id', $videoId)->where('user_id', $userId)->delete();
                $status = 'liked';
            }
        } elseif ($request->action === 'dislike') {
            $disliked = DislikedVideo::where('video_id', $videoId)->where('user_id', $userId)->first();

            if ($disliked) {
                $disliked->delete();
                $status = 'dislike removed';
            } else {
                DislikedVideo::create([
                    'user_id'  => $userId,
                    'video_id' => $videoId,
                ]);
                LikedVideo::where('video_id', $videoId)->where('user_id', $userId)->delete();

                $status = 'disliked';
            }
        }

        return response()->json([
            'message' => 'Action processed successfully.',
            'status'  => $status,
        ], 200);
    }

    public function getLikeVideos(Request $request)
    {
        $liked_videos = LikedVideo::with('video:id,user_id,title,description,thumbnail,views,created_at', 'video.user:id,channel_name')
            ->where('user_id', Auth::id())
            ->latest('id')->paginate($request->per_page ?? 10);

        $liked_videos->getCollection()->transform(function ($history) {
            $history->video->views_count = $this->formatNumber($history->video->views);
            $history->video->upload_time = Carbon::parse($history->video->created_at)->diffForHumans();
            return $history;
        });

        return response()->json([
            'status'  => true,
            'message' => 'Liked videos retrieved successfully.',
            'data'    => $liked_videos,
        ], 200);
    }
    private function formatNumber($num)
    {
        if ($num >= 1000000) {
            return number_format($num / 1000000, 1) . 'M';
        } elseif ($num >= 1000) {
            return number_format($num / 1000, 1) . 'K';
        }
        return (string) $num;
    }

    public function deleteLikeVideos($id)
    {
        try {
            $liked_video = LikedVideo::findOrFail($id);
            $liked_video->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Liked video deleted successfully.',
                'data'    => $liked_video,
            ], 200);
        } catch (Exception $e) {
            Log::error('Liked video deleted error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
}
