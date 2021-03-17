<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersWithNoProfiles = User::has('profile', '<', 1)->get();
        foreach ($usersWithNoProfiles as $user) {
            $admin['profile']['user_id'] = $user->id;
            factory(Profile::class)->create($admin['profile']);
        }

        factory(Profile::class, 30)->create();
    }
}
