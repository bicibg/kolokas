<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\RecipeImage;
use App\Models\User;
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
        $users = User::all();
        foreach ($users as $user) {
            $recipes = Recipe::factory()->count(random_int(1, 10))->create([
                'user_id' => $user->id,
            ]);

            foreach ($recipes as $recipe) {
                $firstImageUrl = null;
                for ($x = 0; $x < random_int(1, 5); $x++) {
                    $image = RecipeImage::factory()->create([
                        'recipe_id' => $recipe->id
                    ]);
                    if ($x === 0) {
                        $firstImageUrl = $image->getRawOriginal('url');
                    }
                }
                if ($firstImageUrl) {
                    Recipe::withoutTimestamps(fn () =>
                        Recipe::where('id', $recipe->id)->update(['main_image' => $firstImageUrl])
                    );
                }
                foreach (Category::all()->random(rand(1, 4)) as $category) {
                    $recipe->categories()->attach($category);
                }
            }
        }
    }
}
