<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
    public $maxNewImages = 5;

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

    public function updated()
    {
        app()->setLocale($this->locale);
        $this->tab1Check = !empty($this->title[$this->locale]);
        $this->tab2Check = !empty($this->main_image);
        $this->tab3Check = !empty($this->categories) && !empty($this->servings[$this->locale]);
//        $this->tab3Check = !empty($this->categories) && !empty($this->prep_time) && !empty($this->cook_time) && !empty($this->servings);
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

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $filename = uniqid() . '_' . $this->main_image->getClientOriginalName();
            $filename = Str::slug($filename);

            if ($this->main_image->storeAs('public/images/recipes/', $filename)) {
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
                    'main_image' => 'images/recipes/' . $filename
                ]);

                foreach ($this->categories as $category) {
                    $recipe->categories()->attach($category);
                }
            }

            foreach ($this->images as $file) {
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $filename = Str::slug($filename);
                if ($file->storeAs('public/images/recipes/', $filename)) {
                    $recipe->images()->create([
                        'url' => 'images/recipes/' . $filename,
                    ]);
                }
            }
        });

        session()->flash('message', __('trx.recipe_submitted_message'));

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
            'prep_time' => 'integer|nullable',
            'cook_time' => 'integer|nullable',
            'servings.' . $this->locale => 'required|max:64',
            'notes.' . $this->locale => 'max:4000',
            'agreement' => 'accepted',
            'main_image' => 'required|image|mimes:jpeg,jpg,png',
            'images.*' => 'image|mimes:jpeg,jpg,png',
        ];
    }
}
