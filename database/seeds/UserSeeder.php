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
        $user = factory(\App\Models\User::class)->create([
            'email' => 'bugraergin@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
        factory(\App\Models\Profile::class)->create([
            'email' => $user->email,
            'name' => 'Bugra Ergin',
            'user_id' => $user->id,
        ]);
        factory(\App\Models\Profile::class, 30)->create();
    }
}
