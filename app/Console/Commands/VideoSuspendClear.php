<?php
namespace App\Console\Commands;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VideoSuspendClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:video-suspend-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove expired video suspensions and update their status.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $expiredSuspensionVideos = Video::where('is_suspend', true)
            ->whereNot('suspend_reason', 'Suspend permanently')
            ->whereDate('suspend_until', '<=', Carbon::today())
            ->get();

        foreach ($expiredSuspensionVideos as $video) {
            $video->is_suspend     = false;
            $video->suspend_reason = null;
            $video->suspend_until  = null;
            $video->visibility  = 'Everyone';
            $video->save();

            $this->info("Unsuspend video: {$video->title} (ID: {$video->id})");
        }

        $this->info('Expired suspensions cleared successfully.');
    }
}
