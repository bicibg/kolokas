<?php

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
        $user = factory(\App\User::class)->create([
            'email' => 'bugraergin@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
        factory(\App\Profile::class)->create([
            'email' => $user->email,
            'name' => 'Bugra Ergin',
            'user_id' => $user->id,
        ]);
        factory(\App\Profile::class, 10)->create();
    }
}
