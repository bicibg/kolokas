<?php

namespace App\Livewire;

use App\Livewire\Concerns\HandlesRecipeForm;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class RecipeEdit extends Component
{
    use WithFileUploads, HandlesRecipeForm;

    public $recipe;
    public $existing_images = [];
    public $existing_main_image;

    public function mount(Recipe $recipe)
    {
        $this->recipe = $recipe;
        $this->initLocale();

        $this->title = array_merge($this->title, $recipe->getTranslations('title'));
        $this->description = array_merge($this->description, $recipe->getTranslations('description'));
        $this->instructions = array_merge($this->instructions, $recipe->getTranslations('instructions'));
        $this->ingredients = array_merge($this->ingredients, $recipe->getTranslations('ingredients'));
        $this->notes = array_merge($this->notes, $recipe->getTranslations('notes'));
        $this->servings = array_merge($this->servings, $recipe->getTranslations('servings'));
        $this->categories = $recipe->categories()->pluck('categories.id');
        $this->prep_time = $recipe->prep_time;
        $this->cook_time = $recipe->cook_time;

        $this->existing_main_image = $this->recipe->main_image;
        $this->existing_images = $recipe->images()->pluck('id')->toArray();
        foreach ($this->existing_images as $key => $value) {
            $this->existing_images[$key] = (string) $value;
        }
        $toBeDeleted = $this->recipe->images()->pluck('id')->diff(collect($this->existing_images));

        $this->maxNewImages = 5 - ($this->recipe->images()->count() - count($toBeDeleted));

        $this->tab1Check = !empty($this->title[$this->locale]);
        $this->tab2Check = !empty($this->existing_main_image);
        $this->tab3Check = !empty($this->categories) && !empty($this->servings[$this->locale]);
        $this->tab4Check = !empty($this->instructions[$this->locale]) && !empty($this->ingredients[$this->locale]);
        $this->canSubmit = $this->tab1Check && $this->tab2Check && $this->tab3Check && $this->tab4Check && $this->agreement;
    }

    public function updated()
    {
        $this->updateTabChecks();
        $this->tab2Check = !empty($this->main_image) || !empty($this->existing_main_image);
        $this->canSubmit = $this->tab1Check && $this->tab2Check && $this->tab3Check && $this->tab4Check && $this->agreement;

        $toBeDeleted = $this->recipe->images()->pluck('id')->diff(collect($this->existing_images));
        $this->maxNewImages = 5 - ($this->recipe->images()->count() - count($toBeDeleted));
    }

    public function submit()
    {
        if (auth()->user()->cannot('update', $this->recipe)) {
            session(['flash-error' => __('trx.recipe_edit_not_authorized')]);
            return redirect(route('home'));
        }

        $this->validate();

        DB::transaction(function () {
            $data = [
                'title' => $this->title,
                'description' => $this->description,
                'ingredients' => $this->ingredients,
                'instructions' => $this->instructions,
                'notes' => $this->notes,
                'prep_time' => $this->prep_time,
                'cook_time' => $this->cook_time,
                'servings' => $this->servings,
                'main_image' => $this->existing_main_image,
            ];

            $mainImagePath = $this->storeMainImage();
            if ($mainImagePath) {
                if (Storage::disk('public')->exists($this->existing_main_image)) {
                    Storage::delete('public/' . $this->existing_main_image);
                }
                $data['main_image'] = $mainImagePath;
            }

            $toBeDeleted = $this->recipe->images()->pluck('id')->diff(collect($this->existing_images));
            if ($toBeDeleted->count()) {
                $deletes = $this->recipe->images()->whereIn('id', $toBeDeleted->toArray())->get();
                foreach ($deletes as $delete) {
                    Storage::delete('public/' . $delete->getAttributes()['url']);
                    $delete->delete();
                }
            }

            $this->storeRecipeImages($this->recipe);
            $this->recipe->update($data);
            $this->recipe->categories()->sync($this->categories);
        });

        session()->flash('message', __('trx.recipe_updated'));

        return redirect()->to(route('recipe.my-index'));
    }

    public function toggleExistingImage($id)
    {
        if (in_array($id, $this->existing_images)) {
            $pos = array_search($id, $this->existing_images);
            unset($this->existing_images[$pos]);
        } else {
            $this->existing_images[] = $id;
        }
    }

    protected function rules()
    {
        $rules = $this->baseRules();
        $rules['images'] = 'array|max:' . $this->maxNewImages;

        if (!$this->existing_main_image) {
            $rules['main_image'] = 'required|image|mimes:jpeg,jpg,png';
        }

        return $rules;
    }
}
