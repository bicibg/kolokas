<?php

namespace App\Services;

use App\Models\Recipe;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Store an uploaded file as a recipe image.
     * Returns the relative storage path (e.g. 'images/recipes/filename.jpg').
     */
    public function storeUploadedImage(UploadedFile $file): ?string
    {
        $filename = Str::slug(uniqid() . '_' . $file->getClientOriginalName());

        if ($file->storeAs('public/images/recipes/', $filename)) {
            return 'images/recipes/' . $filename;
        }

        return null;
    }

    /**
     * Store multiple uploaded files as recipe images and attach to recipe.
     */
    public function storeRecipeImages(Recipe $recipe, array $files): void
    {
        foreach ($files as $file) {
            $path = $this->storeUploadedImage($file);
            if ($path) {
                $recipe->images()->create(['url' => $path]);
            }
        }
    }

    /**
     * Delete a recipe image file from storage.
     */
    public function deleteImage(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    /**
     * Delete recipe images by IDs and remove their files.
     */
    public function deleteRecipeImagesByIds(Recipe $recipe, array $imageIds): void
    {
        $images = $recipe->images()->whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            Storage::delete('public/' . $image->getAttributes()['url']);
            $image->delete();
        }
    }
}
