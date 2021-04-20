<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class RecipeEdit extends Component
{
    use WithFileUploads;

    public $recipe;
    public $existing_images = [];
    public $existing_main_image;
    public $tab = 'description';
    public $langTab;
    public $maxNewImages = 5;
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

    public function mount(Recipe $recipe)
    {
        $this->recipe = $recipe;
        $langInUse = app()->getLocale();
        $this->locale = $langInUse;
        $this->langTab = $this->locale;
        $langs = Config::get('app.languages');
        unset($langs[$langInUse]);
        $this->langs = array_keys($langs);

        $this->title = array_merge($this->title, $recipe->getTranslations('title'));
        $this->description = array_merge($this->description, $recipe->getTranslations('description'));
        $this->instructions = array_merge($this->instructions, $recipe->getTranslations('instructions'));
        $this->ingredients = array_merge($this->ingredients, $recipe->getTranslations('ingredients'));
        $this->notes = array_merge($this->notes, $recipe->getTranslations('notes'));
        $this->servings = array_merge($this->servings, $recipe->getTranslations('servings'));
        $this->categories = $recipe->categories()->pluck('categories.id');

        $this->existing_main_image = $this->recipe->main_image;
        $this->existing_images = $recipe->images()->pluck('id')->toArray();
        foreach ($this->existing_images as $key => $value) {
            $this->existing_images[$key] = (string)$value;
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
        app()->setLocale($this->locale);
        $this->tab1Check = !empty($this->title[$this->locale]);
        $this->tab2Check = !empty($this->main_image) || !empty($this->existing_main_image);
        $this->tab3Check = !empty($this->categories) && !empty($this->servings[$this->locale]);
        $this->tab4Check = !empty($this->instructions[$this->locale]) && !empty($this->ingredients[$this->locale]);

        $this->canSubmit = $this->tab1Check && $this->tab2Check && $this->tab3Check && $this->tab4Check && $this->agreement;

        $toBeDeleted = $this->recipe->images()->pluck('id')->diff(collect($this->existing_images));

        $this->maxNewImages = 5 - ($this->recipe->images()->count() - count($toBeDeleted));
    }

    public function render()
    {
        return view('livewire.recipe-create');
    }

    public function submit()
    {
        if (!$this->recipe->author->is(auth()->user())) {
            session(['flash-error' => __('trx.recipe_edit_not_authorized')]);
            return redirect(route('home'));
        }

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
                'main_image' => $this->existing_main_image
            ];
            if ($this->main_image) {
                $filename = uniqid() . '_' . $this->main_image->getClientOriginalName();
                $filename = Str::slug($filename);
                if ($this->main_image->storeAs('public/images/recipes/', $filename)) {
                    if (file_exists($this->existing_main_image)) {
                        Storage::delete($this->existing_main_image);
                    }
                    $data['main_image'] = 'images/recipes/' . $filename;
                }
            }
            $toBeDeleted = $this->recipe->images()->pluck('id')->diff(collect($this->existing_images));

            if ($toBeDeleted->count()) {
                $deletes = $this->recipe->images()->whereIn('id', $toBeDeleted->toArray())->get();
                foreach ($deletes as $delete) {
                    Storage::delete($delete->getAttributes()['url']);
                    $delete->delete();
                }
            }

            foreach ($this->images as $file) {
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $filename = Str::slug($filename);
                if ($file->storeAs('public/images/recipes/', $filename)) {
                    $this->recipe->images()->create([
                        'url' => 'images/recipes/' . $filename,
                    ]);
                }
            }

            $this->validate();

            try {
                $this->recipe->update($data);

                $this->recipe->categories()->detach();
                foreach ($this->categories as $category) {
                    $this->recipe->categories()->attach($category);
                }
                DB::commit();
            } catch (\Exception $e) {
                Log::error('Error updating recipe.' . $e->getMessage());
                Log::error($e->getTraceAsString());
                DB::rollBack();
            }
        });
        session()->flash('message', __('trx.recipe_updated'));

        return redirect()->to(route('recipe.my-index'));
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

    public function toggleExistingImage($id)
    {
        if (in_array($id, $this->existing_images)) {
            $pos = array_search($id, $this->existing_images);
            unset($this->existing_images[$pos]);
        } else {
            $existing_images[] = $id;
        }
    }

    protected function rules()
    {
        $rules = [
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
            'images' => 'array|max:' . $this->maxNewImages,
        ];

        if (!$this->existing_main_image) {
            $rules['main_image'] = 'required|image|mimes:jpeg,jpg,png';
        }
        return $rules;
    }
}
