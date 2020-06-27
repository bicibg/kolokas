<?php

namespace App\Http\Livewire;

use App\Profile;
use Livewire\Component;

class AuthorBox extends Component
{
    /**
     * @var Profile
     */
    public $profile;

    public function render()
    {
        return view('livewire.author-box');
    }

    public function mount(Profile $profile)
    {
        $this->profile = $profile;
    }
}
