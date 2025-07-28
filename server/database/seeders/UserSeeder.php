<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->createUser(
            account: 'duongpq@hblab.vn',
            name: 'Phan Quang Dương',
            username: 'duongpq.0811'
        );

        $this->createUser(
            account: 'phanquangduong2002@gmail.com',
            name: 'Quang Dương',
            username: 'quangduong.phan.0811'
        );
    }

    private function createUser(string $account, string $name, string $username): void
    {
        $userId = DB::table('user_accounts')->insertGetId([
            'account'      => $account,
            'password'     => Hash::make('123456'),
            'login_time'   => Carbon::now()->subHours(2),
            'logout_time'  => Carbon::now()->subHour(),
            'login_ip'     => null,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $otp = random_int(100000, 999999);
        $key = $account;
        $keyHash = hash('sha256', $key);

        DB::table('user_verifications')->insert([
            'otp'         => $otp,
            'key'         => $key,
            'key_hash'    => $keyHash,
            'is_verified' => true,
            'is_deleted'  => false,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('user_profiles')->insert([
            'user_account_id' => $userId,
            'name'            => $name,
            'username'        => $username,
            'avatar'          => null,
            'cover_image'     => null,
            'state'           => 1,
            'gender'          => 1,
            'birthday'        => null,
            'mobile'          => null,
            'email'           => $account,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
}
