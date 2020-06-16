<?php

use Illuminate\Database\Seeder;
use App\User;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

    	$users = [
            [
                'username' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'email_verified_at' => now(),
                'phone' => '+8801818403343',
                'phone_verified_at' => now(),
                'password' => bcrypt('p@$$word'), // password
                'remember_token' => Str::random(10),
                'role' => 'super_admin',
            ],
            [
                'username' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'phone' => '+8801818256316',
                'phone_verified_at' => now(),
                'password' => bcrypt('p@$$word'), // password
                'remember_token' => Str::random(10),
                'role' => 'admin',
            ],
            [
                'username' => 'Donor',
                'email' => 'donor@gmail.com',
                'email_verified_at' => now(),
                'phone' => '+8801818411411',
                'phone_verified_at' => now(),
                'password' => bcrypt('p@$$word'), // password
                'remember_token' => Str::random(10),
                'role' => 'donor',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
