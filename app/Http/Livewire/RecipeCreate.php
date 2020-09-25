<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Config;
use Livewire\Component;

class RecipeCreate extends Component
{
    /**
     * @var $locale
     */
    public $locale;
    public $langs;
    public $tab1Check = false;
    public $tab2Check = false;
    public $tab3Check = false;
    public $tab4Check = false;
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

    public function mount()
    {
        $langInUse = app()->getLocale();
        $this->locale = $langInUse;
        $langs = Config::get('app.languages');
        unset($langs[$langInUse]);
        $this->langs = array_keys($langs);
    }

    public function hydrate()
    {
        app()->setLocale($this->locale);
        $this->tab1Check = !empty($this->title[$this->locale]) && !empty($this->description[$this->locale]);

    }

    public function render()
    {
        return view('livewire.recipe-create');
    }
}
