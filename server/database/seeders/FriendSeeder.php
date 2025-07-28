<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FriendSeeder extends Seeder
{
    public function run(): void
    {
        $userA = DB::table('user_accounts')->where('account', 'duongpq@hblab.vn')->value('id');
        $userB = DB::table('user_accounts')->where('account', 'phanquangduong2002@gmail.com')->value('id');

        DB::table('friend_requests')->insert([
            'sender_id'    => $userA,
            'receiver_id'  => $userB,
            'status'       => 'accepted',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::table('friends')->insert([
            [
                'user_id'     => $userA,
                'friend_id'   => $userB,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'user_id'     => $userB,
                'friend_id'   => $userA,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
