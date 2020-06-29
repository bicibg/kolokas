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
        $users = \App\User::all();
        foreach ($users as $user) {
            $recipes = factory(\App\Recipe::class, random_int(1, 10))->create([
                'user_id' => $user->id,
            ]);

            foreach ($recipes as $recipe) {
                for ($x=0; $x < random_int(1, 5); $x++){
                    factory(\App\RecipeImage::class)->create([
                        'main' => $x === 0,
                        'recipe_id' => $recipe->id
                    ]);
                }
                foreach (\App\Category::all()->random(rand(1,4)) as $category) {
                    $recipe->categories()->attach($category);
                }
            }
        }
    }
}
