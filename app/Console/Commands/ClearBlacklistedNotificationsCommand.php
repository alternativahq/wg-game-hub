<?php

namespace App\Console\Commands;

use App\Models\BlacklistedNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ClearBlacklistedNotificationsCommand extends Command
{
    protected $signature = 'wodo:clear-blacklisted-notifications';

    protected $description = 'Clear blacklisted notifications table';

    public function handle()
    {
        BlacklistedNotification::truncate();
    }
}
