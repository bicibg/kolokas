<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RecipeSearch extends Component
{

    public $searchTerm = '';

    public function mount() {
        if (request()->get('s')) {
            $this->searchTerm = request()->get('s');
        }
    }

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $this->emit('searchTerm', $searchTerm);
        return view('livewire.recipe-search');
    }
}
