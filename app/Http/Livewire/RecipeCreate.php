<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class RecipeCreate extends Component
{
    use WithFileUploads;

    public $tab = 'description';
    public $langTab;
    /**
     * @var $locale
     */
    public $locale;
    public $langs;
    public $tab1Check = false;
    public $tab2Check = false;
    public $tab3Check = false;
    public $tab4Check = false;
    public $canSubmit = false;

    //description
    public $title = [
        'tr' => '',
        'en' => '',
        'el' => '',
    ];
    public $description = [
        'tr' => '',
        'en' => '',
        'el' => '',
    ];

    //media
    public $main_image;
    public $images = [];

    //meta
    public $categories = [];
    public $prep_time = null;
    public $cook_time = null;
    public $servings = [
        'tr' => '',
        'en' => '',
        'el' => '',
    ];

    //recipe
    public $ingredients = [
        'tr' => '',
        'en' => '',
        'el' => '',
    ];

    public $instructions = [
        'tr' => '',
        'en' => '',
        'el' => '',
    ];

    public $notes = [
        'tr' => '',
        'en' => '',
        'el' => '',
    ];

    public $agreement = false;

    public function mount()
    {
        $langInUse = app()->getLocale();
        $this->locale = $langInUse;
        $this->langTab = $this->locale;
        $langs = Config::get('app.languages');
        unset($langs[$langInUse]);
        $this->langs = array_keys($langs);
    }

    public function hydrate()
    {
        app()->setLocale($this->locale);
        $this->tab1Check = !empty($this->title[$this->locale]);
        $this->tab2Check = !empty($this->main_image);
        $this->tab3Check = !empty($this->categories) && !empty($this->prep_time) && !empty($this->cook_time) && !empty($this->servings);
        $this->tab4Check = !empty($this->instructions[$this->locale]) && !empty($this->ingredients[$this->locale]);
        $this->canSubmit = $this->tab1Check && $this->tab2Check && $this->tab3Check && $this->tab4Check && $this->agreement;

        if ($this->images) {
            $this->validate(['images' => "required|array|max:5"]);
        }
    }

    public function render()
    {
        return view('livewire.recipe-create');
    }

    protected function rules() {
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
            'prep_time' => 'integer',
            'cook_time' => 'integer',
            'servings.' . $this->locale => 'required|max:64',
            'notes.' . $this->locale => 'max:4000',
            'agreement' => 'accepted',
            'main_image' => 'required|image|mimes:jpeg,jpg,png',
        ];
    }

    public function submit()
    {
        $this->validate();

        foreach ($this->title as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && !empty($langs[$lang])) {
                $this->title[$lang] = translate($this->title[$this->locale], $lang);
            }
        }

        foreach ($this->description as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && !empty($langs[$lang])) {
                $this->description[$lang] = translate($this->description[$this->locale], $lang);
            }
        }

        foreach ($this->instructions as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && !empty($langs[$lang])) {
                $this->instructions[$lang] = translate($this->instructions[$this->locale], $lang);
            }
        }

        foreach ($this->ingredients as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && !empty($langs[$lang])) {
                $this->ingredients[$lang] = translate($this->ingredients[$this->locale], $lang);
            }
        }

        foreach ($this->notes as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && !empty($langs[$lang])) {
                $this->notes[$lang] = translate($this->notes[$this->locale], $lang);
            }
        }

        foreach ($this->servings as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && !empty($langs[$lang])) {
                $this->servings[$lang] = translate($this->servings[$this->locale], $lang);
            }
        }

        DB::transaction(function () {
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
            ]);

            foreach ($this->categories as $category) {
                $recipe->categories()->attach($category);
            }

            $allowedfileExtension = ['jpg', 'jpeg', 'png'];
            $mainPhoto = $this->main_image;
            //main photo
            $filename = $recipe->id . '_' . $mainPhoto->getClientOriginalName() . '_' . uniqid();
            $extension = $mainPhoto->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);
            if ($check) {
                $filename .= '.' . $extension;
//                if (Storage::putFileAs('public/images/recipes/', $mainPhoto, $filename)) {
                try {
                    if ($mainPhoto->storeAs('public/images/recipes/', $filename)) {
                        $recipe->images()->create([
                            'url' => 'images/recipes/' . $filename,
                            'main' => 1
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Error while uploading image. ' . $e->getMessage());
                    Log::error('Error while uploading image. ' . $e->getTraceAsString());
                }
            }

            // other photos
            if (count($this->images)) {
                foreach ($this->images as $file) {
                    $filename = $recipe->id . '_' . $file->getClientOriginalName() . '_' . uniqid();
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                    if ($check) {
                        $filename .= '.' . $extension;
//                        if (Storage::putFileAs('public/images/recipes/', $file, $filename)) {

                        try {
                            if ($file->storeAs('public/images/recipes/', $filename)) {
                                $recipe->images()->create([
                                    'url' => 'images/recipes/' . $filename,
                                    'main' => 0
                                ]);
                            }
                        } catch (\Exception $e) {
                            Log::error('Error while uploading image. ' . $e->getMessage());
                            Log::error('Error while uploading image. ' . $e->getTraceAsString());
                        }
                    }
                }
            }
        });
        return redirect()->to(route('recipe.my-index'))->with([
            'flash' => __('messages.recipe.submitted')
        ]);
    }

    public function dehydrate()
    {
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
        $this->langTab = $this->locale;
    }

    public function switchLangTab($langTab)
    {
        $this->langTab = $langTab;
    }
}
