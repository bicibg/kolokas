<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Profile;
use App\Models\Recipe;
use Livewire\Component;

/**
 * Class RecipeSearchBox
 * @package App\Http\Livewire
 */
class RecipeSearchBox extends Component
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
     * @var array|mixed
     */
    public $cookTimes;
    /**
     * @var mixed
     */
    public $maxPrepTime;
    /**
     * @var mixed
     */
    public $maxCookTime;

    /**
     * @param int|null $resultCount
     * @param bool|null $extended
     * @param string|null $action
     */
    public function mount(?int $resultCount = null, ?bool $extended = false, ?string $action = null)
    {
        $this->extended = $extended;
        $this->action = $action ?? route('recipe.index');
        $this->locale = app()->getLocale();
        $this->resultCount = $resultCount ?? Recipe::wherePublished(true)->count();
        $this->categories = Category::all();
        $this->authors = Profile::with('user.recipes')->has('user.recipes')->orderBy('name', 'ASC')->get();

        $minPrep = Recipe::wherePublished(true)
            ->whereNotNull('prep_time')
            ->orderBy('prep_time', 'asc')
            ->first();

        $minCook = Recipe::wherePublished(true)
            ->whereNotNull('cook_time')
            ->orderBy('cook_time', 'asc')
            ->first();

        $maxPrep = Recipe::wherePublished(true)
            ->whereNotNull('prep_time')
            ->orderBy('prep_time', 'desc')
            ->first();

        $maxCook = Recipe::wherePublished(true)
            ->whereNotNull('cook_time')
            ->orderBy('cook_time', 'desc')
            ->first();

        $this->cookTimes = [
            'minPrep' => $minPrep->getAttributes()['prep_time'],
            'maxPrep' => $maxPrep->getAttributes()['prep_time'],
            'minCook' => $minCook->getAttributes()['cook_time'],
            'maxCook' => $maxCook->getAttributes()['cook_time'],
        ];
        $this->maxPrepTime = request()->get('mp', $this->cookTimes['maxPrep']);
        $this->maxCookTime = request()->get('mc', $this->cookTimes['maxCook']);
    }

    public function render()
    {
        return view('livewire.recipe-search-box');
    }

    public function hydrate()
    {
        app()->setLocale($this->locale);
    }
}
