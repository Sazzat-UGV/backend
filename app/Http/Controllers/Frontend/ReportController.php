<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ReportMail;
use App\Models\Appeal;
use App\Models\Report;
use App\Models\User;
use App\Models\Video;
use App\Notifications\NewReportNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;

class ReportController extends Controller
{
    public function addReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_id' => 'required|exists:videos,id',
            'reason'   => 'required|in:Sexual content,Violent or repulsive content,Hateful or abusive content,Harassment or bullying,Harmful or dangerous acts,Misinformation,Child abuse,Promotes terrorism,Spam or misleading,Legal issue,Captions issue',
            'issue'    => 'required|string',
        ]);

        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $report = Report::create([
            'user_id'  => Auth::user()->id,
            'video_id' => $request->video_id,
            'reason'   => $request->reason,
            'issue'    => $request->issue,
        ]);
        // notification send
        $admin = User::find(1);
        if ($admin) {
            $admin->notify(new NewReportNotification($report->id));
        }
        return response()->json([
            'status'  => true,
            'message' => 'Report created successfully.',
            'data'    => $report,
        ], 200);
    }

    public function getAdminReport(Request $request)
    {
        $reports = Report::with([
            'user:id,name,avatar',
            'video' => function ($query) {
                $query->select('id', 'user_id');
            },
            'video.user:id,channel_name,avatar',
        ]);
        if ($request->search) {
            $reports = $reports->where(function ($q) use ($request) {
                $q->where('reason', 'LIKE', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'LIKE', '%' . $request->search . '%');
                    })
                    ->orWhereHas('video.user', function ($q) use ($request) {
                        $q->where('channel_name', 'LIKE', '%' . $request->search . '%');
                    });
            });
        }
        $reports = $reports->whereNotNull('reason')->whereNotNull('issue')->latest('id')->paginate($request->per_page ?? 10);
        $data    = [
            'total_appeals' => Appeal::count(),
            'reports'       => $reports,
        ];
        return response()->json([
            'status'  => true,
            'message' => 'Report retreived successfully.',
            'data'    => $data,
        ], 200);
    }

    public function getReportDetail($id)
    {
        try {
            $report = Report::with([
                'video:id,user_id,type,thumbnail,video,link,title,description,views,created_at',
                'video.user:id,channel_name,avatar',
            ])->findOrFail($id);

            $video                                   = $report->video;
            $report->video->views_count_formatted    = Number::abbreviate($report->video->views);
            $report->video->likes_count_formatted    = $video ? Number::abbreviate($video->likes()->count()) : 0;
            $report->video->dislikes_count_formatted = $video ? Number::abbreviate($video->dislikes()->count()) : 0;
            $report->video->comments_count_formatted = $video ? Number::abbreviate($video->commentReplies()->count()) : 0;
            $report->video->created_at_format        = $report->video->created_at->diffForHumans();
            return response()->json([
                'status'  => true,
                'message' => 'Report detail retreived successfully.',
                'data'    => $report,
            ], 200);
        } catch (Exception $e) {
            Log::error('Report detail error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }

    public function takeReportAction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'action_name'  => 'required|in:Suspend for 7 days,Suspend for 30 days,Give a warning,Suspend permanently',
            'action_issue' => 'required|string',
            'make_new'     => 'nullable|in:yes,no',
            'video_id'     => 'required_if:make_new,yes',
        ]);

        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        try {
            if ($request->make_new == 'yes') {
                $report = Report::create([
                    'user_id'  => Auth::user()->id,
                    'video_id' => $request->video_id,
                ]);
                $report = Report::findOrFail($report->id);
            } else {
                $report = Report::findOrFail($id);
            }
            $video           = Video::findOrFail($report->video_id);
            $video_publisher = User::where('id', $video->user_id)->first();
            if ($request->action_name == 'Suspend for 7 days') {
                $video->is_suspend     = true;
                $video->visibility     = 'Only me';
                $video->suspend_reason = 'Suspend for 7 days';
                $video->suspend_until  = now()->addDays(7);
                $video->save();
                $data = [
                    'video_publisher_name' => $video_publisher->name,
                    'emailTitle'           => "Your Video Has Been Suspended for 7 Days",
                    'actionMessage'        => "Your video '<strong>{$video->title}</strong>' has been suspended for <strong>7 days</strong> because it violated our content rules. During this period, the video will not be visible to others. Please check our <a href='#'>Community Guidelines</a> and update your content so that it follows the rules. If you break the rules again, we may suspend your content for a longer time or remove it permanently.<br><br>Thank you for your attention.",
                ];
                Mail::to($video_publisher->email)->send(new ReportMail($data));

            } elseif ($request->action_name == 'Suspend for 30 days') {
                $video->is_suspend     = true;
                $video->visibility     = 'Only me';
                $video->suspend_reason = 'Suspend for 30 days';
                $video->suspend_until  = now()->addDays(30);
                $video->save();
                $data = [
                    'video_publisher_name' => $video_publisher->name,
                    'emailTitle'           => "Your Video Has Been Suspended for 30 Days",
                    'actionMessage'        => "Your video '<strong>{$video->title}</strong>' has been suspended for <strong>30 days</strong> because you broke our content guidelines multiple times. This is a serious action. Please take time to read our <a href='#'>Community Guidelines</a> and follow them properly. Otherwise, your account or content could be removed permanently.<br><br>Thanks for understanding.",
                ];
                Mail::to($video_publisher->email)->send(new ReportMail($data));

            } elseif ($request->action_name == 'Give a warning') {
                $video->is_suspend     = false;
                $video->suspend_reason = null;
                $video->suspend_until  = null;
                $video->save();
                $data = [
                    'video_publisher_name' => $video_publisher->name,
                    'emailTitle'           => "Problem Found in Your Video",
                    'actionMessage'        => "We found an issue in your video '<strong>{$video->title}</strong>'. This is just a warning for now. Please fix your content to match our <a href='#'>Community Guidelines</a>. If you don’t fix it or break the rules again, we may suspend or remove your video in the future.<br><br>Stay safe and follow the rules.",
                ];
                Mail::to($video_publisher->email)->send(new ReportMail($data));

            } elseif ($request->action_name == 'Suspend permanently') {
                $video->is_suspend     = true;
                $video->suspend_reason = 'Suspend permanently';
                $video->visibility     = 'Only me';
                $video->suspend_until  = null;
                $video->save();
                $data = [
                    'video_publisher_name' => $video_publisher->name,
                    'emailTitle'           => "Your Video Has Been Permanently Suspend",
                    'actionMessage'        => "Unfortunately, your video '<strong>{$video->title}</strong>' has been <strong>permanently Suspend</strong> because it seriously violated our rules, or you broke the rules many times. This is a final action.<br><br>If you think this was a mistake, please contact our support team within <strong>7 days</strong>.<br><br>Check our <a href='#'>Community Guidelines</a> for more details.<br><br>Thank you.",
                ];
                Mail::to($video_publisher->email)->send(new ReportMail($data));
            }
            $report->update([
                'action_name'  => $request->action_name,
                'action_issue' => $request->action_issue,
            ]);
            return response()->json([
                'status'  => true,
                'message' => 'Take report action as ' . $request->action_name . '.',
                'data'    => $report,
            ], 200);
        } catch (Exception $e) {
            Log::error('Report data error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }
    public function reportDelete($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Report deleted successfully.',
                'data'    => $report,
            ], 200);
        } catch (Exception $e) {
            Log::error('Report delete error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }

    public function getReport(Request $request)
    {
        $search  = $request->input('search');
        $reports = Report::with('video:id,user_id,type,title,description,thumbnail,video,link,suspend_until,suspend_reason')->withCount('appeal')
            ->whereHas('video', function ($query) use ($search) {
                $query->where('user_id', Auth::id());

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
                }
            })
            ->wherehas('video', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->whereNotNull('action_name')->whereNot('action_name', 'Give a warning')->latest('id')
            ->paginate($request->per_page ?? 10);
        $reports->getCollection()->transform(function ($report) {
            if (in_array($report->video->suspend_reason, ['Suspend for 7 days', 'Suspend for 30 days'])) {
                $report->action_result = 'This video won’t go anyone feeds until ' . Carbon::parse($report->video->suspend_until)->format('jS F, Y');
            } elseif ($report->video->suspend_reason == 'Suspend permanently') {
                $report->action_result = 'This video will no longer goes anyone feeds.';
            }
            return $report;
        });
        return response()->json([
            'status'  => true,
            'message' => 'Report retreived successfully.',
            'data'    => $reports,
        ], 200);
    }
}
