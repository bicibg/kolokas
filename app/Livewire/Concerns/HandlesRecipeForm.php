<?php

namespace App\Livewire\Concerns;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait HandlesRecipeForm
{
    public $tab = 'description';
    public $langTab;
    public $locale;
    public $langs;
    public $tab1Check = false;
    public $tab2Check = false;
    public $tab3Check = false;
    public $tab4Check = false;
    public $canSubmit = false;
    public $maxNewImages = 5;

    public $title = ['tr' => '', 'en' => '', 'el' => ''];
    public $description = ['tr' => '', 'en' => '', 'el' => ''];
    public $main_image;
    public $images = [];
    public $categories = [];
    public $prep_time = null;
    public $cook_time = null;
    public $servings = ['tr' => '', 'en' => '', 'el' => ''];
    public $ingredients = ['tr' => '', 'en' => '', 'el' => ''];
    public $instructions = ['tr' => '', 'en' => '', 'el' => ''];
    public $notes = ['tr' => '', 'en' => '', 'el' => ''];
    public $agreement = false;

    protected function initLocale(): void
    {
        $langInUse = app()->getLocale();
        $this->locale = $langInUse;
        $this->langTab = $this->locale;
        $langs = Config::get('app.languages');
        unset($langs[$langInUse]);
        $this->langs = array_keys($langs);
    }

    public function switchTab($tab): void
    {
        $this->tab = $tab;
        $this->langTab = $this->locale;
    }

    public function switchLangTab($langTab): void
    {
        $this->langTab = $langTab;
    }

    protected function updateTabChecks(): void
    {
        app()->setLocale($this->locale);
        $this->tab1Check = !empty($this->title[$this->locale]);
        $this->tab3Check = !empty($this->categories) && !empty($this->servings[$this->locale]);
        $this->tab4Check = !empty($this->instructions[$this->locale]) && !empty($this->ingredients[$this->locale]);
    }

    protected function baseRules(): array
    {
        return [
            'title.' . $this->locale => [
                'bail',
                'required',
                Rule::unique('recipes', 'title')->where(function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
            ],
            'description.' . $this->locale => 'max:4000',
            'categories' => 'required|array',
            'ingredients.' . $this->locale => 'required',
            'instructions.' . $this->locale => 'required',
            'prep_time' => 'integer|nullable',
            'cook_time' => 'integer|nullable',
            'servings.' . $this->locale => 'required|max:64',
            'notes.' . $this->locale => 'max:4000',
            'agreement' => 'accepted',
            'images.*' => 'image|mimes:jpeg,jpg,png',
        ];
    }

    protected function storeRecipeImages($recipe): void
    {
        foreach ($this->images as $file) {
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $filename = Str::slug($filename);
            if ($file->storeAs('public/images/recipes/', $filename)) {
                $recipe->images()->create([
                    'url' => 'images/recipes/' . $filename,
                ]);
            }
        }
    }

    protected function storeMainImage(): ?string
    {
        if (!$this->main_image) {
            return null;
        }

        $filename = uniqid() . '_' . $this->main_image->getClientOriginalName();
        $filename = Str::slug($filename);

        if ($this->main_image->storeAs('public/images/recipes/', $filename)) {
            return 'images/recipes/' . $filename;
        }

        return null;
    }

    public function render()
    {
        return view('livewire.recipe-create');
    }
}
