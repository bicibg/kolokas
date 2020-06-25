<?php

use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 0;
        foreach (\App\User::all() as $user) {
            $recipes = factory(\App\Recipe::class, random_int(1, 10))->create([
                'user_id' => $user->id
            ]);
            $count += $recipes->count();
            foreach($recipes as $recipe) {
                factory(\App\RecipeImage::class)->create([
                    'recipe_id' => $recipe->id
                ]);
            }
        }
    }
}
