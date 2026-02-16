<?php

namespace App\Jobs;

use App\Models\Recipe;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Config;

class TranslateRecipeFields implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(
        public Recipe $recipe,
        public string $sourceLocale,
    ) {}

    public function handle(): void
    {
        $fields = ['title', 'description', 'ingredients', 'instructions', 'notes', 'servings'];

        foreach (array_keys(Config::get('app.languages')) as $lang) {
            if ($lang === $this->sourceLocale) {
                continue;
            }

            foreach ($fields as $field) {
                $translations = $this->recipe->getTranslations($field);
                $updated = translateMissing($translations, $lang, $this->sourceLocale);
                $this->recipe->setTranslations($field, $updated);
            }
        }

        $this->recipe->saveQuietly();
    }
}
