<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    public function update(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id || $this->isAdmin($user);
    }

    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id || $this->isAdmin($user);
    }

    private function isAdmin(User $user): bool
    {
        return in_array($user->email, [
            'bugraergin@gmail.com',
            'burakergin95@gmail.com',
        ]);
    }
}
