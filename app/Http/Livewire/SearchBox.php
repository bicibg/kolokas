<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Profile;
use App\Models\Recipe;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Class SearchBox
 * @package App\Http\Livewire
 */
class SearchBox extends Component
{
    /**
     * @var bool|null
     */
    public $extended;
    /**
     * @var mixed|string
     */
    public $action;
    /**
     * @var mixed|string
     */
    public $locale;
    /**
     * @var int
     */
    public $resultCount;
    /**
     * @var Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public $categories;
    /**
     * @var \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public $authors;

    /**
     * @param  int|null  $resultCount
     * @param  bool|null  $extended
     * @param  string|null  $action
     */
    public function mount(?int $resultCount = null, ?bool $extended = false, ?string $action = null)
    {
        $this->extended = $extended;
        $this->action = $action ?? route('recipe.index');
        $this->locale = app()->getLocale();
        $this->resultCount = $resultCount ?? Recipe::wherePublished(true)->count();
        $this->categories = Category::all();
        $this->authors = Profile::with('user.recipes')->has('user.recipes')->orderBy('name', 'ASC')->get();
    }

    public function render()
    {
        return view('livewire.search-box');
    }

    public function hydrate()
    {
        app()->setLocale($this->locale);
    }
}
