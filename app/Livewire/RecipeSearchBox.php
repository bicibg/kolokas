<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Profile;
use App\Models\Recipe;
use Illuminate\Support\Facades\Cache;
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

        $stats = Cache::remember('search.cook_time_stats', 3600, function () {
            return Recipe::wherePublished(true)
                ->selectRaw('
                    MIN(prep_time) as min_prep,
                    MAX(prep_time) as max_prep,
                    MIN(cook_time) as min_cook,
                    MAX(cook_time) as max_cook
                ')
                ->first();
        });

        $this->cookTimes = [
            'minPrep' => $stats->min_prep ? max(0, $stats->min_prep - 20) : 0,
            'maxPrep' => $stats->max_prep ? $stats->max_prep + 20 : 0,
            'minCook' => $stats->min_cook ? max(0, $stats->min_cook - 20) : 0,
            'maxCook' => $stats->max_cook ? $stats->max_cook + 20 : 0,
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
