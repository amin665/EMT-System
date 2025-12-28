<?php

use Illuminate\Support\Facades\Schedule;

// Change ->hourly() to ->everyMinute() for testing
Schedule::command('reminders:send')->everyMinute();