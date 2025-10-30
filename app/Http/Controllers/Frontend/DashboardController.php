<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LikedVideo;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
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
        $videoIds = Video::where('user_id', Auth::id())->pluck('id');
        $now      = Carbon::now();
        if ($request->type === 'monthly') {
            $daysInMonth = $now->daysInMonth;

            // views_analytics
            $views_counts = DB::table('watch_histories')
                ->whereIn('video_id', $videoIds)
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total_watch'))
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('total_watch', 'day');

            $views_analytics = collect(range(1, $daysInMonth))->map(function ($day) use ($views_counts) {
                return [
                    'day'         => $day,
                    'total_watch' => $views_counts->get($day, 0),
                ];
            });
            // likes_analytics
            $likes_counts = DB::table('liked_videos')
                ->whereIn('video_id', $videoIds)
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total_liked'))
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('total_liked', 'day');

            $likes_analytics = collect(range(1, $daysInMonth))->map(function ($day) use ($likes_counts) {
                return [
                    'day'         => $day,
                    'total_likes' => $likes_counts->get($day, 0),
                ];
            });
            // dislikes_analytics
            $dislikes_counts = DB::table('disliked_videos')
                ->whereIn('video_id', $videoIds)
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total_disliked'))
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('total_disliked', 'day');

            $dislikes_analytics = collect(range(1, $daysInMonth))->map(function ($day) use ($dislikes_counts) {
                return [
                    'day'            => $day,
                    'total_dislikes' => $dislikes_counts->get($day, 0),
                ];
            });
        }

        if ($request->type === 'yearly') {
            // views_analytics
            $views_counts = DB::table('watch_histories')
                ->whereIn('video_id', $videoIds)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total_watch'))
                ->whereYear('created_at', $now->year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->pluck('total_watch', 'month');

            $views_analytics = collect(range(1, 12))->map(function ($month) use ($views_counts) {
                return [
                    'month'       => Carbon::create()->month($month)->format('M'),
                    'total_watch' => $views_counts->get($month, 0),
                ];
            });
            // likes_analytics
            $likes_counts = DB::table('liked_videos')
                ->whereIn('video_id', $videoIds)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total_liked'))
                ->whereYear('created_at', $now->year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->pluck('total_liked', 'month');

            $likes_analytics = collect(range(1, 12))->map(function ($month) use ($likes_counts) {
                return [
                    'month'       => Carbon::create()->month($month)->format('M'),
                    'total_likes' => $likes_counts->get($month, 0),
                ];
            });
            // dislikes_analytics
            $dislikes_counts = DB::table('disliked_videos')
                ->whereIn('video_id', $videoIds)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total_disliked'))
                ->whereYear('created_at', $now->year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->pluck('total_disliked', 'month');

            $dislikes_analytics = collect(range(1, 12))->map(function ($month) use ($dislikes_counts) {
                return [
                    'month'          => Carbon::create()->month($month)->format('M'),
                    'total_dislikes' => $dislikes_counts->get($month, 0),
                ];
            });
        }
        if ($request->type === 'custom') {
            $month       = Carbon::createFromFormat('M', $request->month)->month;
            $year        = $request->year ?? now()->year;
            $date        = Carbon::createFromDate($year, $month, 1);
            $daysInMonth = $date->daysInMonth;

            // views_analytics
            $views_counts = DB::table('watch_histories')
                ->whereIn('video_id', $videoIds)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total_watch'))
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('total_watch', 'day');

            $views_analytics = collect(range(1, $daysInMonth))->map(function ($day) use ($views_counts) {
                return [
                    'day'         => $day,
                    'total_watch' => $views_counts->get($day, 0),
                ];
            });
            // likes_analytics
            $likes_counts = DB::table('liked_videos')
                ->whereIn('video_id', $videoIds)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total_liked'))
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('total_liked', 'day');

            $likes_analytics = collect(range(1, $daysInMonth))->map(function ($day) use ($likes_counts) {
                return [
                    'day'         => $day,
                    'total_liked' => $likes_counts->get($day, 0),
                ];
            });
            // dislikes_analytics
            $dislikes_counts = DB::table('disliked_videos')
                ->whereIn('video_id', $videoIds)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total_disliked'))
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('total_disliked', 'day');

            $dislikes_analytics = collect(range(1, $daysInMonth))->map(function ($day) use ($dislikes_counts) {
                return [
                    'day'            => $day,
                    'total_dislikes' => $dislikes_counts->get($day, 0),
                ];
            });

        }

        $data = [
            'user'      => [
                'channel_name' => Auth::user()->channel_name,
                'cover_image'  => Auth::user()->cover_image,
                'avatar'       => Auth::user()->avatar,
                'bio'          => Auth::user()->bio,
                'services'     => Auth::user()->services,
                'locations'    => Auth::user()->locations,
            ],
            'views'     => Video::where('user_id', Auth::id())->sum('views'),
            'videos'    => Video::where('user_id', Auth::id())->count(),
            'likes'     => LikedVideo::whereIn('video_id', $videoIds)->count(),
            'analytics' => [
                'views'    => $views_analytics,
                'likes'    => $likes_analytics,
                'dislikes' => $dislikes_analytics,
            ],
        ];
        return response()->json([
            'status'  => true,
            'message' => 'Dashboard data retreived successfully.',
            'data'    => $data,
        ], 200);
    }
}
