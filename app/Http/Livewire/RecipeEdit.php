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

        $this->existing_main_image = $this->recipe->images()->whereMain(true)->first();
        $this->existing_images = $recipe->images()->whereMain(false)->pluck('id')->toArray();
        foreach ($this->existing_images as $key => $value) {
            $this->existing_images[$key] = (string)$value;
        }
        $toBeDeleted = $this->recipe->images()->whereMain(false)->pluck('id')->diffAssoc($this->existing_images);
        $this->maxNewImages = 5 - ($this->recipe->images()->whereMain(false)->count() - count($toBeDeleted));

        $this->tab1Check = !empty($this->title[$this->locale]);
        $this->tab2Check = !empty($this->existing_main_image);
        $this->tab3Check = !empty($this->categories) && !empty($this->servings[$this->locale]);
//        $this->tab3Check = !empty($this->categories) && !empty($this->prep_time) && !empty($this->cook_time) && !empty($this->servings);
        $this->tab4Check = !empty($this->instructions[$this->locale]) && !empty($this->ingredients[$this->locale]);
        $this->canSubmit = $this->tab1Check && $this->tab2Check && $this->tab3Check && $this->tab4Check && $this->agreement;
    }

    public function updated()
    {
        app()->setLocale($this->locale);
        $this->tab1Check = !empty($this->title[$this->locale]);
        $this->tab2Check = !empty($this->main_image) || !empty($this->existing_main_image);
        $this->tab3Check = !empty($this->categories) && !empty($this->servings[$this->locale]);
//        $this->tab3Check = !empty($this->categories) && !empty($this->prep_time) && !empty($this->cook_time) && !empty($this->servings);
        $this->tab4Check = !empty($this->instructions[$this->locale]) && !empty($this->ingredients[$this->locale]);

        $this->canSubmit = $this->tab1Check && $this->tab2Check && $this->tab3Check && $this->tab4Check && $this->agreement;

        $toBeDeleted = $this->recipe->images()->whereMain(false)->pluck('id')->diffAssoc($this->existing_images);
        $this->maxNewImages = 5 - ($this->recipe->images()->whereMain(false)->count() - count($toBeDeleted));
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
        $this->validate();

        foreach ($this->title as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && collect($this->langs)->contains($lang)) {
                if ($translation = translate($this->title[$this->locale], $lang)) {
                    $this->title[$lang] = $translation['text'];
                }
            }
        }

        foreach ($this->description as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && collect($this->langs)->contains($lang)) {
                if ($translation = translate($this->description[$this->locale], $lang)) {
                    $this->description[$lang] = $translation['text'];
                }
            }
        }

        foreach ($this->instructions as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && collect($this->langs)->contains($lang)) {
                if ($translation = translate($this->instructions[$this->locale], $lang)) {
                    $this->instructions[$lang] = $translation['text'];
                }
            }
        }

        foreach ($this->ingredients as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && collect($this->langs)->contains($lang)) {
                if ($translation = translate($this->ingredients[$this->locale], $lang)) {
                    $this->ingredients[$lang] = $translation['text'];
                }
            }
        }

        foreach ($this->notes as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && collect($this->langs)->contains($lang)) {
                if ($translation = translate($this->notes[$this->locale], $lang)) {
                    $this->notes[$lang] = $translation['text'];
                }
            }
        }

        foreach ($this->servings as $lang => $value) {
            if ($lang === $this->locale) continue;
            if (empty($value) && collect($this->langs)->contains($lang)) {
                if ($translation = translate($this->servings[$this->locale], $lang)) {
                    $this->servings[$lang] = $translation['text'];
                }
            }
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
                'servings' => $this->servings
            ];
            $allowedfileExtension = ['jpg', 'jpeg', 'png'];

            try {
                $this->recipe->update($data);

                $this->recipe->categories()->detach();
                foreach ($this->categories as $category) {
                    $this->recipe->categories()->attach($category);
                }

                if ($this->main_image) {
                    $mainPhoto = $this->main_image;
                    //main photo
                    $filename = $this->recipe->id . '_' . $mainPhoto->getClientOriginalName() . '_' . uniqid();
                    $extension = $mainPhoto->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                    if ($check) {
                        $filename .= '.' . $extension;
                        $oldImage = $this->recipe->images()->whereMain(true)->first();
                        if ($mainPhoto->storeAs('public/images/recipes/', $filename)) {
                            if (file_exists($oldImage->getAttributes()['url'])) {
                                Storage::delete($oldImage->getAttributes()['url']);
                            }
                            $this->recipe->images()->whereMain(true)->update([
                                'url' => 'images/recipes/' . $filename,
                            ]);
                        }
                    }
                }

                $toBeDeleted = $this->recipe->images()->whereMain(false)->pluck('id')->diffAssoc($this->existing_images);
                if ($toBeDeleted->count()) {
                    $deletes = $this->recipe->images()->whereMain(false)->whereIn('id', $toBeDeleted->toArray())->get();
                    foreach ($deletes as $delete) {
                        Storage::delete($delete->getAttributes()['url']);
                        $delete->delete();
                    }
                }
                // other photos
                if (count($this->images)) {
                    foreach ($this->images as $file) {
                        $filename = $this->recipe->id . '_' . uniqid() . '_' . $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();

                        $check = in_array($extension, $allowedfileExtension);
                        if ($check) {
                            if ($file->storeAs('public/images/recipes/', $filename)) {
                                $this->recipe->images()->create([
                                    'url' => 'images/recipes/' . $filename,
                                    'main' => 0
                                ]);
                            }
                        }
                    }
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
