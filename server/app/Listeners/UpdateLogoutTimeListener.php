<?php

namespace App\Listeners;

use App\Events\UserLoggedOutEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UpdateLogoutTimeListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLoggedOutEvent $event): void
    {
        DB::table('user_accounts')->where('id', $event->userId)->update([
            'logout_time' => now(),
        ]);
    }
}
