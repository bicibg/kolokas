<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class RecipeEdit extends Component
{
    use WithFileUploads;

    public $recipe;
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
        $this->prep_time = $recipe->getAttributes()['prep_time'];
        $this->cook_time = $recipe->getAttributes()['cook_time'];

        $path_parts = pathinfo($this->recipe->main_image->getAttributes()['url']);
        $newPath = $path_parts['dirname'] . '/tmp-files/';
        if(!is_dir (storage_path($newPath))){
            mkdir(storage_path($newPath), 0777, true);
        }

        $newUrl = $newPath . $path_parts['basename'];
        copy($this->recipe->main_image->getAttributes()['url'], $newUrl);
        $imgInfo = getimagesize($newUrl);
//broken
        $file = new UploadedFile(
            $newUrl,
            $path_parts['basename'],
            $imgInfo['mime'],
            filesize($this->recipe->main_image->getAttributes()['url']),
            true,
            TRUE
        );
dd($file);
        $this->main_image = File::get();
        dd($this->main_image);
        $this->images = $recipe->images()->whereMain(false)->get();

        $this->tab1Check = !empty($this->title[$this->locale]);
        $this->tab2Check = !empty($this->main_image);
        $this->tab3Check = !empty($this->categories) && !empty($this->prep_time) && !empty($this->cook_time) && !empty($this->servings);
        $this->tab4Check = !empty($this->instructions[$this->locale]) && !empty($this->ingredients[$this->locale]);
        $this->canSubmit = $this->tab1Check && $this->tab2Check && $this->tab3Check && $this->tab4Check && $this->agreement;
    }

    public function updated()
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

    protected function rules()
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
        if (!$this->recipe->author->is(auth()->user())) {
            session(['flash-error' => __('messages.recipe.edit_not_authorized')]);
            return redirect(route('home'));
        }

        $this->validate();

        if ($this->recipe->images()->whereMain(false)->get()->diffAssoc($this->images)->count()) {
            $this->validate(['images.*' => 'bail|image|mimes:jpeg,jpg,png']);
        }

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

            try {
                $this->recipe->update($data);

                $this->recipe->categories()->detach();
                foreach ($this->categories as $category) {
                    $this->recipe->categories()->attach($category);
                }

                if (!$this->recipe->main_image->is($this->main_image)) {
                    $allowedfileExtension = ['jpg', 'jpeg', 'png'];
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

                if ($this->recipe->images()->whereMain(false)->get()->diffAssoc($this->images)->count()) {
                    foreach ($this->recipe->images()->whereMain(false)->get() as $delete) {
                        Storage::delete($delete->url);
                        $delete->delete();
                    }

                    if (count($this->images)) {
                        foreach ($this->images as $file) {
                            $filename = $this->recipe->id . '_' . $file->getClientOriginalName() . '_' . uniqid();
                            $extension = $file->getClientOriginalExtension();
                            $check = in_array($extension, $allowedfileExtension);
                            if ($check) {
                                $filename .= '.' . $extension;

                                if ($file->storeAs('public/images/recipes/', $filename)) {
                                    $this->recipe->images()->create([
                                        'url' => 'images/recipes/' . $filename,
                                        'main' => 0
                                    ]);
                                }
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
        session()->flash('message', __('messages.recipe.updated'));

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
}
