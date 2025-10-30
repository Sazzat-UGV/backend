<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DislikedVideo;
use App\Models\LikedVideo;
use App\Models\User;
use App\Models\Video;
use App\Notifications\VideoPublishNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $videos = Video::with('user:id,channel_name,avatar')->withCount(['likes', 'dislikes', 'comments', 'reply'])->where('user_id', Auth::id());
        if ($request->search) {
            $videos = $videos->where('title', 'LIKE', '%' . $request->search . '%');
        }
        $videos = $videos->latest('id')->paginate($request->per_page ?? 10);

        $videos->getCollection()->transform(function ($video) {
            $video->total_comment                  = $video->comments_count + $video->reply_count;
            $video->comment_replies_count          = $video->total_comment;
            $video->comment_replies_count_formated = Number::abbreviate($video->total_comment);
            $video->created_date                   = $video->created_at->format('d-m-Y');
            $video->created_time                   = $video->created_at->format('h:i A');
            $video->views_count_formated           = Number::abbreviate($video->views);
            $video->created_at_format              = $video->created_at->diffForHumans();
            return $video;
        });
        return response()->json([
            'status'  => true,
            'message' => 'Videos retrieved successfully.',
            'data'    => $videos,
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
            'category_id' => 'required|numeric|exists:categories,id',
            'type'        => 'required|string|in:video,link',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail'   => 'required|mimes:png,jpg,jpeg|max:20480',
            'video'       => 'required_if:type,video|mimes:mp4|max:1048576',
            'link'        => 'required_if:type,link|url',
            'states'      => 'required|string',
            'city'        => 'required|string',
            'tags'        => 'required',
            'is_promoted' => 'required|in:1,0',
            'visibility'  => 'required|in:Everyone,Only me',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $video              = new Video();
        $video->user_id     = Auth::user()->id;
        $video->category_id = $request->category_id;
        $video->type        = $request->type;
        $video->title       = $request->title;
        $video->description = $request->description;
        if ($request->hasFile('thumbnail')) {
            $thumbnail  = $request->file('thumbnail');
            $final_name = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move(public_path('uploads/thumbnail'), $final_name);
            $video->thumbnail = $final_name;
        }
        if ($request->type == 'video' && $request->hasFile('video')) {
            $uploadedVideo = $request->file('video');
            $final_name    = time() . '.' . $uploadedVideo->getClientOriginalExtension();
            $uploadedVideo->move(public_path('uploads/video'), $final_name);
            $video->video = $final_name;
        }

        if ($request->type == 'link') {
            $video->link = $request->link;
        }
        $video->states      = $request->states;
        $video->city        = $request->city;
        $video->tags        = $request->tags;
        $video->is_promoted = $request->is_promoted;
        $video->visibility  = $request->visibility;
        $video->save();
        // notification send
        $admin                = User::findOrFail(1);
        $existingNotification = $admin->unreadNotifications()
            ->where('type', VideoPublishNotification::class)
            ->first();
        if ($existingNotification) {
            $data = $existingNotification->data;

            $data['count'] += 1;

            if ($data['count'] > 9) {
                $data['title'] = "9+ new video published.";
            } else {
                $data['title'] = "{$data['count']} new video published.";
            }

            $existingNotification->update([
                'data' => $data,
            ]);
        } else {
            $count   = 1;
            $message = "{$count} new video published.";

            $admin->notify(new VideoPublishNotification($count, $message));
        }
        return response()->json([
            'status'  => true,
            'message' => 'Video created successfully.',
            'data'    => $video,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $video                                 = Video::with('category', 'user:id,name,channel_name,avatar')->withCount(['likes', 'dislikes', 'comments', 'reply'])->findOrFail($id);
            $comment_replies_count                 = $video->comments_count + $video->reply_count;
            $video->views_count_formated           = Number::abbreviate($video->views);
            $video->likes_count_formated           = Number::abbreviate($video->likes_count);
            $video->dislikes_count_formated        = Number::abbreviate($video->dislikes_count);
            $video->comment_replies_count_formated = Number::abbreviate($comment_replies_count);
            $video->publish_time_formated          = $video->created_at->diffForHumans();
            $video->publish_date                   = $video->created_at->format('d-m-Y');
            $video->publish_time                   = $video->created_at->format('H:i A');
            // Check like/dislike status for auth user
            if (auth()->check()) {
                $video->is_liked    = $video->likes()->where('user_id', auth()->id())->exists();
                $video->is_disliked = $video->dislikes()->where('user_id', auth()->id())->exists();
            } else {
                $video->is_liked    = false;
                $video->is_disliked = false;
            }

            return response()->json([
                'status'  => true,
                'message' => 'Video details retrieved successfully.',
                'data'    => $video,
            ], 200);
        } catch (Exception $e) {
            Log::error('Video update error: ' . $e->getMessage());
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
            'category_id' => 'required|numeric|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail'   => 'sometimes|mimes:png,jpg,jpeg|max:204800',
            'video'       => 'sometimes|mimes:mp4|max:51200',
            'link'        => 'sometimes|url',
            'states'      => 'required|string',
            'city'        => 'required|string',
            'tags'        => 'required',
            'visibility'  => 'required|in:Everyone,Only me',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        try {
            $video              = Video::findOrFail($id);
            $video->user_id     = Auth::user()->id;
            $video->category_id = $request->category_id;
            $video->title       = $request->title;
            $video->description = $request->description;
            // Thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $photo_location     = public_path('uploads/thumbnail');
                $old_photo          = basename($video->thumbnail);
                $old_photo_location = $photo_location . '/' . $old_photo;
                if (file_exists($old_photo_location)) {
                    unlink($old_photo_location);
                }
                $file = $request->file('thumbnail');
                $name = time() . '.' . $file->extension();
                $file->move(public_path('uploads/thumbnail'), $name);
                $video->thumbnail = $name;
            }

            // Video upload
            if ($request->hasFile('video')) {
                $video_location     = public_path('uploads/video');
                $old_video          = basename($video->video);
                $old_video_location = $video_location . '/' . $old_video;
                if (file_exists($old_video_location)) {
                    unlink($old_video_location);
                }

                $file = $request->file('video');
                $name = time() . '.' . $file->extension();
                $file->move(public_path('uploads/video'), $name);
                $video->video = $name;
            }
            $video->link   = $request->link;
            $video->states = $request->states;
            $video->city   = $request->city;
            $video->tags   = $request->tags;
            if ($video->is_suspend == 1) {
                $video->visibility = 'Only me';
            } else {
                $video->visibility = $request->visibility;
            }
            $video->save();

            return response()->json([
                'status'  => true,
                'message' => 'Video update successfully.',
                'data'    => $video,
            ], 200);
        } catch (Exception $e) {
            Log::error('Video update error: ' . $e->getMessage());
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
            $video = Video::findOrFail($id);
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

            return response()->json([
                'status'  => true,
                'message' => 'Video deleted successfully.',
                'data'    => $video,
            ], 200);
        } catch (Exception $e) {
            Log::error('Video deleted error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:videos,id',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $videos = Video::whereIn('id', $request->ids)->get();
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

        return response()->json([
            'status'  => true,
            'message' => 'Videos deleted successfully.',
        ]);
    }

    public function changeVisibility(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'visibility' => 'required|in:Everyone,Only me',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        try {
            $video = Video::findOrFail($id);
            if ($video->is_suspend == 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'You are not able to change the visibility because this video already suspended.',
                ]);
            }
            $video->visibility = $request->visibility;
            $video->save();
            return response()->json([
                'status'  => true,
                'message' => 'Video visibility updated successfully.',
                'data'    => $video,
            ], 200);
        } catch (Exception $e) {
            Log::error('Video visibility update error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }

    public function videoAnalytics(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type'  => 'required|in:monthly,yearly,custom',
            'month' => 'required_if:type,custom|in:Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        if ($request->type === 'monthly') {
            $now         = Carbon::now();
            $daysInMonth = $now->daysInMonth;

            $counts = DB::table('watch_histories')
                ->where('video_id', $id)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total_watch'))
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('total_watch', 'day');

            $views_analytics = collect(range(1, $daysInMonth))->map(function ($day) use ($counts) {
                return [
                    'day'         => $day,
                    'total_watch' => $counts->get($day, 0),
                ];
            });
            $total_watch_count = $counts->sum();
            $total_like_count  = LikedVideo::where('video_id', $id)->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)->count();
            $total_dislike_count = DislikedVideo::where('video_id', $id)->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)->count();
            $message = 'Video analytics retrieved successfully for ' . now()->format('F') . ' ' . now()->format('Y') . '.';
        }
        if ($request->type === 'yearly') {
            $now = Carbon::now();

            // Monthly watch count
            $counts = DB::table('watch_histories')
                ->where('video_id', $id)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total_watch'))
                ->whereYear('created_at', $now->year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->pluck('total_watch', 'month');

            // Prepare analytics for 12 months
            $views_analytics = collect(range(1, 12))->map(function ($month) use ($counts) {
                return [
                    'month'       => Carbon::create()->month($month)->format('M'),
                    'total_watch' => $counts->get($month, 0),
                ];
            });

            $total_watch_count = $counts->sum();
            $total_like_count  = LikedVideo::where('video_id', $id)
                ->whereYear('created_at', $now->year)
                ->count();

            $total_dislike_count = DislikedVideo::where('video_id', $id)
                ->whereYear('created_at', $now->year)
                ->count();
            $message = 'Video analytics retrieved successfully for ' . now()->format('Y') . '.';
        }
        if ($request->type === 'custom') {
            $month = Carbon::createFromFormat('M', $request->month)->month;
            $year  = $request->year ?? now()->year;

            $date = Carbon::createFromDate($year, $month, 1);

            $daysInMonth = $date->daysInMonth;
            $counts      = DB::table('watch_histories')
                ->where('video_id', $id)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total_watch'))
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('total_watch', 'day');

            $views_analytics = collect(range(1, $daysInMonth))->map(function ($day) use ($counts) {
                return [
                    'day'         => $day,
                    'total_watch' => $counts->get($day, 0),
                ];
            });

            $total_watch_count = $counts->sum();
            $total_like_count  = LikedVideo::where('video_id', $id)->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)->count();
            $total_dislike_count = DislikedVideo::where('video_id', $id)->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)->count();
            $message = 'Video analytics retrieved successfully for ' . $request->month . ' ' . $year . '.';
        }
        $data = [
            'total_views'    => $total_watch_count,
            'total_likes'    => $total_like_count,
            'total_dislikes' => $total_dislike_count,
            'analytics'      => $views_analytics,
        ];
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], 200);
    }

    public function globalSearchVideos(Request $request)
    {
        // Video query
        $videos = Video::with('user:id,channel_name,avatar')
            ->withCount(['likes', 'dislikes', 'comments', 'reply'])
            ->latest('id');
        // "comments_count": 4,
        // "comment_replies_count": 2,
        if ($request->service) {
            $videos->where('category_id', $request->service);
        }
        if ($request->state) {
            $videos->where('states', 'LIKE', '%' . $request->state . '%');
        }
        if ($request->city) {
            $videos->where('city', 'LIKE', '%' . $request->city . '%');
        }
        if ($request->search) {
            if (str_starts_with($request->search, '#')) {
                $tag = ltrim($request->search, '#');
                $videos->where('tags', 'LIKE', '%' . $tag . '%');
            } else {
                $videos->where('title', 'LIKE', '%' . $request->search . '%');
            }
        }

        $videos = $videos->paginate($request->per_page ?? 10);

        $videos->getCollection()->transform(function ($video) {
            $video->total_comment                  = $video->comments_count + $video->reply_count;
            $video->comment_replies_count          = $video->total_comment;
            $video->comment_replies_count_formated = Number::abbreviate($video->total_comment);
            $video->created_date                   = $video->created_at->format('d-m-Y');
            $video->created_time                   = $video->created_at->format('h:i A');
            $video->views_count_formated           = Number::abbreviate($video->views);
            $video->created_at_format              = $video->created_at->diffForHumans();
            return $video;
        });

        // Get all categories once
        $categories = Category::select('id', 'name')->where('id', $request->service)->get();

        return response()->json([
            'status'  => true,
            'message' => 'Videos and categories retrieved successfully.',
            'data'    => [
                'categories' => $categories,
                'videos'     => $videos,
            ],
        ], 200);
    }

}
