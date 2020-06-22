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
        factory(\App\User::class)->create([
            'name' => 'Bugra Ergin',
            'email' => 'bugraergin@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
        factory(\App\User::class, 10)->create();
    }
}
