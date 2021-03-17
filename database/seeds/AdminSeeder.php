<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
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
                    'facebook' => 'https://www.facebook.com/Bici89/',
                    'telephone' => '0041 (0) 79 692 91 36',
                    'city' => 'Lefkoşa',
                    'instagram' => 'https://www.instagram.com/bicibg/',
                    'twitter' => 'https://twitter.com/BugraBgErgin',
                    'info' => '',
                    'pinterest' => '',
                    'website' => '',
                ]
            ],
            [
                'user' => [
                    'email' => 'burakergin95@gmail.com',
                    'password' => '$2y$10$AkMeLgCxf/3iXVkOXSJrc.MItFMQuetMSAan1IiWxWjx.6131Rm3.',
                ],
                'profile' => [
                    'name' => 'Burak Ergin',
                    'email' => 'burakergin95@gmail.com',
                    'facebook' => 'https://www.facebook.com/burak.ergin4/',
                    'telephone' => '0533 846 76 67',
                    'city' => 'Lefkoşa',
                    'instagram' => 'https://www.instagram.com/burakergin/',
                    'twitter' => 'https://twitter.com/burakk_ergin',
                    'info' => '',
                    'pinterest' => '',
                    'website' => '',
                ]
            ]
        ];

        foreach ($admins as $admin) {
            $user = factory(\App\Models\User::class)->create($admin['user']);
            $admin['profile']['user_id'] = $user->id;
            factory(\App\Models\Profile::class)->create($admin['profile']);
        }
    }
}
