<?php

use App\Console\Commands\VideoSuspendClear;
use Illuminate\Support\Facades\Schedule;

Schedule::command(VideoSuspendClear::class)->daily();
