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
        $user = factory(User::class)->create([
            'email' => 'bugraergin@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
        factory(Profile::class)->create([
            'email' => $user->email,
            'name' => 'Bugra Ergin',
            'user_id' => $user->id,
        ]);
        factory(Profile::class, 30)->create();
    }
}
