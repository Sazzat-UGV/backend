<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $startOfWeek  = now()->startOfWeek();
        $endOfWeek    = now()->endOfWeek();

        $days = ["Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri"];

        $total_channels = User::where('role', "USER")->count();
        $total_videos   = Video::count();
        $total_earnings = Transactions::sum('amount');

        // channel_creating_statistics
        $data = User::where('role', 'USER')->select(
            DB::raw('DATE_FORMAT(created_at, "%a") as day'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $channel_creating_statistics = collect();

        foreach ($days as $day) {
            $count = $data->get($day)->count ?? 0;
            $channel_creating_statistics->push([
                'day'   => $day,
                'count' => $count,
            ]);
        }

        // earning_statistics
        $data = Transactions::select(
            DB::raw('DATE_FORMAT(created_at, "%a") as day'),
            DB::raw('SUM(amount) as total')
        )
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        $earning_statistics = collect();
        $weeklyTotal        = 0;

        foreach ($days as $day) {
            $total = $data->get($day)->total ?? 0;

            $earning_statistics->push([
                'day'   => $day,
                'total' => round($total, 2),
            ]);

            $weeklyTotal += $total;
        }

        // video_posting_preferences
        $now         = Carbon::now();
        $daysInMonth = $now->daysInMonth;

        $counts = DB::table('videos')
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total_videos'))
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->pluck('total_videos', 'day');

        $video_posting_preferences = collect(range(1, $daysInMonth))->map(function ($day) use ($counts) {
            return [
                'day'          => $day,
                'total_videos' => $counts->get($day, 0),
            ];
        });

        $data = [
            'total_channels'              => $total_channels,
            'total_videos'                => $total_videos,
            'total_earnings'              => round($total_earnings, 2),
            'channel_creating_statistics' => $channel_creating_statistics,
            'earning_statistics'          => $earning_statistics,
            'video_posting_preferences'   => $video_posting_preferences,
        ];
        return response()->json([
            'status'  => true,
            'message' => 'Dashboard data retreived successfully.',
            'data'    => $data,
        ], 200);
    }
}
