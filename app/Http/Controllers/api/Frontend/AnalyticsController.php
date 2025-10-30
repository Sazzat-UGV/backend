<?php
namespace App\Http\Controllers\api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DislikedVideo;
use App\Models\LikedVideo;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AnalyticsController extends Controller
{
    public function analytics(Request $request)
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
            $counts      = DB::table('watch_histories')
                ->whereIn('video_id', $videoIds)
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total_watch'))
                ->groupBy(DB::raw('DAY(created_at)'))
                ->pluck('total_watch', 'day');

            $views_analytics = collect(range(1, $daysInMonth))->map(function ($day) use ($counts) {
                return [
                    'day'         => $day,
                    'total_watch' => $counts->get($day, 0),
                ];
            });

            $total_watch_count = $counts->sum();

            $total_like_count = LikedVideo::whereIn('video_id', $videoIds)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $total_dislike_count = DislikedVideo::whereIn('video_id', $videoIds)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $message = 'Analytics retrieved successfully for ' . now()->format('F') . ' ' . now()->format('Y') . '.';
        }
        if ($request->type === 'yearly') {
            $counts = DB::table('watch_histories')
                ->whereIn('video_id', $videoIds)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total_watch'))
                ->whereYear('created_at', $now->year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->pluck('total_watch', 'month');

            $views_analytics = collect(range(1, 12))->map(function ($month) use ($counts) {
                return [
                    'month'       => Carbon::create()->month($month)->format('M'),
                    'total_watch' => $counts->get($month, 0),
                ];
            });
            $total_watch_count = $counts->sum();
            $total_like_count  = LikedVideo::whereIn('video_id', $videoIds)
                ->whereYear('created_at', now()->year)
                ->count();
            $total_dislike_count = DislikedVideo::whereIn('video_id', $videoIds)
                ->whereYear('created_at', now()->year)
                ->count();
            $message = 'Analytics retrieved successfully for ' . now()->format('Y') . '.';
        }
        if ($request->type === 'custom') {
            $month       = Carbon::createFromFormat('M', $request->month)->month;
            $year        = $request->year ?? now()->year;
            $date        = Carbon::createFromDate($year, $month, 1);
            $daysInMonth = $date->daysInMonth;

            $counts = DB::table('watch_histories')
                ->whereIn('video_id', $videoIds)
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

            $total_like_count = LikedVideo::whereIn('video_id', $videoIds)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)->count();

            $total_dislike_count = DislikedVideo::whereIn('video_id', $videoIds)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)->count();
            $message = 'Analytics retrieved successfully for ' . $request->month . ' ' . $year . '.';
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
}
