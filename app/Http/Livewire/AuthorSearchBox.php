<?php

namespace App\Http\Livewire;

use App\Models\Profile;
use Livewire\Component;

/**
 * Class AuthorSearchBox
 * @package App\Http\Livewire
 */
class AuthorSearchBox extends Component
{
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
     * @param int|null $resultCount
     * @param string|null $action
     */
    public function mount(?int $resultCount = null, ?string $action = null)
    {
        $this->action = $action ?? route('profile.index');
        $this->locale = app()->getLocale();
        $this->resultCount = $resultCount ?? Profile::with('user.recipes')->has('user.recipes')->count();
    }

    public function render()
    {
        return view('livewire.author-search-box');
    }

    public function hydrate()
    {
        app()->setLocale($this->locale);
    }
}
