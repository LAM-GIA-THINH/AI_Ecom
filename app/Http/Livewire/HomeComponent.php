<?php

namespace App\Http\Livewire;
use App\Models\Category;
use App\Models\HomeSlider;
use Livewire\Component;
use App\Models\User;
use App\Models\Brand;

class HomeComponent extends Component
{
    public $sellerId;
    public $slides;

    public function render()
    {
        $sellerInfo = User::where('id', $this->sellerId)->first();
        $categories = Category::orderBy('name','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        $this->slides = HomeSlider::where('status',1)->get();

        return view('livewire.home-component', [
            'categories' => $categories,
            'brands' => $brands,
            'seller' => $sellerInfo,
            'slides' => $this->slides
        ]);
    }
}
