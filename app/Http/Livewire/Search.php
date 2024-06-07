<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class Search extends Component
{
    public $q ;
    public $products = [];
    public function mount(){
        $this->fill(request()->only('q'));
    }
    public function updatedQ()
    {
        if (strlen($this->q) > 1) {
            $this->products = Product::where('name', 'like', '%' . $this->q . '%')
                                     ->orWhere('description', 'like', '%' . $this->q . '%')
                                     ->select('id', 'name', 'regular_price', 'image', 'slug')
                                     ->take(5)
                                     ->get();
        } else {
            $this->products = [];
        }
        
    }

    public function render()
    {
        return view('livewire.search');
    }
}