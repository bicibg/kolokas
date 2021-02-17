<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class RecipeCreate extends Component
{
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
    public $categories = [];
    public $prep_time = null;
    public $cook_time = null;
    public $servings = null;

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
        $this->tab3Check = !empty($this->categories) && !empty($this->prep_time) && !empty($this->cook_time) && !empty($this->servings);
        $this->tab4Check = !empty($this->instructions[$this->locale]) && !empty($this->ingredients[$this->locale]);
        $this->canSubmit = $this->tab1Check && $this->tab3Check && $this->tab4Check && $this->agreement;
    }

    public function render()
    {
        return view('livewire.recipe-create');
    }

    public function submit()
    {
        var_dump($this->title);
    }

    public function switchTab($tab) {
        $this->tab = $tab;
        $this->langTab = $this->locale;
    }

    public function switchLangTab($langTab) {
        $this->langTab = $langTab;
    }
}
