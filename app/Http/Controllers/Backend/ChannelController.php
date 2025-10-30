<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LikedVideo;
use App\Models\User;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;

class ChannelController extends Controller
{
    public function getChannels(Request $request)
    {
        $perPage = $request->per_page ?? 10;

        $channels = User::withCount('videos')
            ->where('role', 'USER')
            ->latest('id');
        if ($request->search) {
            $channels = $channels->where('email', 'LIKE', '%' . $request->search . '%')->orWhere('channel_name', 'LIKE', '%' . $request->search . '%');
        }
        $channels = $channels->paginate($perPage);

        $channels->getCollection()->transform(function ($channel) {
            $videoIds                      = $channel->videos()->pluck('id');
            $channel->views_count          = Video::whereIn('id', $videoIds)->sum('views');
            $channel->views_count_formated = Number::abbreviate(Video::whereIn('id', $videoIds)->sum('views'));
            $channel->likes_count          = LikedVideo::whereIn('video_id', $videoIds)->count();
            $channel->likes_count_formated = Number::abbreviate(LikedVideo::whereIn('video_id', $videoIds)->count());
            return $channel;
        });

        return response()->json([
            'status'  => true,
            'message' => 'Channels retrieved successfully.',
            'data'    => $channels,
        ], 200);
    }

    public function deleteChannel($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->role == 'ADMIN') {
                return response()->json([
                    'status'  => false,
                    'message' => 'You cannot delete admin role.',
                ], 200);
            }
            $videos = Video::where('user_id', $id)->get();
            if ($videos) {
                foreach ($videos as $video) {
                    if ($video->thumbnail) {
                        $photo_location     = public_path('uploads/thumbnail');
                        $old_photo          = basename($video->thumbnail);
                        $old_photo_location = $photo_location . '/' . $old_photo;
                        if (file_exists($old_photo_location)) {
                            unlink($old_photo_location);
                        }
                    }
                    if ($video->video) {
                        $video_location     = public_path('uploads/video');
                        $old_video          = basename($video->video);
                        $old_video_location = $video_location . '/' . $old_video;
                        if (file_exists($old_video_location)) {
                            unlink($old_video_location);
                        }
                    }
                    $video->delete();
                }
            }
            if ($user->avatar && $user->avatar != 'default_avatar.png') {
                $photo_location     = public_path('uploads/user');
                $old_photo          = basename($user->avatar);
                $old_photo_location = $photo_location . '/' . $old_photo;
                if (file_exists($old_photo_location)) {
                    unlink($old_photo_location);
                }
            }

            if ($user->cover_image && $user->cover_image != 'default_cover_image.jpg') {
                $photo_location     = public_path('uploads/cover');
                $old_photo          = basename($user->cover_image);
                $old_photo_location = $photo_location . '/' . $old_photo;
                if (file_exists($old_photo_location)) {
                    unlink($old_photo_location);
                }
            }

            $user->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Profile deleted successfully.',
                'data'    => $user,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting profile: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while deleting the profile. Please try again later.',
            ], 401);
        }

    }
    public function getChannelDetails(Request $request, $id)
    {
        $channel  = User::where('id', (int) $id)->select('id', 'channel_name', 'email', 'cover_image', 'avatar', 'bio', 'contact', 'locations', 'services')->first();
        $videoIds = Video::where('user_id', $id)->pluck('id');
        $videos   = Video::with('user:id,channel_name,avatar')->where('user_id', $id)->latest('id')->paginate($request->per_page ?? 10);
        $videos->getCollection()->transform(function ($video) {
            $video->views_count_formated = Number::abbreviate($video->views);
            $video->created_at_format    = $video->created_at->diffForHumans();
            return $video;
        });
        $data     = [
            'channel'      => $channel,
            'total_views'  => Video::where('user_id', $id)->sum('views'),
            'total_videos' => Video::where('user_id', $id)->count(),
            'total_likes'  => LikedVideo::whereIn('video_id', $videoIds)->count(),
            'videos'       => $videos,
        ];
        return response()->json([
            'status'  => true,
            'message' => 'Channel detail retrieved successfully.',
            'data'    => $data,
        ], 200);
    }
}
   