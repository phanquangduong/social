<?php

namespace App\Listeners;

use App\Events\UserLoggedInEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UpdateLoginInfoListener
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
    public function handle(UserLoggedInEvent $event): void
    {
        DB::table('user_accounts')->where('id', $event->userId)->update([
            'login_time' => now(),
            'login_ip' => $event->ip,
        ]);
    }
}
