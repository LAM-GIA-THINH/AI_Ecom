<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;
use Illuminate\Support\Str;

class AdminBrandEditComponent extends Component
{
    public $name;
    public $slug;
    public $brand_id;

    public function generateSlug()
    {
        $this->slug= Str::slug($this->name);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required'
        ]);
    }    

    public function mount($brand_id)
    {
        $brand = Brand::find($brand_id);
        $this->brand_id = $brand->id;
        $this->name = $brand->name;
        $this->slug = $brand->slug;
    }
    

    public function updateBrand()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required'
        ]);
        $brand = Brand::find($this->brand_id);
        $brand->name= $this->name;
        $brand->slug= $this->slug;
        $brand->save();
        session()->flash('message', 'Đã cập nhật nhà phát hành thành công!');
    }
    public function render()
    {
        return view('livewire.admin.admin-brand-edit-component')->layout('layouts.guest') ;
    }
}
