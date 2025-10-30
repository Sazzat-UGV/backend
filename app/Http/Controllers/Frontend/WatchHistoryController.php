<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\WatchHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WatchHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $watch_histories = WatchHistory::with('video:id,user_id,title,description,thumbnail,views,created_at', 'video.user:id,channel_name')
            ->where('user_id', Auth::id())
            ->latest('id');

        if ($request->search) {
            $watch_histories = $watch_histories->whereHas('video', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            });
        }
        $watch_histories = $watch_histories->paginate($request->per_page ?? 10);

        $watch_histories->getCollection()->transform(function ($history) {
            $history->video->views_count = $this->formatNumber($history->video->views);
            $history->video->upload_time = Carbon::parse($history->video->created_at)->diffForHumans();
            return $history;
        });

        return response()->json([
            'status' => true,
            'message' => 'Watch history retrieved successfully.',
            'data' => $watch_histories,
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
            'video_id' => 'required|numeric|exists:videos,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();
        $video = Video::find($request->video_id);
        $video->increment('views');

        if ($user->pause_watch_history == '0') {
            $watchHistoryExists = WatchHistory::where('user_id', $user->id)
                ->where('video_id', $video->id)
                ->first();
            if ($watchHistoryExists) {
                $watchHistoryExists->delete();
            }
            $watchHistory = WatchHistory::create([
                'user_id' => $user->id,
                'video_id' => $video->id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Watch history added successfully.',
                'data' => $watchHistory,
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => "Watch history is paused, so new entries won't be added.",
            'data' => null,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $watch_history = WatchHistory::findOrFail($id);
            $watch_history->delete();

            return response()->json([
                'status' => true,
                'message' => 'Single watch history deleted successfully.',
                'data' => $watch_history,
            ], 200);
        } catch (Exception $e) {
            Log::error('Single watch history deleted error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'data not found',
            ]);
        }
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
    public function pausePlayWatchHistory()
    {
        $user = Auth::user();
        $user->pause_watch_history = $user->pause_watch_history == '0' ? '1' : '0';
        $user->save();

        return response()->json([
            'status' => true,
            'pause_watch_history' => (bool) $user->pause_watch_history,
            'message' => $user->pause_watch_history == '0'
                ? 'Watch history is now active.'
                : 'Watch history is paused.',
        ], 200);
    }


    public function bulkDeleteWatchHistory()
    {
        try {
            $deletedRows = WatchHistory::where('user_id', Auth::id())->delete();
            return response()->json([
                'status' => true,
                'message' => 'Bulk watch history deleted successfully.',
            ], 200);

        } catch (Exception $e) {
            Log::error('Bulk watch history delete error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while deleting.',
            ], 500);
        }
    }

}
