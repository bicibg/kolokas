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
        $admins = [
            [
                'user' => [
                    'email' => 'bugraergin@gmail.com',
                    'password' => bcrypt('123456789'),
                ],
                'profile' => [
                    'name' => 'Bugra Ergin',
                    'email' => 'bugraergin@gmail.com',
                ]
            ],
            [
                'user' => [
                    'email' => 'burakergin95@gmail.com',
                    'password' => '$2y$10$AkMeLgCxf/3iXVkOXSJrc.MItFMQuetMSAan1IiWxWjx.6131Rm3.',
                ],
                'profile' => [
                    'name' => 'Bugra Ergin',
                    'email' => 'bugraergin@gmail.com',
                ]
            ]
        ];

        foreach ($admins as $admin) {
            $user = factory(User::class)->create($admin['user']);
            $admin['profile']['user_id'] = $user->id;
            factory(Profile::class)->create($admin['profile']);
        }

        factory(Profile::class, 30)->create();
    }
}
