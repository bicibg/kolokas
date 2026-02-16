<?php

namespace App\Livewire;

use App\Livewire\Concerns\HandlesRecipeForm;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class RecipeCreate extends Component
{
    use WithFileUploads, HandlesRecipeForm;

    public function mount()
    {
        $this->initLocale();
    }

    public function updated()
    {
        $this->updateTabChecks();
        $this->tab2Check = !empty($this->main_image);
        $this->canSubmit = $this->tab1Check && $this->tab2Check && $this->tab3Check && $this->tab4Check && $this->agreement;

        if ($this->images) {
            $this->validate(['images' => 'required|array|max:5']);
        }
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $mainImagePath = $this->storeMainImage();

            if ($mainImagePath) {
                $recipe = Recipe::create([
                    'title' => $this->title,
                    'description' => $this->description,
                    'ingredients' => $this->ingredients,
                    'instructions' => $this->instructions,
                    'notes' => $this->notes,
                    'prep_time' => $this->prep_time,
                    'cook_time' => $this->cook_time,
                    'servings' => $this->servings,
                    'user_id' => auth()->id(),
                    'main_image' => $mainImagePath,
                ]);

                $recipe->categories()->sync($this->categories);
                $this->storeRecipeImages($recipe);
            }
        });

        session()->flash('message', __('trx.recipe_submitted_message'));

        return redirect()->to(route('recipe.my-index'));
    }

    protected function rules()
    {
        $rules = $this->baseRules();
        $rules['main_image'] = 'required|image|mimes:jpeg,jpg,png';
        return $rules;
    }
}
