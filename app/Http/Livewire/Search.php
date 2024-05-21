<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Search extends Component
{
    public $q;

    public function mount(){
        $this->fill(request()->only('q'));
    }
    public function render()
    {
        return view('livewire.search');
    }
}

