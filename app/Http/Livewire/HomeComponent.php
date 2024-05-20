<?php

namespace App\Http\Livewire;
use App\Models\Category;
use Livewire\Component;
use App\Models\User;
use App\Models\Brand;
class HomeComponent extends Component
{
    public $sellerId;
    

    public function render()
    {
        $sellerInfo = User::where('id', $this->sellerId)->first();
        $categories = Category::orderBy('name','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        return view('livewire.home-component',['categories'=>$categories,'brands'=>$brands, 'seller' => $sellerInfo]);
    }
}
